<script >
   
   $('#add-location').on('click',function(e){
      $('#location-id').val('new')
   });
   $('.select-location').on('click',function(e){
      e.preventDefault();
      var url= $(this).data('url');
      /*var url= '{{route("selectLocation.checkout",":locId")}}';
      url = url.replace(':queryId', locId);*/
      if (!$( "#location-frm" ).hasClass('show')) {
         $( "#location-frm" ).addClass( 'show');
      }
      $.get(url).done(function(response){
                   console.log(response) ;
        $("#location-id").val(response.id);
        $("#state").select2().val(response.state).trigger("change");
        // mapSet(response.lat,response.lng);
      
         $.when( setLocationCoordinates(response.lat,response.lng) ).done(function() {
           $("#city").select2().val(response.city).trigger("change");
           $.when( setLocationCoordinates(response.lat,response.lng) ).done(function() {
              $("#street").val(response.street);
              $("#location").val(response.location);
              $("#lng").val(response.lng);
              $("#lat").val(response.lat);
            });
         });
        
      });
   });
   $('#account-location').on('click',function(e){
      e.preventDefault();
      //var data= $('#checkout-form').serialize();
      data={
         "_token":'{{ csrf_token() }}',
         "location-id":$("#location-id").val(),
         "location": {
            "state":$("#state").val(),
            "city":$("#city").val(),
            "street":$("#street").val(),
            "location":$("#location").val(),
            "lat":$("#lat").val(),
            "lng":$("#lng").val()
         },
         "plan":$('input[name="plan"]:checked').val()
         };
         
         
      var url= '{{route("accountLocation.checkout")}}';
      $.post(url,data).done(function(response){
                   console.log(response) ;    
      });
   });
</script>