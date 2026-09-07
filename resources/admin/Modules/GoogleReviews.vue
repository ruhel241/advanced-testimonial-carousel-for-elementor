<template>

    <div class="atcfe-google-reviews">

        <!-- =========================
             GOOGLE PLACE LIST
        ========================== -->

        <GooglePlaceList v-if="currentView === 'list'"
            :place="place"
            @add-place="showAddPlace"
            @view-reviews="viewReviews"
            @delete-place="deletePlace"
        />


        <!-- =========================
             ADD GOOGLE PLACE
        ========================== -->

        <GooglePlaceForm v-else-if="currentView === 'add'"
            @cancel="backToPlaces"
            @save-place="savePlace"
        />


        <!-- =========================
             REVIEWS
        ========================== -->

        <GooglePlaceReviews v-else-if="currentView === 'reviews'"
            :place="place"
            @back="backToPlaces"
        />

    </div>

</template>


<script>

import GooglePlaceList from './component/GoogleReviews/GooglePlaceList.vue';
import GooglePlaceForm from './component/GoogleReviews/GooglePlaceForm.vue';
import GooglePlaceReviews from './component/GoogleReviews/GooglePlaceReviews.vue';

export default {
    name: 'GoogleReviews',
    components: {
        GooglePlaceList,
        GooglePlaceForm,
        GooglePlaceReviews,
    },

    data() {
        return {

            /*
             * Current screen
             *
             * list
             * add
             * reviews
             */
            currentView: 'list',
            /*
             * Selected Place
             */
            place: null,

            /*
             * Demo Places
             */
            // places: [
            //     {
            //         id: 1,
            //         business_name: 'Panshi Restaurant',
            //         place_id: 'ChIJGaXRDStVUDcRKECOQjJ7ETo',
            //         place_url: 'https://search.google.com/local/reviews?placeid=ChIJGaXRDStVUDcRKECOQjJ7ETo',
            //         download_type: 'Places API : newest',
            //         review_count: 5,
            //         last_synced: 'Aug 25, 2026',
            //     },


            //     {
            //         id: 2,
            //         business_name: 'Authlab',
            //         place_id: 'ChIJjzacjSNVUDcRQn7voHSyK08',
            //         place_url: 'https://search.google.com/local/reviews?placeid=ChIJjzacjSNVUDcRQn7voHSyK08',
            //         download_type: 'Places API : most_relevant',
            //         review_count: 5,
            //         last_synced: 'Aug 24, 2026',
            //     },
            // ],
        };
    },

    methods: {

        /*
         * =========================
         * SHOW ADD PLACE FORM
         * =========================
         */

        showAddPlace() {
            this.currentView = 'add';
        },


        /*
         * =========================
         * SAVE PLACE
         * =========================
         *
         * This receives the place
         * from GooglePlaceForm.vue
         */

        savePlace(place) {

            this.places.unshift(place);

            this.currentView = 'list';


            this.$message({

                type: 'success',

                message:
                    'Google Place added successfully.',

            });

        },


        /*
         * =========================
         * BACK TO PLACE LIST
         * =========================
         */

        backToPlaces() {
            this.place = null;
            this.currentView = 'list';
        },


        /*
         * =========================
         * VIEW REVIEWS
         * =========================
         */

        viewReviews(place) {
            this.place = place;
            this.currentView = 'reviews';
        },


        /*
         * =========================
         * DELETE PLACE
         * =========================
         */

        deletePlace(place) {

            this.places = this.places.filter(

                item => item.id !== place.id

            );


            this.$message({

                type: 'success',

                message:
                    'Google Place deleted successfully.',

            });

        },
    },
};

</script>


<style scoped>

.atcfe-google-reviews {

    max-width: 1200px;

    margin: 30px 0;

}

</style>