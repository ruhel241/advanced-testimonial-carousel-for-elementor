jQuery(document).ready(function($) {
    var $successMessage = $("#atc-notice-success");
    var $errorMessage   = $("#atc-notice-error");
    
    $successMessage.on('click', function() {
        $(this).hide();
    });

    $errorMessage.on('click', function() {
        $(this).hide();
    });
 
   var atcAddons  =  $("#atc-addons-tab");
   var atcLicense =  $("#atc-license-tab");

    atcAddons.on('click', function() {
        $('.atc-addons-wrapper').show();
        $('.atc_license_box').hide();
    })

    atcLicense.on('click', function() {
        $('.atc-addons-wrapper').hide();
        $('.atc_license_box').show();
    })
    
    var atcAdminSettings = {
        getStatusLicense: function() {
            jQuery.post(atcProVar.ajaxurl, {
                action: 'atc_pro_lincese_ajax_actions', 
                route: 'get_license_status',
                nonce: atcProVar.nonce
            })
                .then(function(response) {
                    if ( response.data.license_data.status === 'valid' ) {
                        $( "#atc_activated_license" ).hide()
                        $( "#atc_deactivated_license" ).show();
                    } else {
                        $( "#atc_activated_license" ).show()
                        $( "#atc_deactivated_license" ).hide();
                    }
                })
                .fail(function(error) {
                    console.log('Something is wrong! Please try again');
                })
                .always(function() {
                    $("#atcbooster-loading").hide();
                });
        },

        verifyLicense: function() {
            $('#atc_verify_btn').on('click', function(e) {
				$("#atcbooster-loading").show();
                $('#atc_activated_license').hide();
                $("#atc_deactivated_license").hide();
                e.preventDefault();
                
                jQuery.post(atcProVar.ajaxurl, {
                    action: 'atc_pro_lincese_ajax_actions',
                    route: 'activate_license', 
                    license_key: jQuery('#atc_license_settings_field').val(),
                    nonce: atcProVar.nonce
                })
                    .then(function(response) {
                        if (response.success == true) {
                            $("#atcbooster-loading").hide();
                            $('#atc_activated_license').hide();
                            $("#atc_deactivated_license").show();
                            $successMessage.show();
                            $successMessage.find('p').html(response.data.message);
                            $(".atcbooster_activate_message").hide();
                        } else {
							$("#atcbooster-loading").hide();
							$('#atc_activated_license').show();
							$("#atc_deactivated_license").hide();
                            $errorMessage.show();
                            $errorMessage.find('p').html(response.data.message);
                        }
                    })
                    .fail(function(error) {
                        $("#atcbooster-loading").hide();
                        $("#atc_activated_license").show();
                        $("#atc_deactivated_license").hide();
                        $errorMessage.show();
                        $errorMessage.find('p').html('Something is wrong! Please try again');
                    })
                    .always(function() {
                    });
            })
        },

        deactiveLicense: function() {
            $('#atc_deactive_license').on('click', function(e) {
                $("#atcbooster-loading").show();
                $("#atc_deactivated_license").hide();

                e.preventDefault();
                jQuery.post(atcProVar.ajaxurl, {
                    action: 'atc_pro_lincese_ajax_actions', 
                    route: 'deactivated_license',
                    nonce: atcProVar.nonce
                })
                    .then(function(response) {
                        $("#atcbooster-loading").hide();
                        $("#atc_activated_license").show();
                        $("#atc_deactivated_license").hide();
                        $successMessage.show();
                        $successMessage.find('p').html(response.data.message);
                    })
                    .fail(function(error) {
                        $errorMessage.show();
                        $errorMessage.find('p').html('Something is wrong! Please try again');
                    })
                    .always(function() {
                    });
            })
        },
        // Active Plugin 
        installHandler: function() {
            $('.atc-install-addon').on('click', function(e) {
                e.preventDefault();
                jQuery.post(atcProVar.ajaxurl, {
                    action: 'atc_pro_setup_addons', 
                    route: $(this).attr('value'),
                    nonce: atcProVar.nonce
                })
                    .then(function(response) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000); 
                        $successMessage.show();
                        $successMessage.find('p').html(response.data.message);
                    })
                    .fail(function(error) {
                        $errorMessage.show();
                        $errorMessage.find('p').html('Something is wrong! Please try again');
                    })
                    .always(function() {
                    });
            })
        },

        init: function(){
            if (!!atcProVar.has_pro) {
                this.getStatusLicense();
                this.verifyLicense();
                this.deactiveLicense();
            }
            this.installHandler();
        }
    } 
    atcAdminSettings.init();
});