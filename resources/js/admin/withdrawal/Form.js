import AppForm from '../app-components/Form/AppForm';

Vue.component('withdrawal-form', {
    mixins: [AppForm],
    props: [
        'wallets',
        'paymentMethods',
    ],
    data: function() {
        return {
            form: {
                price:  '' ,
                reason_type:  '' ,
                reason_id:  '' ,
                made_type:  '' ,
                made_id:  '' ,
                in_out:  false ,
                enabled:  false ,
                from:  '' ,
                to:  '' ,
                payment_method:  '' ,

            }
        }
    }

});
