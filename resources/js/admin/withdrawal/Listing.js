import AppListing from '../app-components/Listing/AppListing';

Vue.component('withdrawal-listing', {
    mixins: [AppListing],
    data() {
        return {
            showFromFilter: false,
            showToFilter: false,
            fromMultiselect: {},
            toMultiselect: {},
            showPaymentMethodFilter: false,
            paymentMethodMultiselect: {},

            filters: {
                wallets: [],
                paymentMethods: [],
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
            this.filters.wallets = newVal.map(function(object) { return object['key']; });
            this.filter('wallets', this.filters.wallets);
        },
        toMultiselect: function(newVal, oldVal) {
            this.filters.wallets = newVal.map(function(object) { return object['key']; });
            this.filter('wallets', this.filters.wallets);
        },
        showPaymentMethodFilter: function (newVal, oldVal) {
            this.paymentMethodMultiselect = [];
        },
        paymentMethodMultiselect: function(newVal, oldVal) {
            this.filters.paymentMethods = newVal.map(function(object) { return object['key']; });
            this.filter('paymentMethods', this.filters.paymentMethods);
        },
    }
});
