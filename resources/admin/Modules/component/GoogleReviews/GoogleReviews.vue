<template>
    <div class="atcfe-google-reviews">
        <!-- =========================
             GOOGLE PLACES
        ========================== -->
        <GooglePlaceList v-if="currentView === 'list'"
            @add-place="showAddPlace"
            @view-reviews="viewReviews"
        />
        
         <!-- =========================
             Google Place Form
        ========================== -->

        <GooglePlaceForm v-if="currentView === 'add_place'"
            @cancel="backToPlaces"
            @save-place="redirectToAddPlace"     
        />

        <!-- =========================
             REVIEWS
        ========================== -->
        <GooglePlaceReviews v-else-if="currentView === 'reviews'"
            :place_id="place_id"
            @back="backToPlaces"
        />
    </div>
</template>

<script>

import GooglePlaceList from './_GooglePlaceList';
import GooglePlaceForm from './_GooglePlaceForm';
import GooglePlaceReviews from './_GooglePlaceReviews';

export default {
    name: 'GoogleReviews',
    components: {
        GooglePlaceList,
        GooglePlaceForm,
        GooglePlaceReviews,
    },

    data() {
        return {
            currentView: 'list',
            place_id: null,
        };
    },

    methods: {
        showAddPlace() {
            this.currentView =  'add_place';
        },

        backToPlaces() {
            this.place_id = null;
            this.currentView = 'list';
        },
        viewReviews(place_id) {
            this.place_id = place_id;
            this.currentView = 'reviews';
        },
        redirectToAddPlace() {
            setTimeout(() => {
                this.currentView = 'list';
            }, 1000);
        },
    }
};
</script>