$(function() {
    //$('.selectpicker').selectpicker();
    // $('.menu-icon-1').tooltip();
    // $('.menu-icon-2').tooltip();
    // $('.menu-icon-3').tooltip();
    // $('.menu-icon-4').tooltip();

    $("#menu button").click(function() {
        $("#menu").css("background-color", "rgb(55,55,55)");
    });

    $(".menu-icon-1").click(function() {
        $("#initial-view").hide();
        $("#font-option").hide();
        $("#get-quote-view").hide();
        $("#product-view").show();
    });
    $(".menu-icon-2").click(function() {
        $("#font-option").fadeIn("slow");
    });
    $(".menu-icon-3").click(function() {

    });
    $(".menu-icon-4").click(function() {

    });

    $("#quote").click(function() {
        $("#menu").hide();
        $("#initial-view").hide();
        $("#font-option").hide();
        $("#get-quote-view").show();
    });

    $(".glyphicon-remove-circle").click(function() {
        initialView();
    });
    $(".close").click(function() {
        initialView();
    });

    /*-------- modal window --------------*/
    // What is this???? Who added this? WHY???
    // $("#product-view .row div").click(function() {
    //     $('.modal').modal('show');
    // });

});


function initialView() {
    $("#initial-view").show();
    $("#menu").show();
    $("#font-option").hide();
    $("#get-quote-view").hide();
    $("#product-view").hide();
    $("#menu").css("background-color", "rgb(255,255,255)");
}
