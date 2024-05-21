/*!
Plugin: Mailchimp Sign-up JS
Version: 1.0.1
*/

(function( root, $, undefined ) {
    "use strict";

    $(function () {
        $.blockUI.defaults.css = {
            background:'none'
        };
        $.blockUI.defaults.overlayCSS = {
            background:'white',
            opacity: 0.5
        };
        $('form.mailchimp-signup').each(function(){
            var form = $(this);
            var submit = $(this).find('input[type=submit]');
            submit.unbind();
            submit.click(function(e){
                e.preventDefault();
                e.stopPropagation();
                form.block();

                if(isValidEmailAddress(getValueFromForm(form,'mailchimp_email'))){
                    jQuery.post(
                        form.attr('action'),
                        {
                            action: 'handle_mailchimp_ajax',
                            mailchimp_email:getValueFromForm(form,'mailchimp_email'),
                            mailchimp_fname:getValueFromForm(form,'mailchimp_fname'),
                            mailchimp_lname:getValueFromForm(form,'mailchimp_lname'),
                            ajax:true
                        },function(data,textStatus){
                            form.unblock();
                            var result = $.parseJSON(data);
                            var isSuccess = (result.code == undefined);
                            if(isSuccess){
                                form.find('input').not('[type=hidden]').not('[type=submit]').val('');
                                showSuccess(form,isSuccess);
                            }else {
                                showSuccess(form,isSuccess,result.error);
                            }

                        }
                    )
                }else {
                    form.unblock();
                    showSuccess(form,false,form.data('email_incorrect'));
                }

            })
        });
    });

    function getValueFromForm(form,inputID){
        var input = form.find('#'+inputID);
        if(input != undefined){
            return input.val();
        }else {
            return "";
        }
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }

    function showSuccess(form,isSuccessful, message){
        var result = form.find('#result');
        if(isSuccessful){
            result.attr('class','').addClass("success");
            if(message == undefined){
                message = form.data('positive');
            }
        }else {
            result.attr('class','').addClass("failed");
            if(message == undefined) {
                message = form.data('negative');
            }
        }

        result.html(message);

        result.slideDown(400,function(){

            clearTimeout(window.mailchimp_result_timeout);

            window.mailchimp_result_timeout = setTimeout(function(){
                result.slideUp(400);
            },10000)
        });
    }

} ( this, jQuery ));