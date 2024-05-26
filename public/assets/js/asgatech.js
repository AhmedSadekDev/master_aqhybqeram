/**
 * Name: FRA integration to LMS
 * License: asga-tech company 
 * Authors-Name: Eslam mohsen handousa 
 * Authors-Email: eslammohsenhandousa@gmail.com 
 * Version: 1.0
*/

$(".checkData").click(function(){
    displayPreloader("block");
    $('.error_display').html(' ');
    $.post(_URL+"/checkData", {
        nationality_type    : $('.NationalitySelect:checked').val(),
        user_type           : $('.recording_type:checked').val(),
        // ====================================== //
        national_number     : $('.national_number').val(),
        passport_number     : $('.passport_number').val(),
        nationality         : $('.nationality').val(),
        fra_code            : $('.fra_code').val(),
        registration_date   : $('.registration_date').val(),
        ifp_id              : $('.ifp_id').val(),
        _token              : $('meta[name="csrf-token"]').attr("content")
    }, function(res){ 
        displayPreloader("none");
        $('#staticBackdrop2').modal('toggle');
        $('.alertBodyMessage').html(' ').html(res.message);
        if(res.status != 0) {
            $('#app').html(' ').html(res.html);
        }
    }).fail( function(o) {
        displayPreloader("none");
        var n = o.responseJSON.errors;
        $.each(n, function(o, n) {
            $(".error-data-" + o).html(" ").html(n);
        });
    });
});

$(document).on('click','.StoreUser',function(){
    displayPreloader("block");
    $('.error_display').html(' ');
    var formData = new FormData;
    formData.append("pdf", $("#file")[0].files[0]);
    formData.append("username", $('.username').val());
    formData.append("phone", $('.phone').val());
    formData.append("email", $('.email').val());
    formData.append("email_confirmation", $('.email_confirmation').val());
    formData.append("full_name", $('.full_name').val());
    formData.append("country", $('.country').val());
    formData.append("city", $('.city').val());
    formData.append("nationality", $('.nationality').val());
    formData.append("national_number", $('.national_number').val());
    formData.append("national_image", $('.national_image').val());
    formData.append("passport_number", $('.passport_number').val());
    formData.append("ifp_number", $('.ifp_number').val());
    formData.append("fra_code", $('.fra_code').val());
    formData.append("registration_date", $('.registration_date').val());
    formData.append("job", $('.job').val());
    formData.append("educational_qualification", $('.educational_qualification').val());
    formData.append("company_name", $('.company_name').val());
    formData.append("company_address", $('.company_address').val());
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
    console.log(formData);
    $.ajax({
        url : _URL+"/storeUser",
        type : "POST",
        data : formData,
        contentType : false,
        processData : false
    }).done(function(res){
        displayPreloader("none");
        $('#staticBackdrop2').modal('toggle');
        $('.alertBodyMessage').html(' ').html(res.message);
        if(res.status != 0) {
            $('#app').html(' ').html(res.html);
        }
    }).fail(function(o){
        displayPreloader("none");
        var n = o.responseJSON.errors;
        $.each(n, function(o, n) {
            $(".error-data-" + o).html(" ").html(n);
        });
    });
});






$(document).on('click','.NationalitySelect',function(){
    $('.display_national_egyptian').css('display','none');
    $('.display_national_other').css('display','none');
    if($(this).val() == "egyptian") {
        $('.display_national_egyptian').css('display','flex');
    } else if($(this).val() == "other") {
        $('.display_national_other').css('display','flex');
    }
});

$(document).on('click','.recording_type',function(){
    $('.show_fra').css('display','none');
    $('.show_registration').css('display','none');
    if($(this).val() == "fra") {
        $('.show_fra').css('display','flex');
    } else if($(this).val() == "insurance_professional") {
        $('.show_registration').css('display','flex');
    }
});

$(document).on('change','.countiesSelect',function(){
    $.get(_URL+'/country/'+$(this).val(),function(response){ 
        $('#getCities').html(' ').html(response.html);
    });
});

$(document).on('click','.clientType',function(){
    if($(this).val() == "company") {
        $("#companyInformation").css('display','block')
    } else {
        $("#companyInformation").css('display','none');                
    }
});

function displayPreloader(display) {
    $('#preloader').css('display',display);
    $('#preloader #status').css('display',display);
}

// $(document).on('click','#file-Upload',function(){
//     $("#file1").trigger('click');
// });