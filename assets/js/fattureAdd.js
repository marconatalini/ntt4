$(function() {
    $( "#fatture_add_form_dataFattura" ).change(function() {

        $("#fatture_add_form_Estrai").closest("form").submit();

        //alert( $("#fatture_add_form_dataFattura").val() );
    });
});