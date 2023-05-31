import AppForm from '../app-components/Form/AppForm';

Vue.component('wallet-form', {
    mixins: [AppForm],
     props: [
        'roles',
        'shippers',
        'url',
    ],
    data: function() {
        return {
            form: {
                money:  '' ,
                belongs_to_type:  '' ,
                belongs_to:  '' ,
                
            }
        }
    },
    methods: {
        getOwner: function(actionName){ 
                        
                        window.axios.get('/'+this.url+'/'+actionName.model).then(res => {
                         let result = res.data;
                         if(actionName.model == 'branches'){
                           this.shippers=result.data.data.map(item => 
                            { 
                                return {
                                id: item.id, 
                                label: item.name,
                                };
                            });
                         }else if(actionName.model =='receivers'){
                            this.shippers=result.data.data.map(item => 
                            { 
                                return {
                                id: item.id, 
                                label: item.fullname,
                                };
                            });
                            
                         }else{
                            this.shippers=result.data.data.map(item => 
                            { 
                                return {
                                id: item.id, 
                                label: item.full_name,
                                };
                            });

                            
                         }
                            
                                   
                        });
                       
                    },

    }

});