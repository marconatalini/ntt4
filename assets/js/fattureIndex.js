import 'jquery-ui/ui/widgets/dialog'

$(function() {
    $(".select-all").click(function(e) {
        $(".select-fattura").each(function(index, element) {
            var elem = $(element);
            elem.prop("checked", !elem.prop("checked"));
        });
    });

    var btn_delete_link = '';
    var btn_mail_link = '';
    //Initialize dialog DELETE
    $("#dialog-confirm").dialog({
        resizable : false,
        autoOpen : false,
        height : "auto",
        width : 400,
        modal : true,
        buttons : {
            "Elimina" : function() {
                window.location.href = btn_delete_link;
            },
            "Annulla" : function() {
                $(this).dialog("close");
            }
        }
    });

    //Initialize dialog MAIL
    $("#dialog-mail").dialog({
        resizable : false,
        autoOpen : false,
        height : "auto",
        width : 400,
        modal : true,
        buttons : {
            "SI" : function() {
                window.location.href = btn_mail_link;
            },
            "NO" : function() {
                $(this).dialog("close");
            }
        }
    });


    //Open it when #opener is clicked
    $(".btn-delete").click(function(e) {
        e.preventDefault();
        btn_delete_link = $(this).attr("href");
        $("#dialog-confirm").dialog("open");
    });

    //Open it when #opener is clicked
    $(".btn-mail").click(function(e) {
        e.preventDefault();
        btn_mail_link = $(this).attr("href");
        $("#dialog-mail").dialog("open");
    });

    //mese after select
    $("#filter_mese").change(function(e) {
        var optionSelected = $("option:selected", this);
        var mese = this.value;
        var anno = $("#filter_anno").val();
        $("#pdf-lista").css("display", "inline");
        $("#pdf-lista").attr("href", "fatture/lista/" + anno + "/" + mese)

    });

});