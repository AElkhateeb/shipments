import AppForm from '../app-components/Form/AppForm';

Vue.component('movement-form', {
    mixins: [AppForm],
    props: [
        'parents',
        'methods',
        'shipments',
        'branches',
        'roles',
        'shippers',
        'url',
    ],
    data: function() {
        return {
            form: {
                reason:  '' ,
                shipment:  '' ,
                method:  '' ,
                employee_type:  '' ,
                employee:  '' ,
                branch:  '' ,
                parent:  '' ,

            }
        }
    },
    methods: {
        getOwner: function(actionName){ 
                        window.axios.get('/'+this.url+'/'+actionName.model).then(res => {
                         let result = res.data;
                        if(actionName.model!='receivers'){
                            this.shippers=result.data.data.map(item => 
                            { 
                                return {
                                id: item.id, 
                                label: item.full_name,
                                };
                            });
                         }else{
                            this.shippers=result.data.data.map(item => 
                            { 
                                return {
                                id: item.id, 
                                label: item.fullname,
                                };
                            });
                         }
                            
                                   
                        });
                       
                    },

    }

});
