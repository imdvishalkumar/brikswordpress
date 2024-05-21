(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

        symbolList();
        colorBox(); //CALL TO VIDEO EMBED
        masonrySet(); //MASONRY CALL
        resizeYoutubeVideos(); //RESIZE VIDEO IFRAMES
        formSelect(); //CHANGE VISIBILTY OF OTHER IN FORM
        onebrickFormSelect();
        faqPage();
        sidebarButtons();
        chat();
        liveChat();
        footerLock();
        lazyLoad();
        priceDisplay();
        freesample();
        stickyHeader();
        phoneTab();
        slider();
        sampleForm();


        if($('.menubutton').size() > 0) {
            $('.menubutton').click(function () {
                $("html").toggleClass("navisopen");
            });
        }

        if($('html').hasClass('no-svg')){
            $('img').each(function(){
                $(this).attr("src",$(this).attr('src').replace('svg','png'));
            })
        }


		
	});

    $(window).resize(function() {

        resizeYoutubeVideos();
        liveChat();
        footerLock();
        colorBox();

    });

    $(window).load(function(){
        footerLock();
        validateForms();
    });

    $(window).scroll(function(){
        liveChat();
        stickyHeader();
    });
    function phoneTab(){
        if($('.custom-form-fields-register').size() > 0){
            $('input#PhoneNumber1,input#PhoneNumber2').on('keyup',function(){
                if($(this).val().length >= $(this).attr('maxlength')) {
                    $(this).next('input').focus();
                }
            });
        }

    }

    function slider(){
        var slider = $('.home-page-slider');
        if(slider.size() > 0) {
            slider.slick({
                slide:'.slide',
                lazyLoad:'ondemand',
                autoplay:true,
                autoplaySpeed:5000,
                slidesToShow:1,
                adaptiveHeight:true,
                dots:false,
                arrows:true
            });
        }
    }

    function freesample(){

        if($('body').hasClass('page-template-page-landing')) {
            $('a.samplebrick').click(function () {
                var position = $('a#freesample').offset().top;
                $('html, body').animate({
                    scrollTop: position
                }, 500);
            });
        }

    }

    function stickyHeader(){

        var header = $('header.header'),
            phone = $('aside.phone'),
            fixheader = header.add(phone),
            offset = $(window).scrollTop();

        if(offset >= (fixheader.innerHeight()) && $(window).innerWidth() >= 768){
            $('header.s-header').addClass('fixed');
        } else {
            $('header.s-header').removeClass('fixed');
        }
    }

    function lazyLoad() {
        var lazyimage = $('.lazy');
        if(lazyimage.size() > 0){
            lazyimage.lazyload({
                effect:"fadeIn",
                skip_invisible:true
            });
        }
    }

    function priceDisplay(){
        var select = $('#BrickLines');
        if(select.size() > 0){
            select.on('change',function(){
                var price = $(this).find('option:selected').data('price');
                $('#donationamount').replaceWith('<span id="donationamount">$' + price + '</span>');
            });
        }
    }

    function chat(){
        if($('.popup-chat').size() > 0){
            $('.popup-chat').click(function(e){
                e.preventDefault();
                window.open('https://www.websitealive5.com/3637/rRouter.asp?groupid=3637&amp;websiteid=0&amp;departmentid=','guest', 'width=450,height=400');
            });
        }
    }

    function validateForms(){
        var form = $('.customform');
        if(form.size() > 0) {
            form.validate({
                ignore: '.ignore',
                rules: {
                    "hiddenRecaptcha": {
                        required: function () {
                            if ($('input.hiddenRecaptcha').attr('data-response') == '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            });
        }
    }

    function symbolList(){
        var symbolContainer = $('.symbol-list-container'),
            symbolTitle = $('.symbol-list-container h2'),
            symbols = $('.symbol-list-symbols');

        if(symbolContainer.length > 0 ){

            symbolTitle.add(symbolContainer).on('click', function(e){
                var title = $(this).closest('h2');

                if(e.target !== this)
                    return;

                title.next(symbols).add(title).toggleClass('visible');

                if(!$('html').hasClass('no-cssanimations')) {
                    $('html,body').animate({
                        scrollTop: $(this).offset().top - 20
                    }, 'fast');
                }

            });

        }
    }

    function liveChat(){
        if($('.live-chat').size() > 0 && $(window).innerWidth() >= 900){
            var chat = $('.live-chat');
            var chatPosition = chat.offset().top;
            var offsetPosition = $('body').height() - 250;
            if(chatPosition >= offsetPosition){
                chat.addClass('reposition');
            } else {
                chat.removeClass('reposition');
            }
        }
    }

    function colorBox(){
        if($('a.colorbox, a.sample-brick-form').length > 0)
        {
            $('a.colorbox.video').each(function () {
                var link = $(this);
                var width = 640;
                if($(window).innerWidth() <= 768) {
                    width = $(window).innerWidth() * .8;
                }
                link.colorbox({
                    html: '<iframe type="text/html" width="'+width+'" height="360" src="//www.youtube.com/embed/' + link.data('video') + '" frameborder="0" allowfullscreen></iframe>'
                })
            });

            $('a.colorbox.image').each(function () {
                var link = $(this);
                link.colorbox({rel: 'gal', maxWidth: '100%', maxHeight: '100%'});
            });

            var symbols = $('.symbol-list-symbols');
            if(symbols.length > 0){
                symbols.find('a.colorbox.image').each(function(){
                    var link = $(this);
                    link.colorbox({rel:link.attr('rel'), maxWidth: '100%', maxHeight: '100%',scrolling:false,fixed:true});
                });
            }

            $('a.sample-brick-form').colorbox({
                inline: true,
                href: $('#side'),
                maxWidth: '100%',
                maxHeight: '100%'
            });

            $(document).bind('cbox_open', function(){
                $('body').addClass('fixed');
                resizeYoutubeVideos();
            });

            $(document).bind('cbox_closed', function(){
               $('body').removeClass('fixed');
            });
        }
    }

    function resizeYoutubeVideos(){
        $("iframe").each(function(){
            var iframe = $(this);
            if(iframe.attr('src').indexOf("youtube.com")>= 0){
                iframe.css('width','100%').height(
                    iframe.width() / (iframe.attr('width')/iframe.attr('height'))
                );
            }
        })
    }

    function masonrySet(){
        if($('#masonry-container').size() > 0){
            var container = $('#masonry-container');
            container.masonry({
                itemSelector:'.box',
                gutter:0,
                isAnimated: true
            });
        }
    }

    function formSelect(){
        if($('form.wpcf7-form').size() > 0){
            var select = $('#requestselect');
            select.change(function(){
                if(select.val() == "Other"){
                    $('#otherrequest').addClass('selected');
                } else {
                    $('#otherrequest').removeClass('selected');
                }
            });
        }
    }

    function onebrickFormSelect(){
        if($('#brick-size').size() > 0){
            var select = $('#brick-size');
            select.change(function(){
                var choice = select.val();
                var amount = choice.split('$').pop().split(' ').shift();
                if(choice == "Select a Size") {
                    $('#donation-amount strong').replaceWith('<strong>Please select a brick size!</strong>');
                } else {
                    $('#donation-amount strong').replaceWith('<strong>$' + amount + '</strong>');
                }
            });
        }
    }

    function sampleForm(){
        if($('#sampleForm').size() > 0){
            var select = $('#BrickLines'),
                select_cert = $('#DonorCertificate'),
                select_brick = $('#DonorBrick'),
                donation = $('#donation-amount'),
                donation_amount = $('input#DonationAmount');
            select.on('change',function(){
                var choice = select.find('option:selected'),
                    amount = choice.data('price');
                if(amount >= 0) {
                    donation.html('<strong>$' + amount + '</strong>');
                    donation_amount.val(amount);
                    donation.attr('data-price',amount);
                    select_cert.add(select_brick).val('option[selected]');
                    select_cert.add(select_brick).attr('disabled',false);
                } else {
                    donation.html('<strong>Please select a brick size!</strong>');
                    select_cert.add(select_brick).attr('disabled','disabled');
                    donation_amount.val('');
               }
            });
            select_cert.add(select_brick).on('change',function(){
                var newchoice = $(this).find('option:selected').data('price'),
                    subtract = $(this).find('option.positive').data('price'),
                    original_amount = donation_amount.val();
                console.log(newchoice);
                var new_amount = parseInt(original_amount) + parseInt(newchoice);
                $(this).addClass('hasChanged');
                if(newchoice == 0 && $(this).hasClass('hasChanged')){
                    new_amount = parseInt(original_amount) - parseInt(subtract);
                }
                donation.html('<strong>$'+new_amount+'</strong>');
                donation_amount.val(new_amount);
            });
        }
    }

    function faqPage(){
        if($('div.faq').size() > 0){
            $('div.faq .question').click(function(){
                $(this).parent('div').toggleClass('open-faq');
            });
        }
    }

    function sidebarButtons(){
        if($('.sidebar').size() > 0){
            var widget = $('.sidebar .widget');
            widget.click(function(){
                widget.removeClass('isopen');
                $(this).addClass('isopen');
            });
        }
    }

    function footerLock(){
        var windowHeight = $(window).innerHeight();
        if(windowHeight >= $('footer.footer').offset().top && !$('body').hasClass('page-template-page-newsletter')){
            var mainheight = $('header.header').innerHeight() + $('.phone.mobile').innerHeight() + $('main').innerHeight();
            var push = windowHeight - mainheight;
            $('footer.footer').css('margin-top', push);
        }
    }
	
})(jQuery, this);
