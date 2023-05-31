import AppListing from '../app-components/Listing/AppListing';

Vue.component('movement-method-listing', {
    mixins: [AppListing],
    data() {
        return {
            showParentsFilter: false,
            parentsMultiselect: {},

            filters: {
                parents: [],
            },
        }
    },

    watch: {
        showParentsFilter: function (newVal, oldVal) {
            this.parentsMultiselect = [];
        },
        parentsMultiselect: function(newVal, oldVal) {
            this.filters.parents = newVal.map(function(object) { return object['key']; });
            this.filter('parents', this.filters.parents);
        },
    }
});
