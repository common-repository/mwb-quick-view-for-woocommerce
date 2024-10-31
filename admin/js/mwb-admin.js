jQuery(document).ready(function(){
    if (jQuery('#mwb_wqv_exclude_product').is(':checked')) {
        jQuery('#wqv_excluded_categories_array').closest('.mwb-form-group').hide();
    }
    if (jQuery('#mwb_wqv_exclude_category').is(':checked')) {
        jQuery('#wqv_excluded_products_array').closest('.mwb-form-group').hide();
    }
    if (!(jQuery('#mwb_wqv_exclude_product').is(':checked')) && !(jQuery('#mwb_wqv_exclude_category').is(':checked'))) {
        jQuery('#wqv_excluded_categories_array').closest('.mwb-form-group').hide();
        jQuery('#wqv_excluded_products_array').closest('.mwb-form-group').hide();
    }
    jQuery(document).on('change','#mwb_wqv_exclude_product',function(){
        if(jQuery(this).is(':checked')){
            jQuery('#wqv_excluded_categories_array').closest('.mwb-form-group').hide();
            jQuery('#wqv_excluded_products_array').closest('.mwb-form-group').show();
            jQuery('#mwb_wqv_exclude_category').closest('.mdc-switch').removeClass('mdc-switch--checked');
            jQuery('#mwb_wqv_exclude_category').prop('value','off');
            jQuery(this).prop('value','on');
            jQuery('#mwb_wqv_exclude_category').prop('checked',false);
            jQuery('#mwb_wqv_exclude_category').attr('aria-checked','false');
        } else if (!(jQuery('#mwb_wqv_exclude_product').is(':checked')) && !(jQuery('#mwb_wqv_exclude_category').is(':checked'))) {
            jQuery('#wqv_excluded_categories_array').closest('.mwb-form-group').hide();
            jQuery('#wqv_excluded_products_array').closest('.mwb-form-group').hide();
        }
    });
    jQuery(document).on('change','#mwb_wqv_exclude_category',function(){
        if(jQuery(this).is(':checked')){
            jQuery('#wqv_excluded_categories_array').closest('.mwb-form-group').show();
            jQuery('#wqv_excluded_products_array').closest('.mwb-form-group').hide();
            jQuery('#mwb_wqv_exclude_product').closest('.mdc-switch').removeClass('mdc-switch--checked');
            jQuery('#mwb_wqv_exclude_product').prop('value','off');
            jQuery(this).prop('value','on');
            jQuery('#mwb_wqv_exclude_product').prop('checked',false);
            jQuery('#mwb_wqv_exclude_product').attr('aria-checked','false');
        } else if (!(jQuery('#mwb_wqv_exclude_product').is(':checked')) && !(jQuery('#mwb_wqv_exclude_category').is(':checked'))) {
            jQuery('#wqv_excluded_categories_array').closest('.mwb-form-group').hide();
            jQuery('#wqv_excluded_products_array').closest('.mwb-form-group').hide();
        }
    });

    jQuery(document).on( 'change', 'input[type=radio]', function() {
        if ( jQuery(this).val() == 'mwb_wqv_anim_default') {
            jQuery('#mwb_wqv_animation_preview_button').on('click',function(e){
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1'); 
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1_reverse');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2_reverse');
                e.preventDefault();
                jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim_default');
                jQuery('body').addClass('modal-outside');
             });
             jQuery('#close').click(function () { 
                if(jQuery('#mwb_wqv_popup').hasClass('mwb_wqv_anim_default')) {
                    jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim_default');  
                    jQuery('body').removeClass('modal-outside');
             }
              
             });
        } else if ( jQuery(this).val() == 'mwb_wqv_anim1') {
            jQuery('#mwb_wqv_animation_preview_button').on('click',function(e){
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim_default');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1_reverse');
                e.preventDefault();
                jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim1');
                jQuery('body').addClass('modal-outside');
            });
            jQuery('#close').click(function () {
                if(jQuery('#mwb_wqv_popup').hasClass('mwb_wqv_anim1')){
                    jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1');
                    jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim1_reverse');       
                    jQuery('body').removeClass('modal-outside');
            }
        });
        } else if ( jQuery(this).val() == 'mwb_wqv_anim2') {
            jQuery('#mwb_wqv_animation_preview_button').on('click',function(e){
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim_default');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2_reverse');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1_reverse');
                e.preventDefault();
                jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim2');
              
                jQuery('body').addClass('modal-outside');
              });
            jQuery('#close').click(function () {
                if(jQuery('#mwb_wqv_popup').hasClass('mwb_wqv_anim2')){
                    jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim2_reverse');
                    jQuery('body').removeClass('modal-outside');
                    jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2');
                }
            });
        }
    });

    if ( jQuery('input[name="mwb_wqv_animation"]:checked').val() == 'mwb_wqv_anim_default') {
        jQuery('#mwb_wqv_animation_preview_button').on('click',function(e){
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1'); 
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2');
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1_reverse');
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2_reverse');
            e.preventDefault();
            jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim_default');
            jQuery('body').addClass('modal-outside');
         });
         jQuery('#close').click(function () { 
            if(jQuery('#mwb_wqv_popup').hasClass('mwb_wqv_anim_default')) {
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim_default');  
                jQuery('body').removeClass('modal-outside');
         }
          
         });
    } else if ( jQuery('input[name="mwb_wqv_animation"]:checked').val() == 'mwb_wqv_anim1') {
        jQuery('#mwb_wqv_animation_preview_button').on('click',function(e){
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim_default');
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2');
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1_reverse');
            e.preventDefault();
            jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim1');
            jQuery('body').addClass('modal-outside');
        });
        jQuery('#close').click(function () {
            if(jQuery('#mwb_wqv_popup').hasClass('mwb_wqv_anim1')){
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1');
                jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim1_reverse');       
                jQuery('body').removeClass('modal-outside');
        }
    });
    } else if ( jQuery('input[name="mwb_wqv_animation"]:checked').val() == 'mwb_wqv_anim2') {
        jQuery('#mwb_wqv_animation_preview_button').on('click',function(e){
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1');
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim_default');
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2_reverse');
            jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim1_reverse');
            e.preventDefault();
            jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim2');
            jQuery('body').addClass('modal-outside');
          });
        jQuery('#close').click(function () {
            if(jQuery('#mwb_wqv_popup').hasClass('mwb_wqv_anim2')){
                jQuery('#mwb_wqv_popup').addClass('mwb_wqv_anim2_reverse');
                jQuery('body').removeClass('modal-outside');
                jQuery('#mwb_wqv_popup').removeClass('mwb_wqv_anim2');
            }
        });
    }

});
