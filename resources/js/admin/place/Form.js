import AppForm from '../app-components/Form/AppForm';

Vue.component('place-form', {
    mixins: [AppForm],
    props: [
        'parents',
        'branches',
    ],
    data: function() {
        return {
            form: {
                name:  '' ,
                enabled:  false ,
                parent:  '' ,
                branch:  '' ,

            }
        }
    }

});
