import AppForm from '../app-components/Form/AppForm';

Vue.component('shipment-item-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                shipment_id:  '' ,
                name:  '' ,
                description:  '' ,
                enabled:  false ,
                price:  '' ,
                
            }
        }
    }

});