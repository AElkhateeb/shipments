import AppForm from '../app-components/Form/AppForm';

Vue.component('road-form', {
    mixins: [AppForm],
    props: [
        'places',
    ],
    data: function() {
        return {
            form: {
                price:  '' ,
                time:  '' ,
                enabled:  false ,
                pickup:  false ,
                todoor:  false ,
                express:  false ,
                breakable:  false ,
                from:  '' ,
                to:  '' ,

            }
        }
    }

});
