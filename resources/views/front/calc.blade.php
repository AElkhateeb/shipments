<?php
use Illuminate\Support\Facades\Auth;
$placeF = $calc['placeF'];
$placeT = $calc['placeT'];
$road = $calc['road'];
$siteOption = $calc['siteOption'];
?>
<section id="section-contact-form">
    <div class="container">
        <div class="row  <?= (App::currentLocale()=='en')? '': 'arabic" '?>">
            <div id="shipmentSummary" class="col-lg-4 col-sm-12">
                @include('front.cart-total')
            </div>
            <div class="col-lg-8 col-sm-12">
                <form id="calc" data-roads="{{ json_encode($road) }}" data-option="{{ json_encode($siteOption) }}" class="row form-transparent <?= (App::currentLocale()=='en')? '': 'arabic'?>" >

                    <div class="form-group col-md-6">
                        <label id="ptypesL">{{ __('front.shipment.from')}}</label>
                        <select id="ptypes" class="form-control">
                            <option value=""selected>{{ __('front.shipment.from')}}</option>
                            @foreach( $placeF as $place)
                                @if($place['enabled']==1)
                                    <option value="{{ $place['id'] }}">{{ $place['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label id="statusL" >{{ __('front.shipment.to')}}</label>
                        <select id="status" class="form-control">
                            <option value=""selected>{{ __('front.shipment.to')}}</option>
                           @foreach( $placeT as $place)
                                @if($place['enabled']==1)
                                    <option value="{{ $place['id'] }}">{{ $place['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12 slidecontainer">
                        <label style=" padding-left: 42%;" >{{ __('front.shipment.weight')}} (<span id="demo">3</span> {{ __('front.shipment.kg')}})</label>
                        <input id="myRange"type="range"class="sliderr rounds"max="15"min="1"value="3">

                    </div>

                    <div id="Express-div" class="form-group col-md-6" <?= ($siteOption['express']!=1)?'style="display:none;"':""  ?> >
                        <label  class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.express')}}</label>
                        <label class="switch col-md-6"><input id="Express" class="calc-check" type="checkbox"> <span class="rounds slide-check"></span></label>

                    </div>

                    <div id="pickup-div" class=" form-group col-md-6" <?= ($siteOption['pickup']!=1)?'style="display:none;"':""  ?> >
                        <label class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.pickup')}}</label>

                        <label class="switch col-md-6"><input id="pickup" class="calc-check" type="checkbox"> <span class="rounds slide-check"></span></label>

                    </div>

                    <div id="todoor-div" class="form-group col-md-6" <?= ($siteOption['todoor']!=1)?'style="display:none;"':""  ?> >
                        <label  class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.todoor')}}</label>
                        <label class="switch col-md-6"><input id="todoor" class="calc-check" type="checkbox"> <span class="rounds slide-check"></span></label>

                    </div>

                    <div id="breakable-div" class=" form-group col-md-6" <?= ($siteOption['breakable']!=1)?'style="display:none;"':""  ?> >
                        <label class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.breakable')}}</label>

                        <label class="switch col-md-6"><input id="breakable" class="calc-check" type="checkbox"> <span class="rounds slide-check"></span></label>

                    </div>
                    <div id="mail_success" class="col-md-12 success">Thank you. Your message has been sent.</div>
                    <div id="mail_failed" class="col-md-12 error">Error, email not sent</div>
                    <div  class="light-text col-md-12"  ><span class="id-color" id="shipp-price" style="font-size: 36px;font-weight: bold;">0</span>{{ __('front.shipment.caruncy')}}</div>
                    <div class="col-md-12">
                        <p id="btnsubmit">
                            <input type="submit" id="shipp-btn" value="{{ __('front.shipment.btn.shipp')}}" class="btn btn-custom fullwidth" disabled />
                        </p>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
@section('last-script')
<script>

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
if($('tbody tr').length>0){ refresh_items_table(); }
function refresh_items_table() {
$('.remove-item').click(function(e){
    e.preventDefault();
     remove_from_cart( $(this).data("link"))
});
$('.shipp-update').click(function(e){
    e.preventDefault();
     update_the_cart($(this).attr('id'))
});
}


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
                var road= get_road();
            $.ajax({
                    /* the route pointing to the post function */
                    url: '{{route("site.cart.add")}}',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {
                        _token: '{{ csrf_token() }}',
                        road  : roads[road].id,  
                        weight  : $('#myRange').val(),  
                        options:{
                            express  : $('#Express').is(':checked'),  
                            pickup  : $('#pickup').is(':checked'),  
                            todoor  : $('#todoor').is(':checked'),  
                            breakable  : $('#breakable').is(':checked'),
                            }  
                         },
                    success: function (data) { 
                        $('#miniCart').html(data);
                        $('#miniCartCount').text($('#hideCount').val());
                        cart_summary();
                        if($('tbody tr').length>0){
                          var shipmentTable =$.ajax({
                            url: '{{route("site.cart.all")}}',
                            type: 'GET',
                            success: function (shipment) {
                                $('#shipmentTable').html(shipment);
                                refresh_items_table();
                            }
                          });
                        }
                    }
                }); 
}
function remove_from_cart(link){

    $.ajax({
        url: link,
        type: 'GET',
        success: function (shipment) {
            $('#shipmentTable').html(shipment);
            cart_mini();
            cart_summary();
            refresh_items_table()
        }});
}
function cart_mini(){

    $.ajax({
        url: '{{route("site.cart.mini")}}',
        type: 'GET',
        success: function (shipment) {
            $('#miniCart').html(shipment);
            $('#miniCartCount').text($('#hideCount').val());
        }});
}
function cart_summary(){

    $.ajax({
        url: '{{route("site.cart.summary")}}',
        type: 'GET',
        success: function (shipment) {
            $('#shipmentSummary').html(shipment);
        }});
}
function update_the_cart(rowId){
            $.ajax({
                    /* the route pointing to the post function */
                    url: '{{route("site.cart.update")}}',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {
                        _token: '{{ csrf_token() }}',
                        rowId  : rowId,  
                        road  : parseInt($('#id-'+rowId).val()),  
                        weight  : $('#weight-'+rowId).val(),  
                        qty  : $('#qty-'+rowId).val(),  
                        options:{
                            express  : $('#express-'+rowId).is(':checked'),  
                            pickup  : $('#pickup-'+rowId).is(':checked'),  
                            todoor  : $('#todoor-'+rowId).is(':checked'),  
                            breakable  : $('#breakable-'+rowId).is(':checked'),
                            }  
                         },
                    success: function (data) { 
                       $('#shipmentTable').html(data);
                       cart_mini();
                        cart_summary();
                       refresh_items_table();
                        /*if($('tbody tr').length>0){
                          var shipmentTable =$.ajax({
                            url: '{{route("site.cart.all")}}',
                            type: 'GET',
                            success: function (shipment) {
                                $('#shipmentTable').html(shipment);
                            }
                          });
                        }*/
                    }
                }); 
}
</script>
@stop