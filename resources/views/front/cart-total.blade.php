<div class="light-text">
    <div class="bg-2 padding30">
    <h2 class="id-color">{{ __('front.shipment.summary.titel')}}</h2>
    <div class="tiny-border"></div>
        <!--p class="lead big"></p-->
        <table class="property-table-wrap responsive-table">
            <tr>
                <th>{{ __('front.shipment.summary.total')}}</th>
                <td style="color:#e61a4a"> {{Cart::priceTotal()}} {{ __('front.shipment.caruncy')}}</td>
            </tr>                                  
        </table>
         <!--i>Fell free to asking about Gocargo or Just say hello to us </i-->
        
        <div class="text-center">
            <img src="{{URL::asset('front/front/img/contact/truck.png')}}" alt="">
        </div>
    </div>
</div>