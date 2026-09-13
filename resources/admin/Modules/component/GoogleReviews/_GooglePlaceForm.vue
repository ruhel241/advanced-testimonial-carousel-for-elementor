<template>
    <div class="atcfe-google-place-form">
        <!-- =========================
             PAGE HEADER
        ========================== -->
        <div class="atcfe-page-header">
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
            class="atcfe-form-card"
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
                    <div class="atcfe-field-description">

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

                    <div class="atcfe-field-description">
                        Select how reviews should be
                        fetched from Google.
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
                    class="atcfe-verification-success"
                >
                    <div
                        class="atcfe-verification-icon"
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
                        <div class="atcfe-place-meta">
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

                <el-form-item label="Auto Fetch Reviews">
                    <el-switch
                        v-model="configs.auto_fetch"
                        active-text="Enabled"
                        inactive-text="Disabled"
                    />
                    <div class="atcfe-field-description">
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
    </div>
</template>

<script>
export default {
    name: 'GooglePlaceForm',
    props: {
        savePlace: {
            type: String,
            default: '',
        },
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
                auto_fetch: true,
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
        };
    },


    methods: {
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
};

</script>

<style scoped>
.atcfe-page-header {
    margin-bottom: 20px;
}
.atcfe-page-header h1 {
    margin: 5px 0 8px;
    font-size: 24px;
}

.atcfe-page-header p {
    margin: 0;
    color: #777;
}
.atcfe-form-card {
    max-width: 800px;
}

.atcfe-field-description {
    margin-top: 6px;
    color: #888;
    font-size: 13px;
    line-height: 1.5;
}
.atcfe-verification-success {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin: 10px 0 25px;
    padding: 18px;
    border: 1px solid #b7eb8f;
    border-radius: 4px;
    background: #f6ffed;
}


.atcfe-verification-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #67c23a;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    flex-shrink: 0;
}

.atcfe-verification-success strong {
    display: block;
    margin-bottom: 5px;
}

.atcfe-verification-success p {
    margin: 0 0 4px;
    font-weight: 600;
}

.atcfe-verification-success span {
    color: #777;
}

.atcfe-place-meta {
    display: flex;
    gap: 20px;
    margin-top: 10px;
}

@media (max-width: 600px) {
    .atcfe-place-meta {
        flex-direction: column;
        gap: 5px;
    }
}
</style>