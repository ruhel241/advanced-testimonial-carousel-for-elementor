<template>
    <div class="atc-upgrade-popup">
        <el-dialog
            :visible.sync="dialogVisible"
            width="450px"
            class="atc-upgrade-pro-dialog"
            :show-close="true"
            :close-on-click-modal="true"
            :close-on-press-escape="true"
        >
            <div class="atc-upgrade-content">

                <div class="atc-upgrade-icon">
                    <i class="el-icon-star-on"></i>
                </div>

                <h3 class="atc-upgrade-title">
                    Upgrade to Pro
                </h3>

                <p class="atc-upgrade-description">
                    Unlock powerful features and take your testimonial
                    management to the next level.
                </p>

                <div class="atc-upgrade-features">

                    <div class="atc-upgrade-feature">
                        <span class="atc-feature-icon">
                            <i class="el-icon-circle-check"></i>
                        </span>

                        <span>
                            Access advanced Google Reviews features
                        </span>
                    </div>

                    <div class="atc-upgrade-feature">
                        <span class="atc-feature-icon">
                            <i class="el-icon-circle-check"></i>
                        </span>

                        <span>
                            Unlock premium features
                        </span>
                    </div>

                    <div class="atc-upgrade-feature">
                        <span class="atc-feature-icon">
                            <i class="el-icon-circle-check"></i>
                        </span>

                        <span>
                            Get more powerful testimonial controls
                        </span>
                    </div>

                </div>

                <div class="atc-upgrade-actions">

                    <el-button
                        @click="dialogVisible = false"
                    >
                        Maybe Later
                    </el-button>

                    <el-button
                        type="primary"
                        class="atc-upgrade-button"
                        @click="upgradeToProLink"
                    >
                        <i class="el-icon-star-on"></i>
                        Upgrade to Pro
                    </el-button>

                </div>

            </div>
        </el-dialog>
    </div>
</template>

<script>
export default {
    name: 'upgrade-popup-modal',

    props: {
        visible: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        dialogVisible: {
            get() {
                return this.visible;
            },

            set(value) {
                this.$emit('update:visible', value);
            }
        }
    },

    methods: {

        upgradeToProLink() {
            window.open(
                'https://wpcreativeidea.com/testimonial',
                '_blank',
                'noopener,noreferrer'
            );
        }

    }
};
</script>