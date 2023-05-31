import AppListing from '../app-components/Listing/AppListing';

Vue.component('road-listing', {
    mixins: [AppListing],
    data() {
        return {
            showFromFilter: false,
            showToFilter: false,
            fromMultiselect: {},
            toMultiselect: {},

            filters: {
                places: [],
            },
        }
    },

    watch: {
        showFromFilter: function (newVal, oldVal) {
            this.fromMultiselect = [];
        },
        showToFilter: function (newVal, oldVal) {
            this.toMultiselect = [];
        },
        fromMultiselect: function(newVal, oldVal) {
            this.filters.places = newVal.map(function(object) { return object['key']; });
            this.filter('places', this.filters.places);
        },
        toMultiselect: function(newVal, oldVal) {
            this.filters.places = newVal.map(function(object) { return object['key']; });
            this.filter('places', this.filters.places);
        }
    }
});
