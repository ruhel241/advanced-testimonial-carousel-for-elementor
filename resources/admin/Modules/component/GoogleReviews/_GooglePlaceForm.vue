<template>
    <div class="atc-google-place-form">
        <!-- =========================
             PAGE HEADER
        ========================== -->
        <div class="atc-page-header">
            <el-button
                type="text"
                icon="el-icon-arrow-left"
                @click="$emit('cancel')"
            >
                Back to Places
            </el-button>
            <h1>
                Add Google Place
            </h1>
            <p>
                Connect a Google Business location
                to import its reviews.
            </p>
        </div>

        <!-- =========================
             FORM CARD
        ========================== -->
        <el-card
            shadow="never"
            class="atc-form-card"
        >
            <el-form
                ref="configs"
                :model="configs"
                :rules="placeRules"
                label-position="top"
            >
                <!-- =========================
                     GOOGLE PLACE ID
                ========================== -->
                <el-form-item
                    label="Google Place ID"
                    prop="place_id"
                >
                    <el-input
                        v-model="configs.place_id"
                        placeholder="Enter Google Place ID"
                    />
                    <div class="atc-field-description">
                        Enter the Google Place ID of your
                        Google Business Profile.
                    </div>
                </el-form-item>
               
                <!-- =========================
                     DOWNLOAD METHOD
                ========================== -->

                <el-form-item
                    label="Download Method"
                    prop="download_method"
                >
                    <el-radio-group
                        v-model="configs.download_method"
                    >
                        <el-radio
                            label="most_relevant"
                        >
                            Places API: Most Relevant
                        </el-radio>
                        <el-radio
                            label="newest"
                        >
                            Places API: Newest
                        </el-radio>
                    </el-radio-group>

                    <div class="atc-field-description">
                        Select how reviews should be fetched from Google.
                    </div>
                </el-form-item>

                <!-- =========================
                     VERIFY PLACE FROM
                ========================== -->
                <el-form-item>
                    <el-button
                        type="primary"
                        :loading="verifying"
                        @click="verifyPlace"
                    >
                        Verify Place

                    </el-button>
                </el-form-item>
                <!-- =========================
                     VERIFIED PLACE
                ========================== -->
                <div
                    v-if="placeVerified"
                    class="atc-verification-success"
                >
                    <div
                        class="atc-verification-icon"
                    >
                         ✓

                    </div>
                    <div>
                        <strong>
                            Place verified successfully
                        </strong>
                        <p>
                            {{ verifiedPlace.name }}
                        </p>
                        <span>
                            {{ verifiedPlace.address }}
                        </span>
                        <div class="atc-place-meta">
                            <span>
                                ⭐
                                {{ verifiedPlace.rating }}
                            </span>
                            <span>
                                {{ verifiedPlace.review_count }}
                                reviews
                            </span>
                        </div>
                    </div>
                </div>

                <!-- =========================
                     AUTO FETCH
                ========================== -->

                <el-form-item class="atc-auto-fetch-form">
                    <div class="atc-auto-fetch-switch">
                        <span
                            class="atc-auto-fetch-label"
                            :class="{ 'is-active': configs.auto_fetch == 'yes' }"
                        >
                            Auto Fetch Reviews
                        </span>
                        <el-switch
                            v-model="configs.auto_fetch"
                            active-color="#409EFF"
                            inactive-color="#C0C4CC"
                            active-value="yes"
                            inactive-value="no"
                            @change="changeHandler"
                        />
                            <!-- @input="(value) => changeHandler(value, 'instructor_signature_img_enable')"> -->
                    </div>
                    <div class="atc-field-description" style="font-style: italic;">
                        Automatically check for new
                        reviews using WP-Cron.
                    </div>
                </el-form-item>

                <!-- =========================
                     ACTIONS
                ========================== -->
                <el-form-item>
                    <el-button @click="$emit('cancel')">
                        Cancel
                    </el-button>
                    <el-button
                        type="primary"
                        :disabled="!placeVerified"
                        :loading="saving"
                        @click="saveGooglePlace">
                        Save Google Place
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>

        <UpgradePopupModal :visible.sync="upgradeToProDialog"/>
    </div>
</template>

<script>
import UpgradePopupModal from '../UpgradePopupModal.vue';
export default {
    name: 'GooglePlaceForm',
    props: {
        savePlace: {
            type: String,
            default: '',
        },
    },
    components: {
        UpgradePopupModal
    },
    data() {
        return {
            verifying: false,
            saving: false,
            placeVerified: false,
            verifiedPlace: null,
            configs: {
                place_id: '',
                download_method: 'most_relevant',
                auto_fetch: 'no',
            },
            placeRules: {
                place_id: [
                    {
                        required: true,
                        message:  'Google Place ID is required',
                        trigger: 'blur',
                    },
                ],
                download_method: [
                    {
                       required: true,
                        message: 'Please select a download method',
                        trigger: 'change',
                    },
                ],
            },
            upgradeToProDialog: false,
            hasPro: !!window.atcAdminVars.has_pro,
        };
    },

    methods: {
        changeHandler(val) {
            if (!this.hasPro) {
                this.upgradeToProDialog = true;
                this.configs.auto_fetch = 'no';
                return;
           }
        },
        verifyPlace() {
            this.$refs.configs.validateField(
                'place_id',
                error => {

                    if (error) {
                        return;
                    }

                    this.verifying = true;
                    this.placeVerified = false;

                    this.$post({
                        action: 'atc_google_reviews_settings_admin_ajax',
                        route: 'verify_google_place',
                        nonce: window.atcAdminVars.nonce,
                        place_id: this.configs.place_id,
                        configs: this.configs
                    })
                        .then(response => {

                            this.verifying = false;

                            if (!response.success) {
                                this.$message({
                                    type: 'error',
                                    message:
                                        response.data?.message ||
                                        'Unable to verify Google Place.'
                                });

                                return;
                            }

                            this.placeVerified = true;

                            this.verifiedPlace =
                                response.data.place;

                            this.$message({
                                type: 'success',
                                message: 'Google Place verified successfully.',
                                offset: 50,
                            });
                        })
                        .catch(() => {

                            this.verifying = false;

                            this.$message({
                                type: 'error',
                                message:
                                    'Something went wrong while verifying the place.'
                            });
                        });
                }
            );
        },
        saveGooglePlace() {
            this.saving = true;
            this.fetching = true;
            this.$post({
                action: 'atc_google_reviews_settings_admin_ajax',
                route: 'save_google_place',
                configs: this.configs,
                action_type: 'new',
                nonce: window.atcAdminVars.nonce
            })
                .then(response => {
                    if (response.success === true) {
                        this.$handleSuccess( response.data.message );
                        // when save success
                        this.$emit('save-place');
                    } else {
                        this.$handleError(  response.data?.message || 'Unable to save Google Place.' );
                    }
                })
                .fail(error => {
                    this.$handleError(error);
                })
                .always(() => {
                    setTimeout(() => {
                        this.saving = false;
                        this.fetching = false;
                    }, 1000);
                });
        }
    },
    mounted() {
    }
};

</script>