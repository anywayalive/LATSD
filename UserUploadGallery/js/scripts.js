jQuery(function () {
    //$('.selectpicker').selectpicker();
    jQuery('.menu-icon-1').tooltip();
    jQuery('.menu-icon-2').tooltip();
    jQuery('.menu-icon-3').tooltip();
    jQuery('.menu-icon-4').tooltip();
    jQuery('.glyphicon .glyphicon-cog').tooltip();
    
    jQuery("#menu button").click(function(){
       jQuery("#menu").css("background-color","rgb(55,55,55)"); 
    });
    
    jQuery(".menu-icon-1").click(function(){
        jQuery("#initial-view").hide();
        jQuery("#font-option").hide(); 
        jQuery("#get-quote-view").hide();
        jQuery("#product-view").show();
    });
    jQuery(".menu-icon-2").click(function(){
        jQuery("#font-option").fadeIn("slow");
    });
    jQuery(".menu-icon-3").click(function(){
        
    });
    jQuery(".menu-icon-4").click(function(){
        
    });
    
    jQuery("#quote").click(function(){
        jQuery("#menu").hide();
        jQuery("#initial-view").hide();
        jQuery("#font-option").hide(); 
        jQuery("#get-quote-view").show();
    });
    
    jQuery(".glyphicon-remove-circle").click(function(){
        initialView();
    });
	
	/*-------- modal window --------------*/
	jQuery("#product-view .row div").click(function(){
		jQuery('.modal').modal('show');
	});
	
});


function initialView(){
    jQuery("#initial-view").show();
    jQuery("#menu").show();
    jQuery("#font-option").hide(); 
    jQuery("#get-quote-view").hide();
    jQuery("#product-view").hide();
    jQuery("#menu").css("background-color","rgb(255,255,255)"); 
}
