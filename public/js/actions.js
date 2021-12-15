
function getState(countryCode="IN",stateDiv=null){ 
    $("#"+stateDiv).html('');
    if(countryCode){
        $.ajax({
        url: URLROOT+"/AjaxController/getState",
        method : "POST",
        data:{countryCode:countryCode},
        })
        .done(function( data ) {
        //   console.log(data);
        obj = JSON.parse(data);
        $.each( obj, function(key,value) { 
            $("#"+stateDiv).append('<option value="'+value.name+'">'+value.name+'</option>');
        });
        });
    }
}

$('#copy_address').change(function(){
    // alert($("#state").val());
    if ($(this).prop('checked')==true){ 
        var div = document.getElementsByClassName('shipping-div');
        var div2 = document.getElementsByClassName('billing-div');
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
                getState(formValues[i],'bill_state');
            }
            i++;        
        });
    }
})
