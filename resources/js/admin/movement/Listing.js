import AppListing from '../app-components/Listing/AppListing';

Vue.component('movement-listing', {
    mixins: [AppListing],
    data() {
        return {
            showParentsFilter: false,
            parentsMultiselect: {},
            showMethodsFilter: false,
            methodsMultiselect: {},
            showShipmentsFilter: false,
            shipmentsMultiselect: {},
            showBranchesFilter: false,
            branchesMultiselect: {},

            filters: {
                parents: [],
                methods: [],
                shipments: [],
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
        showMethodsFilter: function (newVal, oldVal) {
            this.methodsMultiselect = [];
        },
        methodsMultiselect: function(newVal, oldVal) {
            this.filters.methods = newVal.map(function(object) { return object['key']; });
            this.filter('methods', this.filters.methods);
        },
        showShipmentsFilter: function (newVal, oldVal) {
            this.shipmentsMultiselect = [];
        },
        shipmentsMultiselect: function(newVal, oldVal) {
            this.filters.shipments = newVal.map(function(object) { return object['key']; });
            this.filter('shipments', this.filters.shipments);
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
