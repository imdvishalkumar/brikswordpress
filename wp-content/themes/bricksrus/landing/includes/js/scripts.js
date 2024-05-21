(function ($, root, undefined) {

    $(function () {

        'use strict';

        chat();
        liveChat();
        freesample();

        $(window).load(function(){
            pageHeight();
        });

        $(window).scroll(function(){
            liveChat();
            stickyHeader();
        });

        $(window).resize(function() {
            liveChat();
            pageHeight();
        });

    });

    function pageHeight(){
        var windowHeight = parseInt($(window).innerHeight() - ($('footer.footer').innerHeight() + 30)),
            contentHeight = parseInt($('main').innerHeight()),
            push = $('#push');
        if(contentHeight < windowHeight){
            var height = (windowHeight - contentHeight) - 117;
            push.css('height',height + 'px');
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

    function chat(){
        var popup = $('.popup-chat');
        if(popup.size() > 0){
            popup.click(function(e){
                e.preventDefault();
                window.open('//www.websitealive5.com/3637/rRouter.asp?groupid=3637&amp;websiteid=0&amp;departmentid=','guest', 'width=450,height=400');
            });
        }
    }

    function liveChat(){
        var chat = $('.live-chat');
        if(chat.size() > 0 && $(window).innerWidth() >= 900){
            var chatPosition = chat.offset().top;
            var offsetPosition = $('body').height() - 250;
            if(chatPosition >= offsetPosition){
                chat.addClass('reposition');
            } else {
                chat.removeClass('reposition');
            }
        }
    }

})(jQuery, this);