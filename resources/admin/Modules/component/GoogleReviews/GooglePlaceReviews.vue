<template>
    <div class="atcfe-google-place-reviews">
        <div class="atcfe-page-header">
            <div>
                <el-button
                    type="text"
                    icon="el-icon-arrow-left"
                    @click="$emit('back')"
                >
                    Back to Places
                </el-button>
                <h1>
                    {{ place.name }}
                </h1>
                <p>
                  Place ID:  {{ place.place_id }}
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

        <el-card shadow="never" v-loading="fetching">
            <div class="atcfe-review-summary">
                <div>
                    <strong>
                        {{ reviews.length }}
                    </strong>
                    <span>
                        Imported Reviews
                    </span>

                </div>
                <div>
                    <strong>
                        {{ place.download_method }}
                    </strong>
                    <span>
                        Download Method
                    </span>
                </div>
            </div>

            <div class="atcfe-table-responsive">
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
                            <div class="atcfe-reviewer">
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
                    <!-- Review -->
                    <!-- <el-table-column
                        label="Review"
                        min-width="400"
                    >
                        <template slot-scope="scope">
                            <div class="atcfe-review-text">
                                {{ scope.row.review_text }}
                            </div>
                        </template>
                    </el-table-column> -->

                    <el-table-column
                        label="Review"
                        min-width="400"
                    >
                        <template slot-scope="scope">
                            <div class="atcfe-review-text">
                                <template v-if="isReviewExpanded(scope.row.id)">
                                    {{ scope.row.review_text }}

                                    <el-button
                                        type="text"
                                        class="atcfe-review-toggle"
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
                                        class="atcfe-review-toggle"
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
    </div>
</template>

<script>
export default {
    name: 'GooglePlaceReviews',
    props: {
        place: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fetching: false,
            saving: false,
            reviews: [],
            configs: {
                place_id: this.place.place_id,
                download_method: 'most_relevant',
                auto_fetch: true,
            },
            expandedReviews: []
        };
    },

    methods: {
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
                place_id: this.place.place_id,
                nonce: window.atcAdminVars.nonce
            })
                .then(response => {
                    setTimeout(() => {
                        this.reviews = response.data.reviews;
                        this.fetching = false;
                    }, 1000);
                })
                .fail(error => {
                    this.$handleError(error);
                });
        },
        // fetch reviews from google api and save to database
        fetchReviews() {
            this.saving = true;
            this.fetching = true;
            this.$post({
                action: 'atc_google_reviews_settings_admin_ajax',
                route: 'save_google_place',
                configs: this.configs,
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
                    // this.$notify({
                    //     title: "Sucess",
                    //     message: response.data.message,
                    //     type: "success",
                    // });
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

<style scoped>

.atcfe-google-place-reviews {
    max-width: 1200px;
    margin: 30px 0;
}

.atcfe-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
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

.atcfe-review-summary {
    display: flex;
    gap: 50px;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.atcfe-review-summary strong {
    display: block;
    font-size: 20px;
}

.atcfe-review-summary span {
    display: block;
    margin-top: 5px;
    color: #888;
}

.atcfe-table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.atcfe-table-responsive .el-table {
    min-width: 800px;
}

.atcfe-reviewer {
    display: flex;
    align-items: center;
    gap: 10px;
}

.atcfe-reviewer img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.atcfe-reviewer small {
    display: block;
    margin-top: 4px;
    color: #888;
}

.atcfe-review-text {
    line-height: 1.6;
}

</style>