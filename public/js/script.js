$(document).ready(function () {


    // $(document).on('click', '.nav-item',function (e) {
    //     $('.nav-item').removeClass("active");      
    //     $(this).addClass("active");
    //     $('.submit_property').removeClass("active");
    //     $('.signin_tab').removeClass("active");
    // });


    if ((screen.width <= 768)) {
        $('.rm_div').removeClass('col-sm-3');
        $('.rm_div').addClass('col-sm-4');
    }

    if ((screen.width <= 576)) {
        $('.col-sm-4').removeClass('p-0').removeClass('pr-0').removeClass('pl-0').removeClass('pr-3').removeClass('pl-3');
        $('.col-sm-3').removeClass('p-0').removeClass('pr-0').removeClass('pl-0').removeClass('pr-3').removeClass('pl-3');
        $('.col-sm-6').removeClass('p-0').removeClass('pr-0').removeClass('pl-0').removeClass('pr-3').removeClass('pl-3');
        $('.col-sm-8').removeClass('p-0').removeClass('pr-0').removeClass('pl-0').removeClass('pr-3').removeClass('pl-3');
        $('.col-sm-9').removeClass('pl-4').removeClass('px-4');
        $('.row').removeClass('p-0').removeClass('m-0').removeClass('mx-0');
        $('.user_icon').attr("src", "../images/user_white_small.png");
        $('.tp-reg-check').removeClass('form-check-inline');
    }


    $("#discoverProperties").click(function () {
        $('html, body').animate({
            scrollTop: $("#discover_properties_scroll_section").offset().top
        }, 900);
        $("#discover_properties_scroll_section").css('margin-top', '100px');

        setTimeout(function () {
            $("#discover_properties_scroll_section").css('margin-top', '0px').css('transition', 'all 1s ease-in-out');
        }, 10000);
    });


    $('.form-group').click(function (e) {
        if ($(this).hasClass('prop_div')) {
            $('.form_small_ph').hide();
        } else {
            $('.form_small_ph').show();
        }
    });


    $('.property_nav_hide').click(() => {
        $('#paymentModal').modal('show');
    });

    $(window).scroll(function () {

        if ($(window).scrollTop() >= 100) {
            $('#tanahPro_header').addClass('header-fixed-top');
        }
        else {
            $('#tanahPro_header').removeClass('header-fixed-top');
        }

        if ($(this).scrollTop() > 300) {
            $('#popural_property_section').addClass('slide-left');
        }

        if ($(this).scrollTop() > 600) {
            $('#property_listing_section').addClass('slide-right');
        }

        if ($(this).scrollTop() > 900) {
            $('#property_added_section').addClass('slide-left');
        }

        if ($(this).scrollTop() > 1500) {
            $('#testimony_section').addClass('slide-right');
        }

        if ($(this).scrollTop() > 1200) {
            $('#story_section').addClass('slide-left');
        }


    });




  


    // var propStepper = new Stepper($('#prop_submit_stepper')[0])
    // $('.prev_tab_btn').click(() => {
    //     propStepper.previous();
    // });
    // $('.form_step_next').click(() => {
    //     propStepper.next();
    // });


    // $(document).on('click', '.submit_options', function (e) {
    //     $('.submit_options').removeClass("active");
    //     $(this).addClass("active");
    // });


    
});







