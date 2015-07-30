/*
*      Robo Gallery     
*      Version: 1.0
*      By Robosoft
*
*      Contact: http://robosoft.co
*      Created: 2015
*      Licensed under the GPLv2 license - http://opensource.org/licenses/gpl-2.0.php
*
*      Copyright (c) 2014-2015, Robosoft. All rights reserved.
*      Available only in http://robosoft.co/
*/

jQuery(function(){
	var rbs_init = 1;
	jQuery(document).on('change', '.rbs_action_element',  function(){
		var el = jQuery(this);
		var depends = el.data('depends');
		if(depends){
			//alert(depends);
			if(el.is(':checked')){
				jQuery(depends).show(rbs_init?0:'fast');
			} else {
				jQuery(depends).hide(rbs_init?0:'fast');	
			} 
		}
	});

	jQuery(document).on('change', '.rbs_action_element_select',  function(){
		var el = jQuery(this);
		if(el.data('depends')){
			var param 	= window[el.attr('id')+"_depends"];
			jQuery.each(param, function(index, valItem) {
				jQuery(valItem).hide(rbs_init?0:'fast');
			});
			jQuery(param[el.val()]).show(rbs_init?0:'fast');
		}
	});

	jQuery('.rbs_checkbox label.btn').on('change',  function(){
		var el = jQuery(this);
		el.parent().find('label.btn').removeClass('btn-info').addClass('btn-default');
		el.removeClass('btn-default').addClass('btn-info');
	});

	jQuery('.rbs_colums_auto').on('change',  function(){
		var el = jQuery(this);
		if(el.is(':checked')){
			jQuery('#'+el.data('width-id')).attr('disabled', 'disabled');
			jQuery('#'+el.data('colums-id')).removeAttr('disabled');
		} else {
			jQuery('#'+el.data('colums-id')).attr('disabled', 'disabled');
			jQuery('#'+el.data('width-id')).removeAttr('disabled');
		}
	}).change();

	jQuery('.rbs_action_element').change();
	jQuery('.rbs_action_element_select').change();


	//jQuery(".rbs_delete_up").parent().removeClass('cmb-td').parent().removeClass('cmb-row');
	if(!ROBO_GALLERY_PRO){
		jQuery("#rsg_hover").change( function () {
			var el = jQuery(this);
			if(el.val()==2){
				window['roboGalleryDialog'].dialog("open");
				el.selectpicker('val', 1);
			} 
		});
	}
	var rbs_init= 0;

  	jQuery(".rbs_slider").bootstrapSlider({ });

	jQuery(".rbs_font_slider").on("slide slideStop", function(slideEvt) {
		var divObj = jQuery(this).data('font-demoid');
		jQuery('#'+divObj).css('font-size', slideEvt.value+'px');
	});

	jQuery('body').on("change", ".rbs_fontParams", function() {
		var divObj 		= jQuery(this).data('font-demoid'),
			fontOptions = jQuery(this).data('font-option'),
			check 		= jQuery(this).is(':checked');

		switch(fontOptions){
			case 'bold':
				jQuery('#'+divObj).css('font-weight', check?'bold':'normal');
				break;
			case 'italic': 
				jQuery('#'+divObj).css('font-style', check?'italic':'normal');
				break;
			case 'underline':
				jQuery('#'+divObj).css('text-decoration', check?'underline':'none');
				break;
		}
	});

	//jQuery('.rbs_hover_bg_color').val();
});