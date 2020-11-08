(function ($) {
    $(function () {
      var AjaxUrl                   = edn_pro_script_variable.ajax_url;
      var admin_nonce               = edn_pro_script_variable.ajax_nonce;

      var saving_data               = edn_pro_script_variable.saving_msg;
      var saved_data                = edn_pro_script_variable.saved_data;
      var plugin_pathinfo           = edn_pro_script_variable.plugin_pathinfo;

    $('.apexnb-selection').selectbox(); 
    /*
    * Tab Plugin Settings
    */
    $( '.apexnb-tabs-trigger' ).click(function(){
        $( '.apexnb-tabs-trigger' ).removeClass( 'nav-tab-active' );
        $(this).addClass( 'nav-tab-active' );
        var board_id = $(this).attr('data-tab');
        $('.apexnb-lite-tab-content').hide().removeClass('current');
        $('#'+board_id).fadeIn(300).addClass('current');
        if(board_id == "optin_settings" || board_id == "how_to_use" || board_id == "about"){
          $('.edn_submit_section').hide();
        }else{
           $('.edn_submit_section').show();
        }
    });
    $('#apexnb_lite_tabs').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');

     /* Bar layuout with preview images */
    $('#edn_bar_template').change(function(){
          var templateid = $(this).val();
          $('.edn-template-preview').hide();
          $('.edn-template-previewbox-'+templateid).fadeIn(500).show();
    });

    var current_templateid = $( "#edn_bar_template option:selected" ).val();
    if(current_templateid != ''){
         $('.edn-template-previewbox-'+current_templateid).show(); 
     }

     /* Visibility Change */
        $('.edn-visibility').change(function(){
            var val = $(this).val();
           if(val == "show-time"){
              $('.edn-time-hide').find('.edn-visibility-hidetime').hide();
              $('.edn-time').find('.edn-visibility-showtime').show();
            
           }else if(val=="hide-time"){
             $('.edn-time').find('.edn-visibility-showtime').hide();
             $('.edn-time-hide').find('.edn-visibility-hidetime').show();
           }else{
             $('.edn-time').find('.edn-visibility-showtime').hide();
             $('.edn-time-hide').find('.edn-visibility-hidetime').hide();
           }
        });

        var visibletype = $('.edn-visibility option:selected').val();
        if(visibletype == "show-time"){
              $('.edn-time-hide').find('.edn-visibility-hidetime').hide();
              $('.edn-time').find('.edn-visibility-showtime').show();
            
           }else if(visibletype=="hide-time"){
             $('.edn-time').find('.edn-visibility-showtime').hide();
             $('.edn-time-hide').find('.edn-visibility-hidetime').show();
           }else{
             $('.edn-time').find('.edn-visibility-showtime').hide();
             $('.edn-time-hide').find('.edn-visibility-hidetime').hide();
           }

    /* Controls On Change */
        $('#edn-close-button').change(function(){
            if($(this).val() == "user-can-close"){
                $('.edn_close_once').show();
                 $('.edn_show_hide').hide();
                 $('.showhide_duration_time').hide();
                  if ($('#show_once').is(':checked')) {
                     $('.duration_time').show();
                }else{
                      $('.duration_time').hide();
                }
            }else if($(this).val() == "show-hide"){
                $('.edn_show_hide').show();
                 $('.edn_close_once').hide();
                 $('.duration_time').hide();
            
            }else{
                    $('.edn_close_once').hide(); 
                    $('.duration_time').hide();
                    $('.edn_show_hide').hide(); 
            }
           
        });

      var selected_button = $('#edn-close-button option:selected').val();
      if(selected_button== "user-can-close"){
        $('.edn_close_once').show();
         $('.edn_show_hide').hide();
          if ($('#show_once').is(':checked')) {
                     $('.duration_time').show();
                }else{
                      $('.duration_time').hide();
                }
      }else if(selected_button == "show-hide"){
                 $('.edn_show_hide').show();
                 $('.edn_close_once').hide();
                 $('.duration_time').hide();
      }else{
                    $('.edn_close_once').hide(); 
                    $('.duration_time').hide();
                    $('.edn_show_hide').hide(); 
      }

          $('#show_once').change(function () {
                if ($(this).is(':checked')) {
                 $('.duration_time').show();
                }else{
                      $('.duration_time').hide();
                }
            });
        /* added features for show/hide duration start*/
         $('#show_once_hideshow').change(function () {
                if ($(this).is(':checked')) {
                 $('.showhide_duration_time').show();
                }else{
                      $('.showhide_duration_time').hide();
                }
            });
      /* added features for show/hide end*/
     
    /* Social Icons Lists */
      $('#edn-show-add-fields').click(function(){
                $('.edn-social-empty').toggle();
            });
    //font awesome icons chooser
    $('.edn-font-icon-chooser').on('click',function () {
        $('.edn-font-awesome-icons').show();
    });
    
      //fontawesome icon chooser close
       $('.edn-close-font,.edn-lightbox').click(function () {
                $('.edn-font-awesome-icons').hide();
                $('.edn-fa-icons-wrap').hide();
      });

    //Adding social icon to list 
     $('#edn-social-add').click(function () {
                error_flag = 0;
                if ($('#edn-icon-title').val() == '')
                {
                    error_flag = 1;
                    var error_html = $('#edn-icon-title').attr('data-error-msg');
                    $('#edn-icon-title').closest('.edn-field-wrapper').find('.edn-error').html(error_html);
                }
                if ($('#edn-icon-link').val() == '')
                {
                    error_flag = 1;
                    var error_html = $('#edn-icon-link').attr('data-error-msg');
                    $('#edn-icon-link').closest('.edn-field-wrapper').find('.edn-error').html(error_html);
                }
                var bar_type2 = $('input[name="edn_bar_type"]:checked').val();
                if(bar_type2 == 1){ //custom
                   if ($('#edn-font-awesome-icon').val() == '' && $('#edn-custom-icon').val() == '')
                        {
                            error_flag = 1;
                            var error_html = $('#edn-font-awesome-icon').attr('data-error-msg');
                            $('#edn-font-awesome-icon').closest('.edn-field-wrapper').find('.edn-error').html(error_html);
                        }
                }else{
                    if ($('#edn-font-awesome-icon').val() == '')
                    {
                        error_flag = 1;
                        var error_html = $('#edn-font-awesome-icon').attr('data-error-msg');
                        $('#edn-font-awesome-icon').closest('.edn-field-wrapper').find('.edn-error').html(error_html);
                    }
                }
                
    
                if (error_flag == 0)
                {
                        var icon_title = $('#edn-icon-title').val();
                       
                         var bartype = $('input[name="edn_bar_type"]:checked').val();
                      
                        var font_icon = $('.available-icons').find('#edn-font-awesome-icon').val();

                        var icon_link = $('#edn-icon-link').val();
                        var apsFontIconReference = 0;
                        var append_html =
                                '<li class="edn-sortable-icons">' +
                                '<div class="edn-drag-icon"></div>' +
                                '<div class="edn-icon-head"><span class="edn-icon-name">' + icon_title + '</span><span class="edn-icon-list-controls"><span class="edn-arrow-down edn-arrow button button-secondary"><i class="dashicons dashicons-arrow-down"></i></span>&nbsp;&nbsp;<span class="edn-delete-icon button button-secondary" aria-label="delete icon"><i class="dashicons dashicons-trash"></i></span></span></div>' +
                                '<div class="edn-icon-body" style="display: none;">' +
                                '<div class="edn-icon-preview">' +
                                '<label>' + edn_pro_script_variable.icon_preview + '</label>';
                        append_html += '<i class="' + font_icon + '" id="aps-font-icon-' + apsFontIconReference++ + '"></i>';
                        append_html += '</div>' +
                                '<div class="edn-icon-detail-wrapper">' +
                                '<div class="edn-icon-each-detail">' +
                                '<label>' + edn_pro_script_variable.icon_link + '</label>' +
                                '<div class="edn-icon-detail-text">' + icon_link + '</div>' +
                                '</div>' +
                                '<div class="edn-icon-each-detail">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<input type="hidden" name="icons[' + icon_title + '][title]" value="' + icon_title + '"/>' +
                                '<input type="hidden" name="icons[' + icon_title + '][font_icon]" value="' + font_icon + '"/>' +
                                '<input type="hidden" name="icons[' + icon_title + '][link]" value="' + icon_link + '"/>' +
                                '</li>';
                        $('.edn-icon-list').append(append_html);
                        if (!$('.edn-icon-theme-expand').is(':visible'))
                        {
                            $('.edn-icon-theme-expand').show();
                        }
                        if ($('.edn-icon-list-wrapper p').is(':visible'))
                        {
                            $('.edn-icon-list-wrapper p').hide();
                        }
                        $('.edn-social-empty input[type="text"]').each(function () {
                            $(this).val('');
                        });
                        $('.edn-social-empty').hide();
                }
            });


       /* Icon each add */     
           $(document).keyup(function(e) {
                 if (e.keyCode == 27) { // escape key maps to keycode `27`
                  $('.edn-font-awesome-icons').hide();
                  $('.edn-fa-icons-wrap').hide();
                }
            });

            $('.edn-font-awesome-icons .fontawesome-icon-list a').click(function (e) {
                e.preventDefault();
                var attr_class = $(this).find('i').attr('class').replace('fa-3x', '');
                var append_html = '<i class="' + attr_class + '"></i>';
                $('.edn-font-icon-preview').html(append_html);
                $('#edn-font-awesome-icon').val(attr_class);
                $('.edn-font-awesome-icons').hide();
            });
            
            //font awesome icons chooser show lightbox  for edit 
            $('.edn-edit-font-icon-chooser').click(function () {
                var id = this.id;
                $('.edn-fa-icons-wrap').addClass(id);
                $('.'+id).show();
            });
            /* Display choose icon on preview */
            $('.edn-fa-icons-wrap .fontawesome-icon-list a').click(function (e) {
                e.preventDefault();
                var attr_class = $(this).find('i').attr('class').replace('fa-3x', '');
                var append_html = '<i class="' + attr_class + '"></i>';
                $('.edn-font-icon-preview').html(append_html);
                $(this).closest('.edn-field').find('.edn-edit-font-awesome-icon').val(attr_class);
                $('.edn-fa-icons-wrap').hide();
            });
            /* hide error msg on keyup for social text*/       
            $('.edn-social-empty input').keyup(function () {
                $(this).closest('.edn-field-wrapper').find('.edn-error').html('');
            });

         
///////////////////////////////////////////////////////////////////////////////////////////////////
             //sortable initialization
               $('.edn-nb-list').sortable({
                    containment: "parent"
               });
                
              //Add sortable posts list if selected display posts by id
                $("#edn_add_posts").click(function(){  
                var checkedval = $('input[name="edn_nb-add-check[]"]:checked').length;
            
                if (checkedval != 0) {
                       $('#edn-nb-list-wrapper').show();
                       $('.nb-add-check').each(function(){
                       if($(this).is(':checked') ){
                            var list_val = $(this).val();
                            var list_text = $(this).data('postname');
                               if($('.edn-nb-list #end_pro-list-'+list_val).length==0){
                                   $('.edn-nb-list').append('<div class="edn-indiv-nb-disp-id ui-sortable" val="'+list_val+'" id="end_pro-list-'+list_val+'"><input type="hidden" name="edn_display[]" value="'+list_val+'"/><span class="ednpro_cusrom-arrows"><i class="fa fa-arrows"></i></span><span class="edn-by-id">'+list_text+'</span><a href="#" class="remove_field"><i class="dashicons dashicons-trash"></i></a></div>');      
                               }
                             }                    
                           });
                       }
                       else
                      { alert('Please Select Atleast One.'); }
                });

            /* Display bar to specific pages/posts Notification bar settings page*/
                $("#edn_add_pages").click(function(){  
                var checkedvall = $('input[name="edn_add_spage[]"]:checked').length;
       
                if (checkedvall != 0) {
                       $('#edn-nb-list-wrapper').show();
                       $('.nb-add-check').each(function(){
                       if($(this).is(':checked') ){
                            var list_val = $(this).val();
                            var list_text = $(this).data('postname');
                               if($('.edn-nb-list2 #end_pro-list-'+list_val).length==0){
                                   $('.edn-nb-list2').append('<div class="edn-indiv-nb-disp-id edn-indiv-nb-disp-pages" val="'+list_val+'" id="end_pro-list-'+list_val+'"><input type="hidden" name="edn_showpages[]" value="'+list_val+'"/><span class="ednpro_cusrom-arrows"><i class="fa fa-arrows"></i></span><span class="edn-by-id">'+list_text+'</span><a href="#" class="remove_field"><i class="dashicons dashicons-trash"></i></a></div>');      
                               }
                             }                    
                           });
                       }
                       else
                      { alert('Please Select Atleast One.'); }
                });
                 
              //Delete testimonial when selected display testimonial by id    
               $('.edn-nb-list,.edn-nb-list2').on("click",".remove_field", function(e){
                   e.preventDefault();
                        var r = confirm("Do you want to delete this selection?");
                        if (r == true) {
                             $(this).parent('div').remove();
                        } 
                  
               });

                 /* search by title */
                var $block = $('.no-results');
                $("#ednpro_filter").keyup(function() {
                    var val = $(this).val();
                    var isMatch = false;
                    
                    $("a.row-title").each(function(i) {
                        var content = $(this).text();
                        if(content.toLowerCase().indexOf(val) == -1) {
                            $(this).closest('tr').fadeOut();          
                        
                        } else {
                            isMatch = true;
                            $(this).closest('tr').show();
                             
                        }
                    });
                    
                    $block.toggle(!isMatch);
                });

        // Notificaiton show on pages settings Options
         $('#edn-notify-on-pages').change(function () {
           
                if ($(this).val() == "specific_pages") {
                    $('.show_pages_lists').show();
                    $('.show_cat_lists').hide();
                }else if($(this).val() == "specific_categories"){
                    $('.show_cat_lists').show();
                    $('.show_pages_lists').hide();
                }else{
                    $('.show_pages_lists').hide();
                    $('.show_cat_lists').hide();
                }
            });

         if ($( "#edn-notify-on-pages option:selected" ).val() == "specific_pages") {
                $('.show_pages_lists').show();
                $('.show_cat_lists').hide();
            }else if ($( "#edn-notify-on-pages option:selected" ).val() == "specific_categories") {
                $('.show_pages_lists').hide();
                 $('.show_cat_lists').show();
            }
            else{
                $('.show_pages_lists').hide();
                $('.show_cat_lists').hide();
            }

         //Notificaiton show on pages settings Options End

            
        $('#edn-add-button').click(function(){
            var error_html = $('input[name="edn_bar_name"]').data('error-msg');
            var error_flag = 0;
            if($('input[name="edn_bar_name"]').val() == ''){
                error_flag = 1;
                $('input[name="edn_bar_name"]').closest('.edn-field-wrapper').find('.edn-error').html(error_html);
            }
            if (error_flag == 1)
            {
                return false;
            }
            else
            {
                return true;
            }
        });
        $('.edn-add-trigger-button').click(function(){
            $('#edn-add-button').click();
        });
        
        // Choose Notification bar type
            $('input:radio[name="edn_bar_type"]').click(function () {
                if($('.edn-hidden-bar-name').val() !==''){
                   
                    if(confirm(edn_pro_script_variable.bar_warning)){
                        if ($(this).val() == 1)
                        { //custom design
                            $('.edn-template-chooser').hide();
                            $('.edn-hide-in-pre-tpl').show();
                            $('.apexnb_background_image_toggle').show();
                           if($("#edn-notification-comp").is(':checked')){
                              $('.edn-components-wrap').show();
                           }else{
                              $('.edn-components-wrap').hide();
                           }
                           
                            $('.edn-common-option-panel').show();
                            $('.edn-font-demo-wrap').show();
                         //   $('.edn-custom-social-color').show();
                            $('.edn-custom-countdown-color').show(); //countdown design
                              $('.edn-custom-hide').show(); // custom video design
                            $('.edn-show-border-color').show();//open panel show border color
                           
                            var icon_type = $('.edn_icon_types option:selected').val();
                            if(icon_type == "custom_icon"){
                                 $('.edn_icon_types').closest('.edn-col-icons').find('.customicons').show();
                                 $('.edn_icon_types').closest('.edn-col-icons').find('.available-icons').hide();
                            }else if(icon_type == "available_font_icon"){
                                  $('.edn_icon_types').closest('.edn-col-icons').find('.customicons').hide();
                               $('.edn_icon_types').closest('.edn-col-icons').find('.available-icons').show();
                            }

                            $('.edn-template-preview').hide();

                        }
                        else
                        {
                            var selectedprebar = $('.edn_bar_template option:selected').val();
                            $('.edn-template-preview').hide();
                            $('.edn-template-previewbox-'+selectedprebar).show();
                            $('.edn-hide-in-pre-tpl').hide();
                            $('.apexnb_background_image_toggle').hide();
                            $('.edn-template-chooser').show();
                            $('.edn-font-demo-wrap').hide();
                          //  $('.edn-custom-social-color').hide();
                            $('.edn-custom-countdown-color').hide();
                             $('.edn-custom-hide').hide();
                             $('.edn-show-border-color').hide(); //open panel hide border color
                            if($('input:radio[name="edn_bar_template"]#edn-template-3').is(':checked')){
                                $('.edn-components-wrap').hide();
                                $('.edn-common-option-panel').hide();
                            }else{
                                $('.edn-components-wrap').show();
                                $('.edn-common-option-panel').show();
                            } 
                            
                            $('.available-icons').show();
                            $('.customicons').hide();
                        }
                    }else{
                        return false;
                    }
                }else{
                  
                    if ($(this).val() == 1)
                    {
                        $('.edn-template-chooser').hide();
                        $('.edn-hide-in-pre-tpl').show();
                        $('.apexnb_background_image_toggle').show();
                         $('.edn-font-demo-wrap').show();
                      //   $('.edn-custom-social-color').show();
                         $('.edn-custom-countdown-color').show();
                          $('.edn-custom-hide').show();
                         $('.edn-show-border-color').show();
                      
                           var icon_type = $('.edn_icon_types option:selected').val();
                            if(icon_type == "custom_icon"){
                                  $('.edn_icon_types').closest('.edn-col-icons').find('.customicons').show();
                                 $('.edn_icon_types').closest('.edn-col-icons').find('.available-icons').hide();
                            }else if(icon_type == "available_font_icon"){
                                  $('.edn_icon_types').closest('.edn-col-icons').find('.customicons').hide();
                               $('.edn_icon_types').closest('.edn-col-icons').find('.available-icons').show();
                            }
                    }
                    else
                    {
                         $('.edn-hide-in-pre-tpl').hide();
                         $('.apexnb_background_image_toggle').hide();
                         $('.edn-template-chooser').show();
                         $('.edn-font-demo-wrap').hide();
                        // $('.edn-custom-social-color').hide();
                         $('.edn-custom-countdown-color').show();
                         $('.edn-custom-hide').show();
                         $('.edn-show-border-color').hide();
                         $('.available-icons').show();
                         $('.customicons').hide();
                    }
                }
            });     
            $('.edn-template').click(function(){
                if($(this).val()==3){

                    $('.edn-components-wrap').show();
                    $('.edn-common-option-panel').show();
                }else{
                    $('.edn-components-wrap').show();
                    $('.edn-common-option-panel').show();
                }
            });   

            if($('input:radio[name="edn_bar_type"]#edn_individual').is(':checked')){
                $('.edn-row.edn-template-chooser').css('display','none');
                $('.edn-hide-in-pre-tpl').show();
                $('.apexnb_background_image_toggle').show();
                 $('.edn-font-demo-wrap').show();
                 //$('.edn-custom-social-color').show();
                  $('.edn-custom-countdown-color').show();
                  $('.edn-custom-hide').show();
                  $('.edn-show-border-color').show();
                
            }else{
                $('.edn-template-chooser').show();
                $('.edn-hide-in-pre-tpl').hide();
                $('.apexnb_background_image_toggle').hide();
                //$('.edn-custom-social-color').hide();
                 $('.edn-custom-countdown-color').hide();
                 $('.edn-custom-hide').hide();
                            $('.available-icons').show();
                            $('.customicons').hide();
                            $('.edn-show-border-color').hide();
            }//Choose Notification bar type end


            $('.edn-icon-list').on('click', '.edn-icon-head', function (e) {
                if ($(this).parent().find('.edn-arrow i').hasClass('dashicons-arrow-down'))
                {
                    $(this).parent().find('i.dashicons-arrow-down').removeClass('dashicons-arrow-down').addClass('dashicons-arrow-up');
                }
                else
                {
                    $(this).parent().find('i.dashicons-arrow-up').removeClass('dashicons-arrow-up').addClass('dashicons-arrow-down');
    
                }
                $(this).closest('.edn-sortable-icons').find('.edn-icon-body').slideToggle(500);
                //e.stopPropagation();
            });
    
            $('.edn-icon-list').on('click', '.edn-delete-icon', function () {
                if (confirm(edn_pro_script_variable.icon_delete_confirm))
                {
                   // var icon_counter = $('#edn-icon-counter').val();
                    //icon_counter--;                  
                    //$('#edn-icon-counter').val(icon_counter);
                    var selector = $(this);
                    $(this).closest('.edn-sortable-icons').fadeOut(800, function () {
                        selector.closest('.edn-sortable-icons').remove();
                    });
                    return false;
                }
            });
    
            //sortable initialization
            $('.edn-icon-list').sortable({
                 containment: "parent" 
            });
            
            //Theme icons expand colledne trigger
            $('.edn-icon-theme-expand').click(function () {
                if ($(this).html() === edn_pro_script_variable.icon_expand)
                {
                    $('.edn-icon-body').slideDown(500)
                    $(this).html(edn_pro_script_variable.icon_collapse)
                    $('i.dashicons-arrow-down').removeClass('dashicons-arrow-down').addClass('dashicons-arrow-up');
                }
                else
                {
                    $('.edn-icon-body').slideUp(500)
                    $('i.dashicons-arrow-up').removeClass('dashicons-arrow-up').addClass('dashicons-arrow-down');
                    $(this).html(edn_pro_script_variable.icon_expand);
                }
            });
            //icon width preview
            $('#edn-icon-width').keyup(function () {
                $('.edn-image-icon-preview img').css({
                    'width': $(this).val()
                });
            });
        
            //border style preview
            $('#edn-icon-height').keyup(function () {
                $('.edn-image-icon-preview img').css({
                    'height': $(this).val()
                });
            });
            
        /* End of Social Network Section */ 

        //Choose Notification Components
            $('select[name="edn_cp_type"]').change(function(){
                var val = $(this).val();
                if(val=='text'){
                    $('.edn-cp-block').hide();
                    $('.edn-bar-effects').hide();
                    $('#edn-cp-text').show();
                    if ($('input[name="edn_text_display_mode"]:checked').val()=='static') {
                        $('.edn-multiple-content-wrap').hide();
                        $('.edn-static-content-wrap').show();
                        $('.edn-bar-effects').hide();
                    }else{
                        $('.edn-static-content-wrap').hide();
                        $('.edn-multiple-content-wrap').show();
                        $('.edn-bar-effects').show();
                    }//Choose Content Display Mode end
                }else if(val=='email-subs'){
                    $('.edn-cp-block').hide();
                    $('.edn-bar-effects').hide();
                    $('#edn-cp-subscribe').show();
                }else if(val=='post-title'){
                    $('.edn-cp-block').hide();
                    $('#edn-post-title').show();
                    $('.edn-bar-effects').show();
                }else if(val=='search-form'){
                    $('.edn-cp-block').hide();
                    $('#edn-search-form-content').show();
                    $('.edn-bar-effects').hide();
                }else if(val=='social-icons'){
                    $('.edn-cp-block').hide();
                    $('#edn-cp-social-icons').show();
                    $('.edn-bar-effects').hide();
                }else{
                  $('.edn-cp-block').hide();

                   $('.edn-bar-effects').hide();
                }
            });
           // var edn_cp_type = $('input[name="edn_cp_type"]:checked').val();
            var edn_cp_type = $('select[name="edn_cp_type"] option:selected').val();
            if(edn_cp_type=='text'){
                $('.edn-cp-block').hide();
                $('.edn-bar-effects').hide();
                $('#edn-cp-text').show();
            }else if(edn_cp_type=='email-subs'){
                $('.edn-cp-block').hide();
                $('.edn-bar-effects').hide();
                $('#edn-cp-subscribe').show();
            }else if(edn_cp_type == 'post-title'){
                $('.edn-cp-block').hide();
                $('#edn-post-title').show();
                $('.edn-bar-effects').show();
            }else if(edn_cp_type=='search-form'){
                $('.edn-cp-block').hide();
                $('#edn-search-form-content').show();
                $('.edn-bar-effects').hide();
            }else if(edn_cp_type=='social-icons'){
                    $('.edn-cp-block').hide();
                    $('#edn-cp-social-icons').show();
                    $('.edn-bar-effects').hide();
            } else{
                    $('.edn-cp-block').hide();
                    $('#edn-social-panel').hide();
                    $('.edn-bar-effects').hide();
            }//Choose Notification Components end


        //multiple content button action
            $('#edn-add-mcontent').click(function(){
                $('.edn-add-multiple-content').toggle();
            });
            
        //Choose Content Display Mode
            $('input[name="edn_text_display_mode"]').click(function () {
                if ($(this).val()=='static') {
                    $('.edn-multiple-content-wrap').hide();
                    $('.edn-static-content-wrap').show();
                    $('.edn-bar-effects').hide();
                    $(this).attr('checked','checked');
                }else{
                    $('.edn-static-content-wrap').hide();
                    $('.edn-multiple-content-wrap').show();
                    $('.edn-bar-effects').show();
                    $(this).attr('checked','checked');
                }
            });
            
            if(edn_cp_type=='text'){
                if ($('input[name="edn_text_display_mode"]:checked').val()=='static') {
                    $('.edn-multiple-content-wrap').hide();
                    $('.edn-static-content-wrap').show();
                    $('.edn-bar-effects').hide();
                }else{
                    $('.edn-static-content-wrap').hide();
                    $('.edn-multiple-content-wrap').show();
                    $('.edn-bar-effects').show();
                }//Choose Content Display Mode end
            }
        
        // Call to action button
            $('.edn-show-call-button').change(function () {
                if ($(this).is(':checked')) {
                    $('.edn-call-to-action-type').show();
                    $('.end-call-to-action-block').show();
                }else{
                    $('.edn-call-to-action-type').hide();
                    $('.end-call-to-action-block').hide();
                }
            });
            if ($('.edn-show-call-button').is(':checked')) {
                $('.edn-call-to-action-type').show();
                $('.end-call-to-action-block').show();
            }else{
                $('.edn-call-to-action-type').hide();
                $('.end-call-to-action-block').hide();
            }//edn-show-m-call-button
        
        //Choose call to action type  for static
            $('input[name="edn_static[call_action_button]"]').click(function(){
                var val = $(this).val();
                if(val=='custom'){
                    $('.edn-call-action').hide();
                    $('#edn-custom-button-block').show();
                }else if(val=='contact'){
                    $('.edn-call-action').hide();
                    $('#edn-contact-button-block').show();
                }
                else if(val=='shortcode-popup'){
                    $('.edn-call-action').hide();
                    $('#edn-shortcode-button-block').show();
                }
            });
            if($('.edn-call-action-type:checked').val()=='custom'){
                $('.edn-call-action').hide();
                $('#edn-custom-button-block').show();
            }else if($('.edn-call-action-type:checked').val()=='contact'){
                $('.edn-call-action').hide();
                $('#edn-contact-button-block').show();
            } else if($('.edn-call-action-type:checked').val()=='shortcode-popup'){
                    $('.edn-call-action').hide();
                    $('#edn-shortcode-button-block').show();
                }
        
        //Choose Contact From for static
            $('input[name="edn_static[contact_choose]"]').click(function(){
                var val = $(this).val();
                if(val=='c-form'){
                    $('.edn-cotnact-from').hide();
                    $('#edn-contact-custom-form').show();
                }else if(val=='form-7'){
                    $('.edn-cotnact-from').hide();
                    $('#edn-contact-form-7').show();
                }
            });
            if($('input[name="edn_static[contact_choose]"]:checked').val()=='c-form'){
                $('.edn-cotnact-from').hide();
                $('#edn-contact-custom-form').show();
            }else{
                $('.edn-cotnact-from').hide();
                $('#edn-contact-form-7').show();
            }
        
        // Multiple Call to action button
        $('.edn-show-m-call-button').change(function () {
            if ($(this).is(':checked')) {
                $('.edn-m-call-to-action-type').show();
                $('.end-m-call-to-action-block').show();
            }else{
                $('.edn-m-call-to-action-type').hide();
                $('.end-m-call-to-action-block').hide();
            }
        });
        
        //Choose call to action type for multiple
            $('input[name="edn_multi[action_button]"]').click(function(){
                var val = $(this).val();
                if(val=='custom'){
                    $('.edn-m-call-action').hide();
                    $('#edn-m-custom-button-block').show();
                }else if(val=='contact'){
                    $('.edn-m-call-action').hide();
                    $('#edn-m-contact-button-block').show();
                }else if(val=='shortcode-popup'){
                    $('.edn-m-call-action').hide();
                    $('#edn-m-shortcode-button-block').show();
                }
            });
            if($('input[name="edn_multi[action_button]"]:checked').val()=='custom'){
                $('.edn-m-call-action').hide();
                $('#edn-m-custom-button-block').show();
            }else if($('input[name="edn_multi[action_button]"]:checked').val()=='contact'){
                $('.edn-m-call-action').hide();
                $('#edn-m-contact-button-block').show();
            }else if($('input[name="edn_multi[action_button]"]:checked').val()=='shortcode-popup'){
                    $('.edn-m-call-action').hide();
                    $('#edn-m-shortcode-button-block').show();
                }
        
        //Choose Contact From for multiple
            $('input[name="edn_multi[choose]"]').click(function(){
                var val = $(this).val();
                if(val=='c-form'){
                    $('.edn-m-cotnact-from').hide();
                    $('#edn-m-contact-custom-form').show();
                }else if(val=='form-7'){
                    $('.edn-m-cotnact-from').hide();
                    $('#edn-m-contact-form-7').show();
                }
            });
            if($('input[name="edn_multi[choose]"]:checked').val()=='c-form'){
                $('.edn-m-cotnact-from').hide();
                $('#edn-m-contact-custom-form').show();
            }else{
                $('.edn-m-cotnact-from').hide();
                $('#edn-m-contact-form-7').show();
            }


        //add multiple content
      //add multiple content
        $('#edn-add-mcontent-but').click(function(){

            //edn-append-mcontent-prevvar content;
            var inputid = 'edn-multiple-text';
            var editor = tinyMCE.get(inputid);
            var textArea = jQuery('textarea#' + inputid);    
            if (textArea.length>0 && textArea.is(':visible')) {
                content = textArea.val();        
            } else {
                content = editor.getContent();
            } 
            error_flag = 0;
            if (content == '')
            {
                error_flag = 1;
                var error_html = $('.edn-button-count').data('error-text-cont');
                $('#edn-multiple-text').closest('.edn-field-wrapper').find('.edn-error').html(error_html);
            }
            if (error_flag == 0)
                {
                    var content;
                    var inputid = 'edn-multiple-text';
                    var editor = tinyMCE.get(inputid);
                    var textArea = jQuery('textarea#' + inputid);    
                    if (textArea.length>0 && textArea.is(':visible')) {
                        content = textArea.val();        
                    } else {
                        content = editor.getContent();
                    }
  
                    var substr_content = content.substr(0,8);
                    // var call_to_action = $('.edn-multiple-content-wrap .edn-show-m-call-button:checked').val();
                      if($(this).parent().parent().parent().parent().parent().find('.edn-show-m-call-button').is(':checked')){
                       var call_to_action = 1;
                      } else {
                          var call_to_action = 0;
                      }

                    var call_to_acction_type = $('.edn-multiple-content-wrap .edn-call-action-type:checked').val();
                    var link_but_text = $('.edn-multiple-content-wrap #edn-link-but-text').val();
                    var link_but_url = $('.edn-multiple-content-wrap #edn-link-url').val();
                    var link_target = $(this).parent().parent().parent().parent().parent().find('select option:selected').val();
                    var link_but_bg_color = $('.edn-multiple-content-wrap #edn-link-but-color').val();
                    var link_but_txt_color = $('.edn-multiple-content-wrap #edn-link-but-text-color').val();
                    var contact_form_type = $('.edn-multiple-content-wrap .edn-contact-choose:checked').val();
                      if(call_to_acction_type=='custom'){     
                             contact_form_type = '';
                         }else if(call_to_acction_type=='contact'){
                         contact_form_type = contact_form_type;
                         }else{
                        contact_form_type = '';
                         }

                       
                    var contact_bubtn_text = $('.edn-multiple-content-wrap #edn-cc-button-text').val();
                    var edn_cc_name_label = $('.edn-multiple-content-wrap #edn-cc-name-label').val();
                    var edn_cc_email_label = $('.edn-multiple-content-wrap #edn-cc-email-label').val();
                    var edn_cc_name_required = $('.edn-multiple-content-wrap #edn-cc-name-required').val();
                    var edn_cc_email_required = $('.edn-multiple-content-wrap #edn-cc-email-required').val();
                    var edn_cc_msg_required   = $('.edn-multiple-content-wrap #edn-cc-msg-required').val();
                    var edn_cc_msg_label = $('.edn-multiple-content-wrap #edn-cc-msg-label').val();
                    var edn_cc_send_mail = $('.edn-multiple-content-wrap #edn-cc-send-mail').val();
                    //added extra fields
                    var edn_cc_name_placeholder = $('.edn-multiple-content-wrap #edn-cc-name-placeholder').val();
                    var edn_cc_email_placeholder = $('.edn-multiple-content-wrap #edn-cc-email-placeholder').val();
                    var edn_cc_name_error_message = $('.edn-multiple-content-wrap #edn-cc-name-error').val();
                    var edn_cc_email_error_message = $('.edn-multiple-content-wrap #edn-cc-email-error').val();

                    var edn_cc_msg_error_message = $('.edn-multiple-content-wrap #edn-cc-msg-error').val();
                    var edn_cc_email_valid_error_message = $('.edn-multiple-content-wrap #edn-cc-email-valid-error').val();
                    var edn_cc_msg_placeholder = $('.edn-multiple-content-wrap #edn-cc-msg-placeholder').val();
                    var edn_cc_success_message = $('.edn-multiple-content-wrap #edn-cc-success-message').val();
                    var edn_cc_sendfail_msg = $('.edn-multiple-content-wrap #edn-cc-send-fail-msg').val();


                    var edn_form_shortcode = $('.edn-multiple-content-wrap #edn-form-shortcode').val();
                    var edn_custom_shortcode_text = $('.edn-multiple-content-wrap #edn-m-shortcode-button-text').val();
                    var edn_custom_shortcode = $('.edn-multiple-content-wrap #edn-m-custom-shortcode').val();
                  
                    // var cnt = $("ul.edn-append-mcontent-prev").children().length;
                    
                    // if(cnt > 0){
                    //   var count = parseInt(cnt)+1;
                    // }else{
                    //   var count = parseInt($('.edn-button-count').val())+1;
                    // }


                  var count =  randomstring(5);
                   
                    if(call_to_action){
                      
                        if(call_to_acction_type=='custom'){
                            var preview_content = '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.notification_bar_message+': '+content+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.link_but_text_label+': '+link_but_text+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.link_but_url_label+': '+link_but_url+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.link_but_target+': '+link_target+'</div></label>';
                        }else if(call_to_acction_type=='contact'){
                            if(contact_form_type=='c-form'){
                                var preview_content = '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.notification_bar_message+': '+content+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.name_label+': '+edn_cc_name_label+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.email_label+': '+edn_cc_email_label+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.name_required_label+': '+edn_cc_name_required+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.email_required_label+': '+edn_cc_email_required+'</div></label>'+
                                               '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.msg_required_label+': '+edn_cc_msg_required+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.message_label+': '+edn_cc_msg_label+'</div></label>'+
                                                '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.send_to_email_label+': '+edn_cc_send_mail+'</div></label>';
                                                 '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.name_placeholder_label+': '+edn_cc_name_placeholder+'</div></label>';
                                                  '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.email_placeholder_label+': '+edn_cc_email_placeholder+'</div></label>';
                                                   '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.message_placeholder_label+': '+edn_cc_msg_placeholder+'</div></label>';
                                                    '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.name_error_message_label+': '+edn_cc_name_error_message+'</div></label>';
                                                     '<label><div class="edn-prev-link-text"><div class="edn-prev-link-text">'+edn_pro_script_variable.email_error_message_label+': '+edn_cc_email_error_message+'</div></label>';
                                                    '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.msg_error_label+': '+edn_cc_msg_error_message+'</div></label>';
                                                      '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.validemail_error_message_label+': '+edn_cc_email_valid_error_message+'</div></label>';
                                                      '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.success_message+': '+edn_cc_success_message+'</div></label>';
                                                        '<label><div class="edn-prev-link-text"><div class="edn-prev-link-text">'+edn_pro_script_variable.send_fail_message+': '+edn_cc_sendfail_msg+'</div></label>';
                            }else{
                                var preview_content = '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.notification_bar_message+': '+content+'</div></label>'+
                                                    '<label><div class="edn-prev-link-text">'+edn_pro_script_variable.contact_form7_label+': '+edn_form_shortcode+'</div></label>';
                            }
                        }
                    }else{

                       var preview_content = '<label>No call to action activated for this text.</label>';
                    }

                    var append_html = 
                             // '<li class="edn-sortable-content"><div class="edn-content-head" id="edn-c-head_'+count+'"><span class="edn-content-title">'+substr_content.replace('<p>', '').replace('</p>', '')+'...</span>'+
                             '<li class="edn-sortable-content"><div class="edn-content-head" id="edn-c-head_'+count+'"><span class="edn-content-title">'+substr_content+'...</span>'+
                             '<span class="edn-content-list-controls"><span class="edn-arrow-down edn-arrow button button-secondary"><i class="dashicons dashicons-arrow-down"></i></span>&nbsp;&nbsp;<span class="edn-delete-content button button-secondary" aria-label="delete content"><i class="dashicons dashicons-trash"></i></span></span>'+
                             '</div><div class="edn-multiple-slide-down" style="display: none;"><div class="edn-multi-prev-slide-down">'+preview_content+'</div></div>'+
                             '<textarea class="wp-editor-area" name="edn_multiple[text_content]['+count+']" style="display: none;">'+content+'</textarea>'+
                             '<input type="hidden" name="edn_multiple[call_to_action]['+count+']" value="'+call_to_action+'">'+
                             '<input type="hidden" name="edn_multiple[call_to_acction_type]['+count+']" value="'+call_to_acction_type+'">'+
                             '<input type="hidden" name="edn_multiple[contact_form_type]['+count+']" value="'+contact_form_type+'">';
                   
                            append_html += '<input type="hidden" name="edn_multiple[contact_btn_text]['+count+']" value="'+contact_bubtn_text+'">'+    
                            '<input type="hidden" name="edn_multiple[link_but_text]['+count+']" value="'+link_but_text+'">'+
                             '<input type="hidden" name="edn_multiple[link_url]['+count+']" value="'+link_but_url+'">'+
                             '<input type="hidden" name="edn_multiple[link_target]['+count+']" value="'+link_target+'">';
                     
                        append_html +=
                        '<input type="hidden" name="edn_multiple[name_label]['+count+']" value="'+edn_cc_name_label+'">'+
                        '<input type="hidden" name="edn_multiple[email_label]['+count+']" value="'+edn_cc_email_label+'">'+
                        '<input type="hidden" name="edn_multiple[name_required]['+count+']" value="'+edn_cc_name_required+'">'+
                        '<input type="hidden" name="edn_multiple[email_required]['+count+']" value="'+edn_cc_email_required+'">'+
                        '<input type="hidden" name="edn_multiple[msg_required]['+count+']" value="'+edn_cc_msg_required+'">'+
                        '<input type="hidden" name="edn_multiple[msg_label]['+count+']" value="'+edn_cc_msg_label+'">'+
                        '<input type="hidden" name="edn_multiple[send_to_email]['+count+']" value="'+edn_cc_send_mail+'">'+
                        '<input type="hidden" name="edn_multiple[name_placeholder]['+count+']" value="'+edn_cc_name_placeholder+'">'+
                        '<input type="hidden" name="edn_multiple[email_placeholder]['+count+']" value="'+edn_cc_email_placeholder+'">'+
                        '<input type="hidden" name="edn_multiple[name_error_message]['+count+']" value="'+edn_cc_name_error_message+'">'+
                        '<input type="hidden" name="edn_multiple[msg_error]['+count+']" value="'+edn_cc_msg_error_message+'">'+
                        '<input type="hidden" name="edn_multiple[email_error_message]['+count+']" value="'+edn_cc_email_error_message+'">'+
                        '<input type="hidden" name="edn_multiple[email_valid_error_message]['+count+']" value="'+edn_cc_email_valid_error_message+'">'+
                        '<input type="hidden" name="edn_multiple[message_placeholder]['+count+']" value="'+edn_cc_msg_placeholder+'">'+
                        '<input type="hidden" name="edn_multiple[success_message]['+count+']" value="'+edn_cc_success_message+'">'+
                        '<input type="hidden" name="edn_multiple[sendfail_msg]['+count+']" value="'+edn_cc_sendfail_msg+'">';
               
               append_html +=
                        '<input type="hidden" name="edn_multiple[form_shortcode]['+count+']" value="'+edn_form_shortcode+'">'+
                        '</li>';
                    
                    $('.edn-append-mcontent-prev').append(append_html);
                    $('.edn-button-count').val(count);
                    // $('.edn-text-content-wrap input[type="text"]').each(function () {
                    //     $(this).val('');
                    // });
                    // $('.edn-text-content-wrap a.wp-color-result').each(function () {
                    //     $(this).css('background-color','');
                    // });
                    
                    tinymce.init({selector:'textarea'});
                    tinymce.get(inputid).setContent('');
                    $('.edn-add-multiple-content').hide();
                }
        });

function randomstring(L) {
  var s = '';
  var randomchar = function() {
    var n = Math.floor(Math.random() * 62);
    if (n < 10) return n; //1-10
    if (n < 36) return String.fromCharCode(n + 55); //A-Z
    return String.fromCharCode(n + 61); //a-z
  }
  while (s.length < L) s += randomchar();
  return s;
}


        //sortable initialization
        $('.edn-append-mcontent-prev').sortable({
             containment: "parent" 
        });
        $('.edn-append-mcontent-prev').on('click', '.edn-delete-content', function () {
            if (confirm(edn_pro_script_variable.icon_delete_confirm))
            {
                //var content_counter = $('.edn-button-count').val();
//                content_counter--;
//                $('.edn-button-count').val(content_counter);
                var selector = $(this);
                $(this).closest('.edn-sortable-content').fadeOut(800, function () {
                    selector.closest('.edn-sortable-content').remove();
                });
                return false;
            }
        });
        $('.edn-append-mcontent-prev').on('click', '.edn-content-head', function (e) {
             var selector = $(this);
            var id = selector.attr('id');
            var id_array = id.split('_');
            if (selector.parent().find('.edn-arrow i').hasClass('dashicons-arrow-down'))
            {
             
                selector.parent().find('i.dashicons-arrow-down').removeClass('dashicons-arrow-down').addClass('dashicons-arrow-up');
                if (selector.next().find('.edn-show-slide-call-button').is(':checked')) {
                    $('.edn-sctat_'+id_array[1]).show();
                }else{
                    $('.edn-sctat_'+id_array[1]).hide();
                }

                if(selector.next().find('.edn-slide-call-action-type:checked').val()=='custom'){
                    $('.edn-slide-call-action-'+id_array[1]).hide();
                    $('.edn-custom-but-block-'+id_array[1]).show();

                }else if(selector.next().find('.edn-slide-call-action-type:checked').val()=='shortcode-popup'){
                    $('.edn-slide-call-action-'+id_array[1]).hide();
                    $('.edn-shortcode-popup-but-block-'+id_array[1]).show();
                   // alert('#edn-m-shortcode-button-block-'+id_array[1]);
                    $('#edn-m-shortcode-button-block-'+id_array[1]).show();
                }
                else {
                    $('.edn-slide-call-action-'+id_array[1]).hide();
                    $('.edn-contact-but-block-'+id_array[1]).show();
                }
                if(selector.next().find('.edn-slide-call-action-type:checked').val() !='shortcode_popup' && selector.next().find('.edn-slide-call-action-type:checked').val() !='custom'){
                    if(selector.next().find('.edn-slide-contact-choose:checked').val()=='c-form'){
                        $('.edn-slide-cotnact-from-'+id_array[1]).hide();
                        $('.edn-slide-cc-form-'+id_array[1]).show();
                    }else{
                        $('.edn-slide-cotnact-from-'+id_array[1]).hide();
                        $('.edn-slide-cf7-'+id_array[1]).show();
                    }
                }
            }
            else
            {
                selector.parent().find('i.dashicons-arrow-up').removeClass('dashicons-arrow-up').addClass('dashicons-arrow-down');
                $('.edn-sctat_'+id_array[1]).hide();
            }
            selector.closest('.edn-sortable-content').find('.edn-multiple-slide-down').slideToggle(500);
            
        });
        
        //Choose Subscribe From
        $('input[name="edn_subs_choose"]').click(function(){
            var val = $(this).val();
            if(val=='subs-c-form'){
                $('.edn-subs-from').hide();
                $('#edn-subs-custom-form').show();
            }else if(val=='mailchip'){
                $('.edn-subs-from').hide();
                $('#edn-subs-mailchip-form').show();
            }
            else if(val=='constant-contact'){
                $('.edn-subs-from').hide();
                $('#edn-subs-constant-contact-form').show();
            }
        });
        if($('input[name="edn_subs_choose"]:checked').val()=='subs-c-form'){
            $('.edn-subs-from').hide();
            $('#edn-subs-custom-form').show();
        }else if($('input[name="edn_subs_choose"]:checked').val()=='mailchip'){
            $('.edn-subs-from').hide();
            $('#edn-subs-mailchip-form').show();
        }else if($('input[name="edn_subs_choose"]:checked').val()=='aweber-newsletter'){
            $('.edn-subs-from').hide();
            $('#edn-subs-aweber-form').show();
        }
        else if($('input[name="edn_subs_choose"]:checked').val()=='constant-contact'){
            $('.edn-subs-from').hide();
            $('#edn-subs-constant-contact-form').show();
        }

     //reset button for show only once
        $('#edn_reset_button').click(function(){
              $.ajax({
                url: edn_pro_script_variable.ajax_url,
                type: 'post',
                dataType: 'html',
                data: {
                    action:'ajax_reset_showonce_backend',
                    nonce: edn_pro_script_variable.ajax_nonce,
                },
                beforeSend: function() {
                    $('.edn-ajax-loader').show('slow');
                },
                complete: function() {
                    $('.edn-ajax-loader').hide('slow');
                },
                success: function( resp ) {
                    if(resp=="success"){
                       $('#edn-reset-message').html('Flag Reset Successfully.').delay(2000).fadeOut();
                    }else{
                       $('#edn-reset-message').html(resp).delay(2000).fadeOut();
                    }
                }
            });
        });
        
        //Choose Notification Bar Effects
            $('input[name="edn_bar_effect_option"]').click(function(){
                var val = $(this).val();
                if(val=='1'){
                    $('.edn-bar-efect-block').hide();
                    $('#edn-bar-ticker').show();
                }else if(val=='2'){
                    $('.edn-bar-efect-block').hide();
                    $('#edn-bar-slider').show();
                }else if(val=='3'){
                    $('.edn-bar-efect-block').hide();
                    $('#edn-bar-scroll').show();
                }
            });
            if($('input[name="edn_bar_effect_option"]:checked').val()=='1'){
                $('.edn-bar-efect-block').hide();
                $('#edn-bar-ticker').show();
            }else if($('input[name="edn_bar_effect_option"]:checked').val()=='2'){
                $('.edn-bar-efect-block').hide();
                $('#edn-bar-slider').show();
            }else{
                $('.edn-bar-efect-block').hide();
                $('#edn-bar-scroll').show();
            }
      
        
        // Slide Multiple Call to action button
            $('.edn-show-slide-call-button').change(function () {
                var id = this.id;
                var id_array = id.split('_');
                if ($(this).is(':checked')) {
                    $('.edn-sctat_'+id_array[1]).show();
                }else{
                    $('.edn-sctat_'+id_array[1]).hide();
                }
            });
        
        //edit slide down call to action type for multiple
            $('.edn-slide-call-action-type').click(function(){
                var id = this.id;
                var id_array = id.split('_');
                var val = $(this).val();
                if(val=='custom'){
                    $('.edn-slide-call-action-'+id_array[1]).hide();
                    $('.edn-custom-but-block-'+id_array[1]).show();
                }else if(val=='contact'){
                    $('.edn-slide-call-action-'+id_array[1]).hide();
                    $('.edn-contact-but-block-'+id_array[1]).show();
                }else if(val=='shortcode-popup'){
                    $('.edn-slide-call-action-'+id_array[1]).hide();
                    $('.edn-shortcode-popup-but-block-'+id_array[1]).show();
                    $('#edn-m-shortcode-button-block-'+id_array[1]).show();
                }



            });
        
        //slide Contact From for multiple
            $('.edn-slide-contact-choose').click(function(){
                var id = this.id;
                var id_array = id.split('_');
                var val = $(this).val();
                if(val=='c-form'){
                    $('.edn-slide-cotnact-from-'+id_array[1]).hide();
                    $('.edn-slide-cc-form-'+id_array[1]).show();
                }else if(val=='form-7'){
                    $('.edn-slide-cotnact-from-'+id_array[1]).hide();
                    $('.edn-slide-cf7-'+id_array[1]).show();
                }
            });

     /* Demo font style change */

         $('.edn-color-picker').wpColorPicker();

        //color picker
        var myOptions = {
            palettes: true,
            change: function(event, ui){
                $('#edn-label-font-text').css('background-color',ui.color.toString());
               //alert(ui.color.toString());
              }, 
            
            };
       
     $('#edn_bg_color').wpColorPicker(myOptions);//background color of notification bar
     $('#edn-social-heading-text-color').wpColorPicker();//background color of notification bar

       //color picker
        var myOptions2 = {
            palettes: true,
            change: function(event, ui){
                $('#edn-label-font-text').css('color',ui.color.toString());
               //alert(ui.color.toString());
              }, 
            
            };
       
       $('#edn_font_color').wpColorPicker(myOptions2);//background color of notification bar


        var fontfamily = $( ".ednfont option:selected" ).text();
        var fontsize = $( "#ednsize option:selected" ).text();
        var bgcolor = $( "#edn_bg_color" ).val();
        var fontcolor = $( "#edn_font_color" ).val();
        //button 
        var btn_bg_color = $( "#cf_bg_color" ).val();
        var btn_font_color = $( "#cf_font_color" ).val();
        var btn_bghover_color = $( "#cf_hover_bg_color" ).val();
        var btn_fonthover_color = $( "#cf_hover_font_color" ).val();

       //button color picker
        var myOptions3 = {
            palettes: true,
            change: function(event, ui){
              ft_color = ui.color.toString();
                $('#edn-label-font-text .btn_preview').css('color',ui.color.toString());
               //alert(ui.color.toString());
              }, 
            
            };  
             var myOptions4 = {
            palettes: true,
            change: function(event, ui){
                bg_color = ui.color.toString();
                $('#edn-label-font-text .btn_preview').css('background-color',ui.color.toString());
               //alert(ui.color.toString());
              }, 
            
            };

          var myOptions5 = {
            palettes: true,
            change: function(event, ui){
                 $('#edn-label-font-text .btn_preview').on('mouseenter',function(){
                     var hover_element = $(this).attr('class');
                     $('#edn-label-font-text .btn_preview:hover').css('background-color',ui.color.toString());
                 });
                 $('#edn-label-font-text .btn_preview').on('mouseleave',function(){
                     var hover_element = $(this).attr('class');
                     $('#edn-label-font-text .btn_preview').css('background-color',bg_color);
                 });
              }, 
            
            }; 


               $("#edn-label-font-text .btn_preview").hover(function(){
                    $(this).css("background-color",btn_bghover_color);
                    $(this).css("color",btn_fonthover_color);
                    }, function(){
                    $(this).css("background-color",btn_bg_color);
                    $(this).css("color",btn_font_color);
              });

           var myOptions6  = {
            palettes: true,
            change: function(event, ui){
              $('#edn-label-font-text .btn_preview').on('mouseenter',function(){
                     var hover_element = $(this).attr('class');
                     $('#edn-label-font-text .btn_preview:hover').css('color',ui.color.toString());
                 });
                 $('#edn-label-font-text .btn_preview').on('mouseleave',function(){
                     var hover_element = $(this).attr('class');
                     $('#edn-label-font-text .btn_preview').css('color',ft_color);
                 });
              }, 
            };       
   $('#cf_font_color').wpColorPicker(myOptions3);//background color of notification bar
   $('#cf_bg_color').wpColorPicker(myOptions4);//background color of notification bar
   $('#cf_hover_bg_color').wpColorPicker(myOptions5);//background color of notification bar
   $('#cf_hover_font_color').wpColorPicker(myOptions6);//background color of notification bar

       //google font switching
        $('.ednfont').change(function () {
            var label_font = $(this).val();
            var font_size = $( "#ednsize option:selected" ).text();
            $("#edn-label-font-style").html('');
            $("#edn-label-font-style").html('#edn-label-font-text {font-size: ' + font_size + 'px;font-family: "' + label_font + '" !important; }');      
            if(label_font != "Default" && label_font != ''){
            WebFont.load({
                google: {
                    families: [label_font]
                }
            });
            } 
        });


        $("#edn-label-font-text .btn_preview").hover(function(){
           $(this).css("background-color",btn_bghover_color);
            $(this).css("color",btn_fonthover_color);
            }, function(){
            $(this).css("background-color",btn_bg_color);
            $(this).css("color",btn_font_color);
      });


         $("#edn-label-font-style").html('#edn-label-font-text {font-size: ' + fontsize + 'px;font-family: "' + fontfamily + '"; }');      
         if(bgcolor == ''){
          bgcolor = "#fff";
        }
        $('#edn-label-font-text').css('background-color',bgcolor);
        if(fontcolor == ''){
          fontcolor = "#000";
        }

        $('#edn-label-font-text').css('color',fontcolor);
        $('#edn-label-font-text .btn_preview').css('background-color',btn_bg_color);
        $('#edn-label-font-text .btn_preview').css('border',btn_bg_color);
        $('#edn-label-font-text .btn_preview').css('color',btn_font_color);
        //$('#edn-label-font-text .btn_preview:hover').css('background-color',btn_bghover_color);
       // $('#edn-label-font-text .btn_preview:hover').css('color',btn_fonthover_color);
         if(fontfamily != "Default" && fontfamily != ''){
         WebFont.load({
                google: {
                    families: [fontfamily]
                }
            });
         }

        
        $("#ednsize").change(function(){
            var family = $( ".ednfont option:selected" ).text();
            var size = $(this).val();
            $("#edn-label-font-style").html('#edn-label-font-text {font-size: ' + size + 'px;font-family: "' + family + '"; } }');      
        });

     /* Subscriber check all */
        $('#ednpro-subs-checkall').change(function() {
            if ($(this).prop('checked')) {
                $(".edn-select-all-subs").prop( "checked", true );
            }
            else {
                $(".edn-select-all-subs").prop( "checked", false );
            }
        });//check all end

     

    /* added code for subscribe form confimration name and email */
       /* custom form */
           if($("#custom_confirm").is(':checked')){
              $('#edn-subs-confirm-fields').show();
            } else {
              $('#edn-subs-confirm-fields').hide();     
            }
             if($("#mailchimp_confirm").is(':checked')){
              $('#edn-subs-mailchimp-confirm').show();
            } else {
              $('#edn-subs-mailchimp-confirm').hide();     
            }
             if($("#cc_confirm").is(':checked')){
              $('#edn-subs-cc-confirm').show();
            } else {
              $('#edn-subs-cc-confirm').hide();     
            }
       
         $('.edn_subs_confirm').on('click',function () {
            var subsid = $(this).attr('id');
          if(subsid == "custom_confirm"){
            if ($(this).is(':checked')) {
                $('#edn-subs-confirm-fields').show('slow');
            } else {
               $('#edn-subs-confirm-fields').hide('slow');     
            }
        }else if(subsid == "mailchimp_confirm"){
            if ($(this).is(':checked')) {
                $('.edn-subs-mailchimp-confirm').show('slow');
            } else {
               $('.edn-subs-mailchimp-confirm').hide('slow');     
            }
        }else{
              if ($(this).is(':checked')) {
                $('.edn-subs-cc-confirm').show('slow');
            } else {
               $('.edn-subs-cc-confirm').hide('slow');     
            }
        }
        
        });







              
  
      $('#edn-positions').change(function(){
         var position = $(this).val();
          $('.edn-position-preview').hide();
            $('#edn-positon-'+position).show();
            var upperposition = position.toUpperCase().replace('_',' ');
            $('#edn-positon-'+position+' .edn-backend-inner-title').html('Notification Bar Position Preview: '+upperposition);
       });

       var current_position = $( "#edn-positions option:selected" ).val();
       if(current_position != ''){
            $('#edn-positon-'+current_position).show();
       }


        //test mail using ajax
       /* $('#edn-test_mail').click(function(){
       
            var mail_to = $('input[name="edn_test_mail_to"]').val();
            var mail_subject = $('input[name="edn_test_mail_subject"]').val();
            var mail_message = $('textarea[name="edn_test_mail_message"]').val();

            if(mail_to == ''){
                alert('Please fill to email field.');
            }else{
            $.ajax({
                url: edn_pro_script_variable.ajax_url,
                type: 'post',
                dataType: 'html',
                data: {
                    action:'test_smtp',
                    mail_to: mail_to,
                    mail_subject: mail_subject,
                    mail_message: mail_message
                },
                beforeSend: function() {
                    $('.edn-ajax-loader').show('slow');
                },
                complete: function() {
                    $('.edn-ajax-loader').hide('slow');
                },
                success: function( resp ) {
                    alert(resp);
                    $('.edn_testmessage').css('display','block');
                   $('.edn_testmessage').html(resp);
                }
            });
            }
        }); */


     /* 
     * Added features :version 1.0.10
     * Open Panel Section 
     */

       /* enable open panel*/
        $('#edn-open-panel').change(function () {
            if ($(this).is(':checked')) {
                $('.edn-open-panel-wrap').slideDown();          
            }else{
                $('.edn-open-panel-wrap').slideUp();
            }
        });

        if ($('#edn-open-panel').is(':checked')) {
                 $('.edn-open-panel-wrap').slideDown();          
            }else{
                $('.edn-open-panel-wrap').slideUp();
            }

           //add widgets popup chooser
            $('.edn_add_widgets').click(function () {
                $('.edn-addwidgets').show();
            });
            
            $('.edn-close-widgets,.edn-lightbox').click(function () {
                $('.edn-addwidgets').hide();
            });

      //var clicks = 0;
     
      $('.all_wp_widgets').each(function() {
                $(this).click(function(){
                  //  clicks += 1;
                    var count = $('.listed_selected_widgets > div.ednpro_widget_area').length;
            
                    var widget_id =$(this).attr('data-value');
                    var widget_title =$(this).attr('data-text');   
                      
                            if(count == 3){
                             alert(selected_widget_limits);
                            }else{     
                            
                                var widgets = {
                                        action: "add_selected_widget",
                                        widget_id: widget_id,
                                        title: widget_title,
                                        nonce : admin_nonce
                                    };

                                    $.post(AjaxUrl, widgets, function (response) {
                                         var widget = $(response.data); //display widgets by json
                                         $('.edn_listed_widgets').show();
                                         $('.listed_selected_widgets').append(widget);

                                          add_events_widget(widget);
                                    });
                            }


                    });

           });

     //editing widget data
     var widget_area = $('.edn_listed_widgets').find('.listed_selected_widgets');
       $('.ednpro_widget_area', widget_area).each(function() {
             add_events_widget($(this));
      });


     function add_events_widget(widget) {
           
            var widget_title = widget.find(".widget_title span.wptitle");
            var widget_edit = widget.find(".widget-action");
            var widget_inner = widget.find(".widget_inner");
            var widget_id = widget.attr("data-id");

              widget_edit.on('click',function(){
          
                    if (! widget.hasClass("ednpro_open") && ! widget.data("ednpro_loaded")) {
                    widget_title.addClass('ednpro_loading');

                    // retrieve the widget settings form
                    $.post(AjaxUrl, {
                        action: "edit_widget_data",
                        widget_id: widget_id,
                        _wpnonce: admin_nonce,
                        dataType : 'html'
                    }, function (response) {

                        var $response = $(response);
                        var $form = $response.find('form');

                        // bind delete button action
                        $(".ednpro_delete", $form).on("click", function (e) {
                            e.preventDefault();
                            
                            var data = {
                                action: "ednpro_delete_widget",
                                widget_id: widget_id,
                                _wpnonce: admin_nonce
                            };

                            $.post(AjaxUrl, data, function (delete_response) {
                                widget.remove();
                              
                            });

                        });

                        // bind close button action
                        $(".ednpro_close", $form).on("click", function (e) {
                            e.preventDefault();
                            widget.toggleClass("ednpro_open");
                        });

                        // bind save button action
                        $form.on("submit", function (e) {
                            e.preventDefault();
                            var dataa = $(this).serialize();
                             $('.ednpro_save_data').show();
                             $('.saving_msg').text(saving_data);
                            $.post(AjaxUrl, dataa, function (submit_response) {    
                                $('.ednpro_save_data').fadeOut('slow');
                            });

                        });

                        widget_inner.html($response);

                        widget.data("ednpro_loaded", true).toggleClass("ednpro_open");

                        widget_title.removeClass('ednpro_loading');

                    });

                } else {
                 
                    widget.toggleClass("ednpro_open");
                }

                // close all other widgets
                $(".ednpro_widget_area").not(widget).removeClass("ednpro_open");
                    
              }); 
                 return widget;
        }

      $('.listed_selected_widgets').sortable({
            containment: "parent"
       });

      /*
      * APEX COuntdown JS
      */

      $('.apex_countlayout').change(function(){
       var val  = $(this).val();
       $('.preview-counter').css('display','block');
       $('.preview_image').css('display','none');
       $('#counter_'+val).css('display','block');
      });

      var countlayout = $('.apex_countlayout option:selected').val();
       $('.preview-counter').css('display','block');
       $('.preview_image').css('display','none');
       $('#counter_'+countlayout).css('display','block');



    if (!document.getElementById("apexnb_uploadBtn")) {
    //It does not exist
    }else{
      document.getElementById("apexnb_uploadBtn").onchange = function () {
         var val = this.value;
         var pathArray = val.split('\\');
         document.getElementById("apexnb_uploadFile").value = pathArray[pathArray.length - 1];


      };
    }


      $('.apexnb-file-type').css('display','none');
          $('#apexnb-choose-file-type').change(function(){
           var filetype  = $(this).val();
           if(filetype == "upload_demofile"){
             $('.apexnb-demofile').css('display','block');
             $('.apexnb-uploadfile').css('display','none');
           }else if(filetype == "upload_customfile"){
            $('.apexnb-demofile').css('display','none');
             $('.apexnb-uploadfile').css('display','block');
             $(".apexnb-file-type1,.apexnb-file-type2").css('display','none');
           }else{
              $('.apexnb-demofile,.apexnb-uploadfile').css('display','none');
              $(".apexnb-file-type1,.apexnb-file-type2").css('display','none');
          }
        });

       
        $('.toggledDropDown').hide();


  var apexnb_ajax_url   = edn_pro_script_variable.ajaxurl;
  var apexnb_ajax_nonce = edn_pro_script_variable.ajaxnonce ;
$(".apexnb-file-type1,.apexnb-file-type2").css('display','none');
 $('#apexnb-first-choice').change(function(){
  var choice_demo = $(this).val();
   var options = '';
          $.ajax({
                    url: apexnb_ajax_url,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action:'get_demo_files',
                        first_choice :choice_demo,
                        nonce: apexnb_ajax_nonce,
                    },
                    beforeSend: function() {
                        $('.edn-ajax-loader').show('slow');
                    },
                    complete: function() {
                       $('.edn-ajax-loader').hide('slow');
                    },
                    success: function(resp) {
                    // console.log(resp);
                     $(".apexnb-file-type1").css('display','block');
                      options += '<option value="">Choose File</option>';
                     for (var i = 0; i < resp.length - 2; i++) {
                     
                         var newValue =  resp[i].replace(/-/g, " ");
                         var myString = newValue.substr(0,1).toUpperCase() + newValue.substr(1);
                         options += '<option value="' + resp[i] + '">' + myString  + '</option>';
                      }
                      
                      $("#apexnb-second-choice").html(options);

                        
                    }
                });
  
});

 $('#apexnb-second-choice').change(function(){
  var second_choice = $(this).val();
  var first_choice = $('#apexnb-first-choice option:selected').val();
   var options = '';
          $.ajax({
                    url: apexnb_ajax_url,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action:'get_demo_filess',
                        first_choice :first_choice,
                        second_choice :second_choice,
                        nonce: apexnb_ajax_nonce,
                    },
                    beforeSend: function() {
                        $('.edn-ajax-loader').show('slow');
                    },
                    complete: function() {
                       $('.edn-ajax-loader').hide('slow');
                    },
                    success: function(resp) {
                    // console.log(resp);
                    $(".apexnb-file-type2").css('display','block');
                     for (var i = 0; i < resp.length - 2; i++) {
                     
                       var newValue = resp[i].replace(/-/g, " ");
                            newValue = newValue.replace('.json', '');
                        var newValue2 = resp[i].replace('.json', '');
                         var myString = newValue.substr(0,1).toUpperCase() + newValue.substr(1);
                        options += '<option value="' +  resp[i] + '">' + myString + '</option>';
                      }
                     
                      $("#apexnb-third-choice").html(options);

                        
                    }
                });
  
});

        
   	});//$(function () end
}(jQuery));