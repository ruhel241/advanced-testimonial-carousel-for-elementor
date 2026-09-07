<template>
    <div class="atcfe-settings-page">
        <el-radio-group v-model="settingTabMenu"  @change="settingTabChangeHandler" style="margin-bottom: 30px !important; ">
            <el-radio-button class="atcfe-tab-btn" label="google_reviews_settings">
                <i class="el-icon-setting"></i>
                Google Reviews Settings
            </el-radio-button>
            <el-radio-button class="atcfe-tab-btn" label="reviews_lists">
                <i class="el-icon-circle-plus-outline"></i>
                Reviews Lists
            </el-radio-button>
            <el-radio-button class="atcfe-tab-btn" label="license_settings" v-if="hasPro">
                <i class="el-icon-lock"></i>
                License Settings
            </el-radio-button>
        </el-radio-group>

        <div class="atcfe-tab-content">
            <div class="atcfe-tab-pane active" v-if="settingTabMenu === 'google_reviews_settings'">
                <GoogleReviewsSettings/>
            </div>
            <div class="atcfe-tab-pane active" v-if="settingTabMenu === 'reviews_lists'">
                <GoogleReviews/>
            </div>
        </div>       
    </div>
</template>

<script>

import GoogleReviewsSettings from './component/GoogleReviews/GoogleReviewsSettings.vue';
import GoogleReviews from './GoogleReviews.vue'

export default {
    name: 'Settings',
    components: {
        GoogleReviews,
        GoogleReviewsSettings,
    },
    data() {
        return {
            settingTabMenu: localStorage.getItem('atcfe_google_review_active_menu') || 'google_reviews_settings',
            hasPro: false,
        };
    },
    methods: {
        settingTabChangeHandler(val) {
            localStorage.setItem('atcfe_google_review_active_menu', val)
        },
    }
};

</script>