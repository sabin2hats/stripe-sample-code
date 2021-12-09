
$("#payment-form").on('change', '#Field-countryInput', function() {
    alert("in");
});

$("#Field-countryInput").change(function(){
    // alert($("#state").val());
    get_state($("#Field-countryInput").val());
})
function get_state(country_code="IN"){
    $("#state").html('');
    if(country_code){
        $.ajax({
        url: "../actions/ajax_requests.php",
        method : "POST",
        data:{function:"get_states",country_code:country_code},
        })
        .done(function( data ) {
        //   console.log(data);
        obj = JSON.parse(data);
        $.each( obj, function(key,value) { 
            $("#state").append('<option value="'+value.name+'">'+value.name+'</option>');
        });
        });
    }
  }
// document
//   .querySelector("#Field-countryInput")
//   .addEventListener("change", test);


//   async function test(){
//       alert("IN");
//   }