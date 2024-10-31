(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	/*if device is mobile*/
	if ( wqv_public_param.mwb_wqv_mobile_view_setting != '' ) {
		if ( $(window).width() < 500 ) {
			setTimeout(function(){ $('.mwb_wqv_quickview_modal_button').remove(); }, 10);
			setTimeout(function(){ $('.mwb-modal__quick-view-wrap').remove(); }, 10);
		}
		$(window).on("resize", function () {
			if ( $(window).width() < 500 ) {
				$('.mwb_wqv_quickview_modal_button').hide();
			} else {
				$('.mwb_wqv_quickview_modal_button').show();
			}
		});
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			$('.mwb-modal__quick-view-wrap').remove();
			$('.mwb_wqv_quickview_modal_button').remove();
		}
	}
	$(document).on('click','.mwb_wqv_quickview_modal_button',function(e){
		$(".mwb_wqv_variation_dropdown").hide();
		$(".mwb-modal-close").hover(function(){
			$(this).css("background-color", wqv_public_param.mwb_wqv_on_mouse_hover_color);
			}, function(){
			$(this).css("background-color", wqv_public_param.mwb_wqv_on_mouse_out_color);
		});
		var mwb_current_wqv_product_id = $(this).attr("data-mwb_wqv_prod_id");
		e.preventDefault();
		$.ajax({
            type: 'POST',
            url: wqv_public_param.ajaxurl,
            data: {
                action: 'mwb_wqv_quickview_render_popup',
                mwb_wqv_product_id: mwb_current_wqv_product_id,
                ajax_nonce: wqv_public_param.nonce,
            },
            success: function(mwb_wqv_product_data) {
				if( 'yes' == mwb_wqv_product_data.mwb_wqv_sold_individually ) {
					$('.mwb-quantity').hide();
				}
				if ('outofstock' == mwb_wqv_product_data.mwb_wqv_stock_action ) {
					$('.mwb-quantity').hide();
					$('#mwb_wqv_add_to_cart').hide();
				}
				if ('' != mwb_wqv_product_data.mwb_wqv_stock_quantity ) {
					$('#quantity').prop('max',mwb_wqv_product_data.mwb_wqv_stock_quantity);
				}
				$('.mwb_wqv_noticeofstock').html(mwb_wqv_product_data.mwb_wqv_stock_notice);
				if (mwb_wqv_product_data.mwb_wqv_prod_type == 'variable') {
					$('#mwb_wqv_add_to_cart').addClass('mwb_wqv_add_to_cart_variable_product');
					$('.mwb_wqv_sale_price').hide();
					$("#mwb_wqv_view_detail").attr("href", mwb_wqv_product_data.mwb_wqv_product_permalink);
					$('.mwb-modal__col-img img').attr("src",mwb_wqv_product_data.mwb_wqv_prod_image_src);
					$('.single_add_to_cart_button').attr("value",mwb_wqv_product_data.mwb_wqv_prod_id);
					$('.mwb_wqv_product_price').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_prod_price+": "+mwb_wqv_product_data.mwb_wqv_variation_price_range_string);
					$('.mwb_wqv_sku').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_sku+": " + mwb_wqv_product_data.mwb_wqv_prod_sku);
					$('.mwb_wqv_category').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_prod_category+": " + mwb_wqv_product_data.mwb_wqv_prod_category);
					$('.mwb_modal__col-title').html(mwb_wqv_product_data.mwb_wqv_prod_name);
					$('.mwb_modal__description-section').html("<p>"+mwb_wqv_product_data.mwb_wqv_prod_excerpt+"</p>");
					$('.single_add_to_cart_button').prop('disabled',true);
					$(".mwb_wqv_variation_dropdown").show();
					var mwb_wqv_variable_prod_droopdown = '';
					$.each(mwb_wqv_product_data.mwb_wqv_attributes_array, function(mwb_wqv_label) {
						mwb_wqv_variable_prod_droopdown += '<div class="mwb_wqv_dropdown_wrapper"><label for="'+mwb_wqv_label+'">'+mwb_wqv_label.replace('pa_','')+':</label>';
						mwb_wqv_variable_prod_droopdown += '<select class="mwb_wqv_select" name="'+mwb_wqv_label.toLowerCase()+'" id="'+mwb_wqv_label+'">';
						mwb_wqv_variable_prod_droopdown += '<option value="" selected disabled>'+wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_choose_option+'</option>';
						$.each(this, function(mwb_wqv_dropdown_key, mwb_wqv_dropdown_value) {
							mwb_wqv_variable_prod_droopdown += '<option value="'+mwb_wqv_label.toLowerCase()+'">'+mwb_wqv_dropdown_value+'</option>';
						});
						mwb_wqv_variable_prod_droopdown += '</select></div>';
					  });
					  $('.mwb_wqv_variation_dropdown').html(mwb_wqv_variable_prod_droopdown);
					  $('.mwb_wqv_variation_dropdown').append('<input type="hidden" id="mwb_wqv_hidden_prod_id" name="mwb_wqv_id" value="'+mwb_current_wqv_product_id+'" />');
				} else {
					$('#mwb_wqv_no_variation_notice').hide();
					$("#mwb_wqv_view_detail").attr("href", mwb_wqv_product_data.mwb_wqv_product_permalink);
					$('.single_add_to_cart_button').prop('disabled',false);
					$('.mwb-modal__col-img img').attr("src",mwb_wqv_product_data.mwb_wqv_prod_image_src);
					$('.single_add_to_cart_button').attr("value",mwb_wqv_product_data.mwb_wqv_prod_id);
					if ( mwb_wqv_product_data.mwb_wqv_prod_sale_price != "" ) {
						$('.mwb_wqv_product_price').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_prod_price+": <span class='mwb_wqv_strike_through'>"+mwb_wqv_product_data.mwb_wqv_prod_regular_price+"</span>");
						$('.mwb_wqv_sale_price').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_sale_price+": " + mwb_wqv_product_data.mwb_wqv_prod_sale_price );
					} else{
						$('.mwb_wqv_product_price').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_prod_price+": "+mwb_wqv_product_data.mwb_wqv_prod_regular_price);
					}
					$('.mwb_wqv_sku').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_sku+": " + mwb_wqv_product_data.mwb_wqv_prod_sku);
					$('.mwb_wqv_category').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_prod_category+": " + mwb_wqv_product_data.mwb_wqv_prod_category);
					$('.mwb_modal__col-title').html(mwb_wqv_product_data.mwb_wqv_prod_name);
					$('.mwb_modal__description-section').html("<p>"+mwb_wqv_product_data.mwb_wqv_prod_excerpt+"</p>");
					if ( mwb_wqv_product_data.mwb_wqv_prod_type =='grouped') {
						$('.mwb_wqv_product_price').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_prod_price+": "+mwb_wqv_product_data.mwb_wqv_grouped_price_range);
						$('.mwb-quantity').hide();
						$('.quantity_grouped').show();
						$('#mwb_wqv_add_to_cart').addClass('mwb_wqv_add_to_cart_grouped_product');
						$('.quantity_grouped').html(mwb_wqv_product_data.mwb_wqv_grouped_prod_html);	  
					}
				}
			}
		});
		$(document).on('click','.mwb-modal__quick-view-wrap .mwb-modal-close',function(){
			mwb_wqv_selected_options_array = {};
		});
		var mwb_wqv_selected_options_array = {};
		$(document).on('change', '.mwb_wqv_select', function(){
			mwb_wqv_selected_options_array[$(this).val()] = $(this).find("option:selected").text();
			if (Object.keys( mwb_wqv_selected_options_array).length == $('.mwb_wqv_dropdown_wrapper').length ) {
				mwb_current_wqv_product_id = $('#mwb_wqv_hidden_prod_id').val();
				$.ajax({
					type: 'POST',
					url: wqv_public_param.ajaxurl,
					data: {
						action: 'mwb_wqv_quickview_render_popup_for_variable_product',
						mwb_wqv_parent_product_id: mwb_current_wqv_product_id,
						mwb_wqv_selected_options_array: mwb_wqv_selected_options_array,
						ajax_nonce: wqv_public_param.nonce,
					},
					success: function(mwb_wqv_variation_data) {
						if (mwb_wqv_variation_data != null) {
							$('#mwb_wqv_no_variation_notice').hide();
							$('.mwb_wqv_sale_price').hide();
							$('.mwb-modal__col-img img').attr("src",mwb_wqv_variation_data.image['url']);
							$('.single_add_to_cart_button').attr("value",mwb_wqv_variation_data.variation_id);
							$('.mwb_wqv_product_price').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_prod_price+": "+mwb_wqv_variation_data.price_html);
							$('.mwb_wqv_sku').html(wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_sku+": " + mwb_wqv_variation_data.sku);
							if (mwb_wqv_variation_data.variation_description != '') {
								$('.mwb_modal__description-section').html("<p>"+mwb_wqv_variation_data.variation_description+"</p>");
							}
							$('.single_add_to_cart_button').prop( 'disabled',false );
						} else {
							$('.single_add_to_cart_button').prop( 'disabled',true );
							$('#mwb_wqv_no_variation_notice').show();
							$('#mwb_wqv_no_variation_notice').html('<p>'+wqv_public_param.mwb_wqv_localize_strings.mwb_wqv_no_variation_notice+'</p>');
						}
					},
					error: function(wp_ajax_error) {
						console.log(wp_ajax_error);
					}
				});
			}
		});
		$('body').addClass('mwb-wqv__overlay-pop');
		$('.mwb-modal__quick-view-wrap').fadeIn();
		
		if (wqv_public_param.mwb_wqv_animation_setting == 'mwb_wqv_anim_default') {
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1'); 
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim2');
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1_reverse');
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim2_reverse');
			$('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim_default');
		} else if (wqv_public_param.mwb_wqv_animation_setting == 'mwb_wqv_anim1') {
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim_default');
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim2');
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1_reverse');
			$('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim1');
		} else if (wqv_public_param.mwb_wqv_animation_setting == 'mwb_wqv_anim2') {
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1');
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim_default');
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim2_reverse');
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1_reverse');
			$('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim2');
		}
		$('.mwb-modal__quick-view-wrap').fadeIn();
	});
	$(document).on('click','.mwb-modal__quick-view-wrap .mwb-modal-close',function(){
		$('#quantity').prop('max','');
		$('#mwb_wqv_add_to_cart').show();
		$('body').removeClass('mwb-wqv__overlay-pop');
		
		if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim_default')) {
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim_default');
	 	}
	 if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim1')){
		$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1');
		$('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim1_reverse');
	}
	if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim2')){
		$('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim2_reverse');
		$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim2');
	}
	 $('.mwb-modal__quick-view-wrap').fadeOut();
	 $('#mwb_wqv_add_to_cart').removeClass('mwb_wqv_add_to_cart_variable_product');
	 $('.mwb-quantity').show();
	 $('#mwb_wqv_add_to_cart').removeClass('mwb_wqv_add_to_cart_grouped_product');
	 $('.quantity_grouped').hide();
	});

	$(document).keyup(function(e) {
			if (e.key === "Escape") {
				$('#quantity').prop('max','');
				$('#mwb_wqv_add_to_cart').show();
        $('body').removeClass('mwb-wqv__overlay-pop');
        if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim_default')) {
          $('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim_default');
         }
       if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim1')){
        $('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1');
        $('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim1_reverse');
      }
      if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim2')){
        $('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim2_reverse');
        $('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim2');
      }
          $('.mwb-modal__quick-view-wrap').fadeOut();
          $('#mwb_wqv_add_to_cart').removeClass('mwb_wqv_add_to_cart_variable_product');
          $('.mwb-quantity').show();
          $('#mwb_wqv_add_to_cart').removeClass('mwb_wqv_add_to_cart_grouped_product');
          $('.quantity_grouped').hide();
			}
		});

	$(document).on('click',function(e){
	  if ($(e.target).is('.mwb-modal__quick-view-wrap')) {
		$('#quantity').prop('max','');
		$('#mwb_wqv_add_to_cart').show();
		$('body').removeClass('mwb-wqv__overlay-pop');
		if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim_default')) {
			$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim_default');
	 	}
	 if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim1')){
		$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim1');
		$('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim1_reverse');
	}
	if($('.mwb-modal__quick-view-content').hasClass('mwb_wqv_anim2')){
		$('.mwb-modal__quick-view-wrap').children().addClass('mwb_wqv_anim2_reverse');
		$('.mwb-modal__quick-view-content').removeClass('mwb_wqv_anim2');
	}
			$('.mwb-modal__quick-view-wrap').fadeOut();
			$('#mwb_wqv_add_to_cart').removeClass('mwb_wqv_add_to_cart_variable_product');
			$('.mwb-quantity').show();
			$('#mwb_wqv_add_to_cart').removeClass('mwb_wqv_add_to_cart_grouped_product');
			$('.quantity_grouped').hide();
		}
	});
	$(document).on('click','.mwb_wqv_add_to_cart_variable_product',function(e){
		e.preventDefault();
		var mwb_wqv_query_parameter_variation = {};
		var mwb_wqv_prod_quantity = $('#quantity').val();
		var mwb_wqv_variation_id = $(this).val();
		$.each($('.mwb_wqv_select'), function() {
			mwb_wqv_query_parameter_variation['attribute_'+$(this).attr('id')] = $(this).find("option:selected").text();
		});
		var mwb_wqv_add_to_cart_url = $(location).attr("href");
		if ( 0 < mwb_wqv_add_to_cart_url.indexOf("?") ) {
			mwb_wqv_add_to_cart_url = mwb_wqv_add_to_cart_url.substring(0, mwb_wqv_add_to_cart_url.indexOf("?"));	
		}
		let mwb_wqv_query = ""
		for (let mwb_wqv_keys in mwb_wqv_query_parameter_variation)
			mwb_wqv_query += encodeURIComponent(mwb_wqv_keys) + '=' + encodeURIComponent(mwb_wqv_query_parameter_variation[mwb_wqv_keys]) + '&';
		mwb_wqv_query = mwb_wqv_query.slice(0, -1);
		mwb_wqv_add_to_cart_url = mwb_wqv_add_to_cart_url + '?quantity=' + mwb_wqv_prod_quantity + '&add-to-cart=' + mwb_wqv_variation_id + '&' + mwb_wqv_query;
		window.location.replace(mwb_wqv_add_to_cart_url);
	});
	$(document).on('click','.mwb_wqv_add_to_cart_grouped_product',function(e){
		e.preventDefault();
		var mwb_wqv_query_parameter_grouped = {};
		var mwb_wqv_grouped_id = $(this).val();
		$.each($('.mwb_wqv_grouped_id_qty'), function() {
			mwb_wqv_query_parameter_grouped['['+$(this).attr('id')+']'] = $(this).val();
		});
		var mwb_wqv_add_to_cart_url = $(location).attr("href");
		if ( 0 < mwb_wqv_add_to_cart_url.indexOf("?") ) {
			mwb_wqv_add_to_cart_url = mwb_wqv_add_to_cart_url.substring(0, mwb_wqv_add_to_cart_url.indexOf("?"));	
		}
		let mwb_wqv_grouped_query = ""
		for (let mwb_wqv_keys in mwb_wqv_query_parameter_grouped)
			mwb_wqv_grouped_query += ("quantity"+mwb_wqv_keys) + '=' + encodeURIComponent(mwb_wqv_query_parameter_grouped[mwb_wqv_keys]) + '&';
		mwb_wqv_grouped_query = mwb_wqv_grouped_query.slice(0, -1);
		mwb_wqv_add_to_cart_url = mwb_wqv_add_to_cart_url + '?add-to-cart=' + mwb_wqv_grouped_id + '&' + mwb_wqv_grouped_query;
		window.location.replace(mwb_wqv_add_to_cart_url);
	});
})( jQuery );
