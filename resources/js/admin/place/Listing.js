import AppListing from '../app-components/Listing/AppListing';

Vue.component('place-listing', {
    mixins: [AppListing],
    data() {
        return {
            showParentsFilter: false,
            parentsMultiselect: {},
            showBranchesFilter: false,
            branchesMultiselect: {},

            filters: {
                parents: [],
                branches: [],
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
        showBranchesFilter: function (newVal, oldVal) {
            this.branchesMultiselect = [];
        },
        branchesMultiselect: function(newVal, oldVal) {
            this.filters.branches = newVal.map(function(object) { return object['key']; });
            this.filter('branches', this.filters.branches);
        }
    }
});
