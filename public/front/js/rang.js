var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
    output.innerHTML = this.value;
    var road= get_road();
    if (road!='NULL'){calc(road);}
}
var calcWrapper = jQuery('#calc');
var roads = calcWrapper.data('roads');
var option = calcWrapper.data('option');

console.log(option);  
console.log(roads);  
$('#ptypes').change(function(e) {get_to()}); 
$('#status').change(function(e) {
    var road= get_road();
    if (road!='NULL'){calc(road);}
}); 
$(".calc-check").change(function() {
   var road= get_road();
    if (road!='NULL'){calc(road);}
});
$("#shipp-btn").click(function(e) {
     e.preventDefault();
     add_to_cart()
 });
//  get road data by to and from    ****
function get_to(){
    var toOptions=[{text:'choose option',id:0 }];
    $.each(roads,function (index, value) { 
    if(value.from_id == $("#ptypes").val()  ){
        toOptions.push({
            text: value.place_to.name,
            id: value.place_to.id
        });
      }  
   });
   // console.log(toOptions);
     $("#status").empty().select2({
        data: toOptions
    });
     var road= get_road();
    if (road!='NULL'){calc(road);}
    
}
// do calc up to option and roads
function get_road(){
var road='NULL';
   $.each(roads,function (index, value) { 
    if(value.from_id == $("#ptypes").val() && value.to_id == $("#status").val() ){
        road= index;
   }
    });
   //calc(road);
   return road;
}
// final cost 
function calc (r){
    var ship=0
    if(r!='NULL'){
        ship=roads[r].price;
        if(roads[r].express==1&&option.express==1){
           ($('#Express').is(":checked"))? ship=ship*option.express_fee:ship;
           $('#Express-div').show();
        }else{$('#Express-div').hide();}
        if(option.weight_default<$('#myRange').val()){
            var extraWeight=$('#myRange').val()-option.weight_default;
            var extraPrice=extraWeight*option.weight_fee;
            ship=ship+extraPrice;
        }
        if(roads[r].pickup==1&&option.pickup==1){
           ($('#pickup').is(":checked"))? ship=ship+option.pickup_fee:ship;
            $('#pickup-div').show();
        }else{$('#pickup-div').hide();}
        if(roads[r].todoor==1&&option.todoor==1){
           ($('#todoor').is(":checked"))? ship=ship+option.todoor_fee:ship;
            $('#todoor-div').show();
        }else{$('#todoor-div').hide();}
        if(roads[r].breakable==1&&option.breakable==1){
            ($('#breakable').is(":checked"))? ship=ship+option.breakable_fee:ship;
            $('#breakable-div').show();
        }else{$('#breakable-div').hide();}
         $('#shipp-btn').prop('disabled', false);
    }else{
        $('#shipp-btn').prop('disabled', true);
    }
    $("#shipp-price").text(ship);
}

/*add to cart
    post data
    success add to cart list*/
function add_to_cart(){
    
            $.ajax({
                    /* the route pointing to the post function */
                    url: '{{route(site.cart.add)}',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: 'a7a'},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        console.log(data);
                       // $(".writeinfo").append(data.msg); 
                    }
                }); 
}


