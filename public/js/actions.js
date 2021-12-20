
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

$('#copyAddress').change(function(){
    // alert($("#state").val());
    if ($(this).prop('checked')==true){ 
        var div2 = document.getElementsByClassName('shipping-div');
        var div = document.getElementsByClassName('billing-div');
        var i = 0 ;
        var formValues = [];
        $(div).find('input, select, textarea').each(function() {
            // console.log($(this).val());
            formValues.push($(this).val());      
        });
        $(div2).find('input, select, textarea').each(function() {
            // console.log($(this).val());
            $(this).val(formValues[i]);
            if($(this).attr('id')=='shipCountry'){
                getState(formValues[i],'shipState');
            }
            i++;        
        });
    }
})
function showRiskStatus(id = null){
    var riskDet = $("#riskID"+id).val();
    var riskData = JSON.parse(riskDet);
    // console.log(riskData);
    $(".risk-p").text('');
    $("#riskStatus").text(riskData.riskStatus+'%');
    $("#validEmail").text(riskData.emailStructure).css("color" , ((riskData.emailStructure=="Invalid")?"red":"green"));
    $("#validateDomain").text(riskData.emailDomain).css("color" , ((riskData.emailDomain=="Invalid")?"red":"green"));
    $("#redListedEmail").text(riskData.emailRedlisted).css("color" , ((riskData.emailRedlisted=="Yes")?"red":"green"));
    $("#validAddress").text(riskData.validShippingAddress).css("color" , ((riskData.validShippingAddress=="No")?"red":"green"));
    $("#myModal").modal();
}
