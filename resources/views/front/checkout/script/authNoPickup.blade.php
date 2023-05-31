<script>
   $('#account-location').on('click',function(e){
      e.preventDefault();
      //var data= $('#checkout-form').serialize();
      data={
         "_token":'{{ csrf_token() }}',
         "plan":$('input[name="plan"]:checked').val()
         };
      var url= '{{route("accountNoLocation.checkout")}}';
      $.post(url,data).done(function(response){
                   console.log(response) ;    
      });
   }); 
</script>