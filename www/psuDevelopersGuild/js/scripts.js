$(document).ready(function() {
    (function() {
        [].slice.call(document.querySelectorAll('.tabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
    $('#main-nav').sidr();
    $('#fullpage').fullpage({
        'verticalCentered': true,
        'easing': 'easeInOutCirc',
        'css3': false,
        'scrollingSpeed': 900,
        'slidesNavigation': true,
        'slidesNavPosition': 'bottom',
        'easingcss3': 'ease',
        'navigation': true, 
        'anchors': ['Home', 'Register'],
        'navigationPosition': 'left'
    });
    $('.screenshots-content, .clients-content').css('height', $(window).height());
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('body').addClass('browser-mobile');
    }
    $(document).mouseup(function(e) {
        if ($(".sidr-open ")[0]) {
            var container = $("#sidr");
            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                $(".sidr-open #main-nav").click();
            }
        }

    });
    
    $("#display_form .wrap").height($(window).height()).perfectScrollbar({
        suppressScrollX: true,
        wheelPropagation:true
    });

    $("#form_registration").validate({
        rules: {
            field_name: {required: true,maxlength: 200},
            field_email: {required: true,maxlength: 100,email:true},
            field_phone: {required: true,maxlength: 20},
            field_skill: {required: true,maxlength: 20},
            field_address: {required: true,maxlength: 20},
            field_dream: {required: true,maxlength: 1000},
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if(placement){
                $(placement).append(error)
            } 
            else{
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            var _form = $(form).serializeArray();
            var data = system.ajax('harmony/Process.php?set-leads',_form);
            data.done(function(data){
                console.log(data);
                if(data == 1){
                    Materialize.toast('Thank you. Your account has been saved. Kindly check your email for confirmation.',2000);
                    system.clearForm();
                    setTimeout(function(){
                        window.location.reload(true);
                    },2000);
                }
                else{
                    Materialize.toast('Cannot process request.',4000);
                }
            });
        }
    });
    // $("#display_form").height("400px").perfectScrollbar({
    //     suppressScrollX: true,
    //     wheelPropagation:true
    // });

});
jQuery(window).load(function() {
    jQuery('#preloader').fadeOut();
});
