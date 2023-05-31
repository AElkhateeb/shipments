import AppListing from '../app-components/Listing/AppListing';

Vue.component('branch-listing', {
    mixins: [AppListing],
    data() {
        return {
            showMangersFilter: false,
            mangersMultiselect: {},
            showAgentsFilter: false,
            agentsMultiselect: {},

            filters: {
                mangers: [],
                agents: [],
            },
        }
    },

    watch: {
        showMangersFilter: function (newVal, oldVal) {
            this.mangersMultiselect = [];
        },
        mangersMultiselect: function(newVal, oldVal) {
            this.filters.mangers = newVal.map(function(object) { return object['key']; });
            this.filter('mangers', this.filters.mangers);
        },
        showAgentsFilter: function (newVal, oldVal) {
            this.agentsMultiselect = [];
        },
        agentsMultiselect: function(newVal, oldVal) {
            this.filters.agents = newVal.map(function(object) { return object['key']; });
            this.filter('agents', this.filters.agents);
        }
    }
});
