import AppForm from '../app-components/Form/AppForm';

Vue.component('shipment-form', {
    mixins: [AppForm],
    props: [
        'roads',
        'places',
        'branches',
        'payment_methods',
        'roles',
        'shippers',
        'url',
    ],
    data: function() {
        return {
            form: {
                pkg_num:  '' ,
                road:  '' ,
                placeFrom:  '' ,
                branchFrom:  '' ,
                placeTo:  '' ,
                branchTo:  '' ,
                weight:  '' ,
                pickup:  false ,
                todoor:  false ,
                express:  false ,
                breakable:  false ,
                shipper_type:  '' ,
                shipper:  '' ,
                receiver_id:  '' ,
                status:  '' ,
                published_at:  '' ,
                end_at:  '' ,
                shipp_price:  '' ,
                shipp_cost:  '' ,
                shipp_sale:  '' ,
                shipp_total:  '' ,
                paymentMethod:  '' ,

            }
        }
    },   
    methods: {
        getShipper: function(actionName){ 
                        window.axios.get('/'+this.url+'/'+actionName.model).then(res => {
                         let result = res.data;
                         this.shippers=result.data.data.map(item => 
                            { 
                                return {
                                id: item.id, 
                                label: item.full_name,
                                };
                            });
                                   
                        });
                       
                    },

    }

});
