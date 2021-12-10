
// $("#payment-form").on('change', '#Field-countryInput', function() {
//     alert("in");
// });


function get_state(country_code="IN",state_div=null){ 
    $("#"+state_div).html('');
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
            $("#"+state_div).append('<option value="'+value.name+'">'+value.name+'</option>');
        });
        });
    }
}

$('#copy_address').change(function(){
    // alert($("#state").val());
    if ($(this).prop('checked')==true){ 
        var div = document.getElementsByClassName('shipping_div');
        var div2 = document.getElementsByClassName('billing_div');
        var i = 0 ;
        var formValues = [];
        $(div).find('input, select, textarea').each(function() {
            // console.log($(this).val());
            formValues.push($(this).val());      
        });
        $(div2).find('input, select, textarea').each(function() {
            // console.log($(this).val());
            $(this).val(formValues[i]);
            if($(this).attr('id')=='bill_country'){
                get_state(formValues[i],'bill_state');
            }
            i++;        
        });
    }
})
