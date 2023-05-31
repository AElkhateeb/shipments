import AppForm from '../app-components/Form/AppForm';

Vue.component('location-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                state:  '' ,
                city:  '' ,
                street:  '' ,
                location:  '' ,
                lng:  '' ,
                lat:  '' ,
                for_type:  '' ,
                for_id:  '' ,
                
            }
        }
    }

});