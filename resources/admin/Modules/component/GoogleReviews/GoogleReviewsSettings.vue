<template>
    <div class="atcfe-settings">
        <div class="atcfe-page-header">
            <div>
                <h1>Google Reviews Settings</h1>
                <p>
                    Configure your Google Places API connection and review
                    synchronization settings.
                </p>
            </div>
        </div>
        <el-card
            shadow="never"
            class="atcfe-settings-card"
            v-loading="fetching"
        >
        <!--     :rules="rules" -->
            <el-form
                ref="settingsForm"
                label-position="top"
            >
                <!-- Google API Key -->
                <el-form-item
                    label="Google API Key"
                    prop="configs.api_key"
                    :rules="rules"
                >

                    <el-input
                        v-model="configs.api_key"
                        type="password"
                        show-password
                        placeholder="Enter your Google API Key"
                    />

                    <div class="atcfe-field-description">
                        Your Google Places API key used to fetch Google
                        Business information and reviews.
                    </div>

                </el-form-item>


                <!-- Auto Fetch -->
                <!-- <el-form-item label="Auto Fetch Reviews">

                    <el-switch
                        v-model="settings.auto_fetch"
                        active-text="Enabled"
                        inactive-text="Disabled"
                    />

                    <div class="atcfe-field-description">
                        Automatically check for new Google reviews using
                        WP-Cron.
                    </div>

                </el-form-item> -->


                <!-- Save -->
                <el-form-item>
                    <el-button
                        type="primary"
                        :loading="saving"
                        @click="saveGoogleApiKey"
                    >
                        Save Settings
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
import GoogleReviews from "./GoogleReviews.vue"
export default {
    name: 'GoogleReviewsSettings',
    components: {
        GoogleReviews
    },
    data() {
        return {
            saving: false,
            fetching: false,
            configs: {
                api_key: '',
                auto_fetch: true,
            },
            rules: {
                api_key: [
                    {
                        required: true,
                        message: 'Google API Key is required',
                        trigger: 'blur',
                    },
                ],
            },
        };
    },
    methods: {
        getGoogleApiKey() {
            this.fetching = true;
            this.$get({
                action: 'atc_google_reviews_settings_admin_ajax',
                route: 'get_google_api_key',
                nonce: window.atcAdminVars.nonce
            })
                .then(response => {
                    setTimeout(() => {
                        this.configs = response.data.configs;
                        this.fetching = false;
                    }, 1000);
                })
                .fail(error => {
                    this.fetching = false;
                    this.$handleError(error);
                });
        },

        saveGoogleApiKey() {
            this.saving = true;
            this.fetching = true;
            this.$post({
                action: 'atc_google_reviews_settings_admin_ajax',
                route: 'save_google_api_key',
                configs: this.configs,
                nonce: window.atcAdminVars.nonce
            })
                .then(response => {
                    this.configs = response.data.configs;
                    this.getGoogleApiKey();
                    this.$handleSuccess(response.data.message);
                })
                .fail(error => {
                    this.$handleError(error);
                })
                .always(() => {
                    setTimeout(() => {
                        this.saving = false;
                    }, 1000);
                });
                
        },
    },
    mounted() {
        setTimeout(() => {
            this.getGoogleApiKey();
        }, 500);  
    },
};
</script>

<style scoped>

.atcfe-settings {
    max-width: 1200px;
    margin: 30px 0;
}

.atcfe-page-header {
    margin-bottom: 20px;
}

.atcfe-page-header h1 {
    margin: 0 0 8px;
    font-size: 24px;
}

.atcfe-page-header p {
    margin: 0;
    color: #777;
}

.atcfe-settings-card {
    max-width: 800px;
}

.atcfe-field-description {
    margin-top: 6px;
    color: #888;
    font-size: 13px;
    line-height: 1.5;
}

</style>