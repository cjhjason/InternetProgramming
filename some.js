jQuery(document).ready(function($) {

    //  Slide down error message, if exists
    $('.idp3_error').slideDown(250);
    setTimeout(function() {
        $('.idp3_error').addClass('idp3_error-show');
    }, 250);

    //  Sets focus on Internet ID <input> on page load
    if($(window).width() >= 768 && $(window).height() >= 640) {
        $('#username').focus();
    }

    //  Add bottom padding to <main> to accommodate for sticky <footer>
    $('main').css('padding-bottom', $('.umn_footer').outerHeight() + 60 + 'px');

    //  Toggles help options in footer of page
    $('#umn_footer-help-toggle').click(function() {
        $(this).toggleClass('active');
        if($(this).hasClass('active')) {
            $('.fa', this).removeClass('fa-eye').addClass('fa-eye-slash');
            $('.umn_footer-help-text', this).text('Hide Help Options');
        } else {
            $('.fa', this).removeClass('fa-eye-slash').addClass('fa-eye');
            $('.umn_footer-help-text', this).text('Show Help Options');
        }
    });

    //  Scrollable UI enhancements
    if($('body').height() > $(window).height()) {
        $('.umn_footer').addClass('shadow');
    }
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() === $(document).height()) {
            $('.umn_footer').removeClass('shadow');
            if($('.umn_footer-content').is(':hidden')) {
                $('.umn_footer-content').slideDown(250);
            }
        } else {
            $('.umn_footer').addClass('shadow');
            if($(window).width() < 768 && $('.umn_footer-content').is(':visible')) {
                $('.umn_footer-content').slideUp(250);
            } else if($(window).width() >= 768 && $('.umn_footer-content').is(':hidden')) {
                $('.umn_footer-content').slideDown(250);
            }
        }
    });

    //  Hides footer on <input> focus for small form factor devices
    $('.idp3_form input').focusin(function() {
        if(( $(window).width() < 768 && $('.umn_footer').is(':visible') ) || ( $(window).height() < 640 && $('.umn_footer').is(':visible') )) {
            $('.umn_footer').slideUp(250);
        }
    });
    $('.idp3_form input').focusout(function() {
        if($(window).width() < 768 || $(window).height() < 640) {
            setTimeout(function() {
                if($('.umn_footer').is(':hidden') && !$(':focus').is('input')) {
                    $('.umn_footer').slideDown(250);
                }
            }, 250);
        }
    });

});
