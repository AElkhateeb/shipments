import AppForm from '../app-components/Form/AppForm';

Vue.component('package-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  this.getLocalizedFormDefaults() ,
                long:  '' ,
                limited:  false ,
                shipment_count:  '' ,
                price:  '' ,
                weight_default:  '' ,
                weight_fee:  '' ,
                road:  false ,
                road_sale:  '' ,
                pickup:  false ,
                pickup_fee:  '' ,
                todoor:  false ,
                todoor_fee:  '' ,
                express:  false ,
                express_fee:  '' ,
                breakable:  false ,
                breakable_fee:  '' ,
                is_published:  false ,
                for_stuff:  false ,
                
            }
        }
    }

});