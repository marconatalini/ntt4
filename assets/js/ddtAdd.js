import './inputmask.js';

$(function() {
    //conversione lire->euro
    let pl = $("#ddt_edit_form_prezzoLire");
    let pe = $("#ddt_edit_form_prezzo");
    pl.focusout(function() {
        if (pl.val() != '') {
            pe.val(Math.round(pl.val() / 1936.27 *100)/100);
        }
    });

    //data ddt mask gg/mm/aa
    inputMask(document.getElementById('ddt_edit_form_dataDdt'), '##/##/##')

    //setFocus
    $("#ddt_edit_form_numeroDdt").focus();

    //load nota cliente after select
    var cli = $("#ddt_edit_form_cliente");
    cli.focusout(function () {
        $.ajax({
            url:'/clienti/nota/'+cli.val(),
            //type:'post',
            //data:{userid:userid},
            success: function(response){
                // Setting content option
                pl.tooltip({
                    'html': true,
                    'title': response,
                    'track': true});
            }
        });
    });


});