<template>
    <div class="atc-google-place-reviews">
        <div class="atc-page-header">
            <!-- {{ place }} -->
            <div>
                <el-button
                    type="text"
                    icon="el-icon-arrow-left"
                    @click="$emit('back')"
                >
                    Back to Places
                </el-button>
                
                <h1 v-if="place && place.name">
                    {{ place.name }}
                </h1>

                <p v-if="place && place.place_id">
                    Place ID: {{ place.place_id }}
                </p>
            </div>
            <div>
                <el-button
                    type="primary"
                    icon="el-icon-refresh"
                    @click="fetchReviews"
                    :loading="saving">
                    Fetch Reviews
                </el-button>
            </div>
        </div>
        <el-card v-loading="fetching">
            <div class="atc-review-summary">
                <div class="atc-review-counts">
                    <strong>
                        {{ reviews.length }}
                    </strong>
                    <span class="atc-gray-color">
                        Imported Reviews
                    </span>
                </div>
                <div class="atc-download-method-wrapper">
                    <strong class="atc-download-method" @click="editDownloadMethod">
                        {{handler(configs.download_method) }}
                        <i class="el-icon-edit"></i>
                    </strong>
                    <span class="atc-gray-color">
                        Download Method
                    </span>
                    <el-dialog
                        title="Edit Download Method"
                        :visible.sync="downloadMethodDialog"
                        width="450px"
                        class="atc-review-download-method"
                    >
                        <el-form label-position="top">
                            <el-form-item label="Download Method">
                                <el-select
                                    v-model="configs.download_method"
                                    placeholder="Select"
                                    class="atc-download-method-select-options"
                                    >
                                    <el-option
                                        v-for="item in downloadMethods"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    />
                                </el-select>
                                <div class="atc-field-description">
                                    Choose how reviews should be fetched from Google.
                                </div>
                            </el-form-item>
                        </el-form>

                        <span slot="footer">
                            <el-button
                                @click="downloadMethodDialog = false"
                            >
                                Cancel
                            </el-button>
                            <el-button
                                type="primary"
                                :loading="savingDownloadMethod"
                                @click="saveDownloadMethod"
                                disable
                            >
                                Save
                            </el-button>
                        </span>
                    </el-dialog>
                </div>
                <div class="atc-auto-fetch-switch">
                    <span
                        class="atc-auto-fetch-label"
                        :class="{ 'is-active': configs.auto_fetch === 'yes' }"
                    >
                        Auto Fetch Reviews
                    </span>

                    <el-switch
                        v-model="configs.auto_fetch"
                        active-color="#409EFF"
                        inactive-color="#C0C4CC"
                        active-value="yes"
                        inactive-value="no"
                        @change="fetchReviews"
                    />
                </div>
            </div>

            <div class="atc-table-responsive">
                <el-table
                    :data="reviews"
                    border
                    stripe
                    style="width: 100%"
                >
                    <!-- Reviewer -->
                    <el-table-column
                        label="Reviewer"
                        min-width="180"
                    >
                        <template slot-scope="scope">
                            <div class="atc-reviewer">
                                <img
                                    v-if="scope.row.author_photo"
                                    :src="scope.row.author_photo"
                                    alt=""
                                />
                                <div>
                                    <strong>
                                        {{ scope.row.author_name }}
                                    </strong>
                                    <small>
                                        {{ scope.row.date }}
                                    </small>
                                </div>
                            </div>
                        </template>
                    </el-table-column>

                    <!-- Rating -->
                    <el-table-column
                        label="Rating"
                        width="150"
                    >
                        <template slot-scope="scope">
                            <el-rate
                                :value="Number(scope.row.rating)"
                                disabled
                                :max="5"
                            />
                        </template>
                    </el-table-column>
                 
                    <el-table-column
                        label="Review"
                        min-width="400"
                    >
                        <template slot-scope="scope">
                            <div class="atc-review-text">
                                <template v-if="isReviewExpanded(scope.row.id)">
                                    {{ scope.row.review_text }}

                                    <el-button
                                        type="text"
                                        class="atc-review-toggle"
                                        @click="toggleReview(scope.row.id)"
                                    >
                                        Less
                                    </el-button>
                                </template>

                                <template v-else>
                                    {{ truncateWords(scope.row.review_text, 20) }}

                                    <el-button
                                        v-if="getWordCount(scope.row.review_text) > 20"
                                        type="text"
                                        class="atc-review-toggle"
                                        @click="toggleReview(scope.row.id)"
                                    >
                                        More
                                    </el-button>
                                </template>
                            </div>
                        </template>
                    </el-table-column>

                    <!-- Action -->
                    <el-table-column
                        label="Action"
                        width="100"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <el-button
                                type="danger"
                                icon="el-icon-delete"
                                size="mini"
                                @click="handleDeleteModal(scope.row.id)"
                            />
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>

        <UpgradePopupModal :visible.sync="upgradeToProDialog"/>
    </div>
</template>

<script>
import UpgradePopupModal from '../UpgradePopupModal.vue';

export default {
    name: 'GooglePlaceReviews',
    props: {
        place_id: {
            type: String,
            required: true,
        },
    },
    components: {
        UpgradePopupModal
    },

    data() {
        return {
            fetching: false,
            saving: false,
            reviews: [],
            place: [],
            configs: [],
            expandedReviews: [],
            downloadMethodDialog: false,
            savingDownloadMethod: false,
            downloadMethods: [
                {
                    value: 'most_relevant',
                    label: 'Most Relevant'
                },
                {
                    value: 'newest',
                    label: 'Newest'
                },
            ],
            hasPro: !!window.atcAdminVars.has_pro,
            upgradeToProDialog: false
        };
    },

    methods: {
        handler(downloadMethod) {
            if (downloadMethod === 'most_relevant') {
                return 'Most Relevant';
            }

            if (downloadMethod === 'newest') {
                return 'Newest';
            }
            return '';
        },
        getWordCount(text) {
            if (!text) {
                return 0;
            }

            return text.trim().split(/\s+/).length;
        },

        truncateWords(text, limit = 50) {
            if (!text) {
                return '';
            }

            const words = text.trim().split(/\s+/);

            if (words.length <= limit) {
                return text;
            }

            return words.slice(0, limit).join(' ') + '...';
        },

        isReviewExpanded(id) {
            return this.expandedReviews.indexOf(id) !== -1;
        },

        toggleReview(id) {
            const index = this.expandedReviews.indexOf(id);

            if (index === -1) {
                this.expandedReviews.push(id);
            } else {
                this.expandedReviews.splice(index, 1);
            }
        },

        // get google reviews by place id
        getGoogleReviews() {
            this.fetching = true;
            this.$get({
                action: 'atc_google_reviews_settings_admin_ajax',
                route: 'get_google_reviews_by_place_id',
                place_id: this.place_id,
                nonce: window.atcAdminVars.nonce
            })
                .then(response => {
                    setTimeout(() => {
                        this.reviews  = response.data.reviews;
                        this.place    = response.data.place;
                        this.configs =  {
                            place_id: this.place.place_id,
                            download_method: this.place.download_method,
                            auto_fetch: this.place.auto_fetch
                        },

                        this.fetching = false;
                    }, 1000);
                })
                .fail(error => {
                    this.$handleError(error);
                });
        },

        editDownloadMethod() {
            this.downloadMethodDialog = true;       
        },

        saveDownloadMethod() {
            this.savingDownloadMethod = false;
            this.downloadMethodDialog = false;
            this.fetchReviews();
        },

        // fetch reviews from google api and save to database
        fetchReviews() {
            if (!this.hasPro) {
                this.upgradeToProDialog = true;
                this.configs.download_method = 'most_relevant';
                this.configs.auto_fetch = 'no';
                return;
            }

            this.saving = true;
            this.fetching = true;
            this.$post({
                action: 'atc_google_reviews_settings_admin_ajax',
                route: 'save_google_place',
                configs: this.configs,
                action_type: 'update',
                nonce: window.atcAdminVars.nonce
            })
                .then(response => {
                    this.getGoogleReviews();
                    setTimeout(() => {
                        this.$handleSuccess('Reviews fetched successfully.');
                    }, 1000);
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
       
        handleDeleteModal(id) {
            this.$confirm( `Are you sure you want to delete this permanently`, 'Warning', {
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                type: 'warning',
            })
                .then(() => {
                    this.performAction("delete", id);
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        offset: 50,
                        showClose: true,
                        message: "Delete canceled",
                    });
                });     
        },
        performAction(type, id) {
            this.$post({
                action: "atc_google_reviews_settings_admin_ajax",
                route: "maybe_delete_google_review",
                id: id,
                action_type: type,
                nonce: window.atcAdminVars.nonce,
            })
                .then((response) => {
                    this.$handleSuccess(response.data.message);
                    this.getGoogleReviews();
                })
                .fail((error) => {
                    this.$handleError(error);
                })
                .always(() => {});
        },
        
    },
    mounted() {
        setTimeout(() => {
            this.getGoogleReviews();
        }, 0);
    }
};
</script>
