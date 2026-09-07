<template>
    <div class="atcfe-google-place-list">
        <div class="atcfe-page-header">
            <div>
                <h1>Google Reviews</h1>
                <p>
                    Manage your Google Business locations and imported
                    reviews.
                </p>
            </div>
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    @click="addPlaceAction">
                    Add Google Place
                </el-button>
        </div>
        <el-card shadow="never" v-if="!addPlace">
            <div class="atcfe-table-responsive" v-loading="fetching">
                <el-table
                    :data="places"
                    border
                    stripe
                    style="width: 100%"
                >
                    <!-- Business Name -->
                    <el-table-column
                       label="Business Name"
                       width="150"
                       fixed="left"
                     >
                        <template slot-scope="scope">
                            <strong>
                                {{ scope.row.name }}
                            </strong>
                        </template>
                    </el-table-column>
                    <!-- Place ID -->
                    <el-table-column
                        label="Google Place ID"
                      width="200"
                    >
                        <template slot-scope="scope">
                            <a
                                :href="`https://www.google.com/maps/place/?q=place_id:${scope.row.place_id}`"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="atcfe-place-id"
                            >
                                {{ scope.row.place_id }}
                            </a>
                        </template>
                    </el-table-column>
                    <!-- Download Type -->
                    <el-table-column
                        label="Download Type"
                        width="150"
                    >
                        <template slot-scope="scope">
                            <el-tag
                                size="small"
                                type="info"
                            >
                                {{ scope.row.download_method }}
                            </el-tag>
                        </template>
                    </el-table-column>
                    <!-- Reviews -->
                    <el-table-column
                        label="Reviews"
                        align="center"
                       width="150"
                    >
                        <template slot-scope="scope">
                            <el-button
                                type="text"
                                @click="viewReviews(scope.row)"
                            >
                                {{ scope.row.total_reviews }}
                            </el-button>
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Total Ratings"
                        align="center"
                        width="120"
                    >
                        <template slot-scope="scope">
                            <el-rate
                                :value="Number(scope.row.rating)"
                                disabled
                                :max="5"
                            />
                        </template>
                    </el-table-column>
                    <!-- Last Synced -->
                    <el-table-column
                        label="Last Synced"
                          align="center"
                        width="150"
                    >
                        <template slot-scope="scope">
                            {{ scope.row.human_created_at }}
                        </template>
                    </el-table-column>
                    <!-- Action -->
                    <el-table-column
                       label="Action"
                       align="center"
                       width="150"
                       fixed="right"
                    >
                        <template slot-scope="scope">
                            <div class="atcfe-btn-group">
                                 <el-button
                                    type="primary"
                                    size="mini"
                                    icon="el-icon-view"
                                    @click="viewReviews(scope.row)"
                                />
                                <el-button
                                    type="danger"
                                    size="mini"
                                    icon="el-icon-delete"
                                    @click="handleDeleteModal(scope.row)"
                                />
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>

        <div v-else>
            <GooglePlaceForm
            @cancel="backToPlaces"
            @savePlace="redirectToAddPlace"
            />
        </div>
    </div>
</template>

<script>

import GooglePlaceForm from './GooglePlaceForm.vue';
import GooglePlaceReviews from './GooglePlaceReviews.vue';

export default {

    name: 'GooglePlaceList',

    // props: {
    //     places: {
    //         type: Array,
    //         default: () => [
    //             {
    //                 id: 1,

    //                 business_name: 'Panshi Restaurant',

    //                 place_id:
    //                     'ChIJGaXRDStVUDcRKECOQjJ7ETo',

    //                 place_url:
    //                     'https://search.google.com/local/reviews?placeid=ChIJGaXRDStVUDcRKECOQjJ7ETo',

    //                 download_type:
    //                     'Crawl Method : newest',

    //                 review_count: 5,
    //             },

    //             {
    //                 id: 2,

    //                 business_name: 'Authlab',

    //                 place_id:
    //                     'ChIJjzacjSNVUDcRQn7voHSyK08',

    //                 place_url:
    //                     'https://search.google.com/local/reviews?placeid=ChIJjzacjSNVUDcRQn7voHSyK08',

    //                 download_type:
    //                     'Places API : most_relevant',

    //                 review_count: 5,
    //             },
    //         ],
    //     },
    // },
    components: {
        GooglePlaceForm,
        GooglePlaceReviews
    },

    data() {
        return {
            addPlace: '',
            // selectedPlace: null,
            places: [],
            fetching: false,
        };
    },

    methods: {
        viewReviews(place) {
            this.$emit('view-reviews', place);
        },

        backToPlaces() {
            this.getGooglePlaces();
            this.addPlace = '';
        },
        addPlaceAction() {
            this.addPlace = 'add_place';
        },

        redirectToAddPlace(val) {
            this.getGooglePlaces();
            this.addPlace = val;
        },

        getGooglePlaces() {
            this.fetching = true;

            this.$get({
                action: 'atc_google_reviews_settings_admin_ajax',
                route: 'get_google_places',
                nonce: window.atcAdminVars.nonce
            })
                .then(response => {
                    setTimeout(() => {
                        this.places = response.data.places;
                        this.fetching = false;
                    }, 1000);
                })
                .fail(error => {
                    this.$handleError(error);
                });
        },

        handleDeleteModal(place) {
            this.$confirm( `Are you sure you want to delete "${place.name}"? is permanently`, 'Delete Google Place', {
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                type: 'warning',
            })
                .then(() => {
                    this.performAction("delete", place.place_id);
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
            performAction(type, place_id) {
                this.$post({
                    action: "atc_google_reviews_settings_admin_ajax",
                    route: "maybe_delete_google_place",
                    place_id: place_id,
                    action_type: type,
                    nonce: window.atcAdminVars.nonce,
                })
                    .then((response) => {
                        this.$handleSuccess(response.data.message);
                        this.getGooglePlaces();
                     })
                    .fail((error) => {
                        this.$handleError(error);
                    })
                    .always(() => {});
            },
    },
    mounted() {
        setTimeout(() => {
            this.getGooglePlaces();
        }, 500);
    },
};
</script>


<style scoped>

    .atcfe-google-place-list .el-card {
        width: 900px !important;
    }

    .atcfe-btn-group {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .el-card__body {
        overflow: scroll !important;
    }

    /* .atcfe-google-place-list {
        max-width: 1200px;
        margin: 30px 0;
    } */

    /* .atcfe-table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .atcfe-table-responsive .el-table {
        min-width: 900px;
    } */

    .atcfe-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    /* .atcfe-table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    } */

    /* .atcfe-table-responsive .el-table {
        min-width: 850px;
    } */

    .atcfe-place-id {
        display: inline-block;
        word-break: break-all;
        overflow-wrap: anywhere;
        text-decoration: none;
    }

</style>