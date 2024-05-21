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
!function(a){"use strict";function b(){}function c(){try{return document.activeElement}catch(a){}}function d(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return!0;return!1}function e(a,b,c){return a.addEventListener?a.addEventListener(b,c,!1):a.attachEvent?a.attachEvent("on"+b,c):void 0}function f(a,b){var c;a.createTextRange?(c=a.createTextRange(),c.move("character",b),c.select()):a.selectionStart&&(a.focus(),a.setSelectionRange(b,b))}function g(a,b){try{return a.type=b,!0}catch(c){return!1}}function h(a,b){if(a&&a.getAttribute(B))b(a);else for(var c,d=a?a.getElementsByTagName("input"):N,e=a?a.getElementsByTagName("textarea"):O,f=d?d.length:0,g=e?e.length:0,h=f+g,i=0;h>i;i++)c=f>i?d[i]:e[i-f],b(c)}function i(a){h(a,k)}function j(a){h(a,l)}function k(a,b){var c=!!b&&a.value!==b,d=a.value===a.getAttribute(B);if((c||d)&&"true"===a.getAttribute(C)){a.removeAttribute(C),a.value=a.value.replace(a.getAttribute(B),""),a.className=a.className.replace(A,"");var e=a.getAttribute(I);parseInt(e,10)>=0&&(a.setAttribute("maxLength",e),a.removeAttribute(I));var f=a.getAttribute(D);return f&&(a.type=f),!0}return!1}function l(a){var b=a.getAttribute(B);if(""===a.value&&b){a.setAttribute(C,"true"),a.value=b,a.className+=" "+z;var c=a.getAttribute(I);c||(a.setAttribute(I,a.maxLength),a.removeAttribute("maxLength"));var d=a.getAttribute(D);return d?a.type="text":"password"===a.type&&g(a,"text")&&a.setAttribute(D,"password"),!0}return!1}function m(a){return function(){P&&a.value===a.getAttribute(B)&&"true"===a.getAttribute(C)?f(a,0):k(a)}}function n(a){return function(){l(a)}}function o(a){return function(){i(a)}}function p(a){return function(b){return v=a.value,"true"===a.getAttribute(C)&&v===a.getAttribute(B)&&d(x,b.keyCode)?(b.preventDefault&&b.preventDefault(),!1):void 0}}function q(a){return function(){k(a,v),""===a.value&&(a.blur(),f(a,0))}}function r(a){return function(){a===c()&&a.value===a.getAttribute(B)&&"true"===a.getAttribute(C)&&f(a,0)}}function s(a){var b=a.form;b&&"string"==typeof b&&(b=document.getElementById(b),b.getAttribute(E)||(e(b,"submit",o(b)),b.setAttribute(E,"true"))),e(a,"focus",m(a)),e(a,"blur",n(a)),P&&(e(a,"keydown",p(a)),e(a,"keyup",q(a)),e(a,"click",r(a))),a.setAttribute(F,"true"),a.setAttribute(B,T),(P||a!==c())&&l(a)}var t=document.createElement("input"),u=void 0!==t.placeholder;if(a.Placeholders={nativeSupport:u,disable:u?b:i,enable:u?b:j},!u){var v,w=["text","search","url","tel","email","password","number","textarea"],x=[27,33,34,35,36,37,38,39,40,8,46],y="#ccc",z="placeholdersjs",A=new RegExp("(?:^|\\s)"+z+"(?!\\S)"),B="data-placeholder-value",C="data-placeholder-active",D="data-placeholder-type",E="data-placeholder-submit",F="data-placeholder-bound",G="data-placeholder-focus",H="data-placeholder-live",I="data-placeholder-maxlength",J=100,K=document.getElementsByTagName("head")[0],L=document.documentElement,M=a.Placeholders,N=document.getElementsByTagName("input"),O=document.getElementsByTagName("textarea"),P="false"===L.getAttribute(G),Q="false"!==L.getAttribute(H),R=document.createElement("style");R.type="text/css";var S=document.createTextNode("."+z+" {color:"+y+";}");R.styleSheet?R.styleSheet.cssText=S.nodeValue:R.appendChild(S),K.insertBefore(R,K.firstChild);for(var T,U,V=0,W=N.length+O.length;W>V;V++)U=V<N.length?N[V]:O[V-N.length],T=U.attributes.placeholder,T&&(T=T.nodeValue,T&&d(w,U.type)&&s(U));var X=setInterval(function(){for(var a=0,b=N.length+O.length;b>a;a++)U=a<N.length?N[a]:O[a-N.length],T=U.attributes.placeholder,T?(T=T.nodeValue,T&&d(w,U.type)&&(U.getAttribute(F)||s(U),(T!==U.getAttribute(B)||"password"===U.type&&!U.getAttribute(D))&&("password"===U.type&&!U.getAttribute(D)&&g(U,"text")&&U.setAttribute(D,"password"),U.value===U.getAttribute(B)&&(U.value=T),U.setAttribute(B,T)))):U.getAttribute(C)&&(k(U),U.removeAttribute(B));Q||clearInterval(X)},J);e(a,"beforeunload",function(){M.disable()})}}(this);

!function(a,b,c,d){var e=a(b);a.fn.lazyload=function(f){function g(){var b=0;i.each(function(){var c=a(this);if(!j.skip_invisible||c.is(":visible"))if(a.abovethetop(this,j)||a.leftofbegin(this,j));else if(a.belowthefold(this,j)||a.rightoffold(this,j)){if(++b>j.failure_limit)return!1}else c.trigger("appear"),b=0})}var h,i=this,j={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:b,data_attribute:"original",skip_invisible:!1,appear:null,load:null,placeholder:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"};return f&&(d!==f.failurelimit&&(f.failure_limit=f.failurelimit,delete f.failurelimit),d!==f.effectspeed&&(f.effect_speed=f.effectspeed,delete f.effectspeed),a.extend(j,f)),h=j.container===d||j.container===b?e:a(j.container),0===j.event.indexOf("scroll")&&h.bind(j.event,function(){return g()}),this.each(function(){var b=this,c=a(b);b.loaded=!1,(c.attr("src")===d||c.attr("src")===!1)&&c.is("img")&&c.attr("src",j.placeholder),c.one("appear",function(){if(!this.loaded){if(j.appear){var d=i.length;j.appear.call(b,d,j)}a("<img />").bind("load",function(){var d=c.attr("data-"+j.data_attribute);c.hide(),c.is("img")?c.attr("src",d):c.css("background-image","url('"+d+"')"),c[j.effect](j.effect_speed),b.loaded=!0;var e=a.grep(i,function(a){return!a.loaded});if(i=a(e),j.load){var f=i.length;j.load.call(b,f,j)}}).attr("src",c.attr("data-"+j.data_attribute))}}),0!==j.event.indexOf("scroll")&&c.bind(j.event,function(){b.loaded||c.trigger("appear")})}),e.bind("resize",function(){g()}),/(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion)&&e.bind("pageshow",function(b){b.originalEvent&&b.originalEvent.persisted&&i.each(function(){a(this).trigger("appear")})}),a(c).ready(function(){g()}),this},a.belowthefold=function(c,f){var g;return g=f.container===d||f.container===b?(b.innerHeight?b.innerHeight:e.height())+e.scrollTop():a(f.container).offset().top+a(f.container).height(),g<=a(c).offset().top-f.threshold},a.rightoffold=function(c,f){var g;return g=f.container===d||f.container===b?e.width()+e.scrollLeft():a(f.container).offset().left+a(f.container).width(),g<=a(c).offset().left-f.threshold},a.abovethetop=function(c,f){var g;return g=f.container===d||f.container===b?e.scrollTop():a(f.container).offset().top,g>=a(c).offset().top+f.threshold+a(c).height()},a.leftofbegin=function(c,f){var g;return g=f.container===d||f.container===b?e.scrollLeft():a(f.container).offset().left,g>=a(c).offset().left+f.threshold+a(c).width()},a.inviewport=function(b,c){return!(a.rightoffold(b,c)||a.leftofbegin(b,c)||a.belowthefold(b,c)||a.abovethetop(b,c))},a.extend(a.expr[":"],{"below-the-fold":function(b){return a.belowthefold(b,{threshold:0})},"above-the-top":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-screen":function(b){return a.rightoffold(b,{threshold:0})},"left-of-screen":function(b){return!a.rightoffold(b,{threshold:0})},"in-viewport":function(b){return a.inviewport(b,{threshold:0})},"above-the-fold":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-fold":function(b){return a.rightoffold(b,{threshold:0})},"left-of-fold":function(b){return!a.rightoffold(b,{threshold:0})}})}(jQuery,window,document);

!function(a,b){"function"==typeof define&&define.amd?define([],b):"object"==typeof exports?module.exports=b:a.conditionizr=b()}(this,function(){"use strict";var a,b={},c=document.head||document.getElementsByTagName("head")[0],d=function(b,d,e){var f=e?b:a+b+("style"===d?".css":".js");switch(d){case"script":var g=document.createElement("script");g.src=f,c.appendChild(g);break;case"style":var h=document.createElement("link");h.href=f,h.rel="stylesheet",c.appendChild(h);break;case"class":document.documentElement.className+=" "+b}};return b.config=function(c){var e=c||{},f=e.tests;a=e.assets||"";for(var g in f){var h=g.toLowerCase();if(b[h])for(var i=f[g],j=i.length;j--;)d(h,i[j])}},b.add=function(a,c,e){var f=a.toLowerCase();if(b[f]=e(),b[f])for(var g=c.length;g--;)d(f,c[g])},b.on=function(a,c){var d=/^\!/;(b[a.toLowerCase()]||d.test(a)&&!b[a.replace(d,"")])&&c()},b.load=b.polyfill=function(a,c){for(var e=/\.js$/.test(a)?"script":"style",f=c.length;f--;)b[c[f].toLowerCase()]&&d(a,e,!0)},b});

window.Modernizr=function(a,b,c){function C(a){j.cssText=a}function D(a,b){return C(n.join(a+";")+(b||""))}function E(a,b){return typeof a===b}function F(a,b){return!!~(""+a).indexOf(b)}function G(a,b){for(var d in a){var e=a[d];if(!F(e,"-")&&j[e]!==c)return"pfx"==b?e:!0}return!1}function H(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:E(f,"function")?f.bind(d||b):f}return!1}function I(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+p.join(d+" ")+d).split(" ");return E(b,"string")||E(b,"undefined")?G(e,b):(e=(a+" "+q.join(d+" ")+d).split(" "),H(e,b,c))}function J(){e.input=function(c){for(var d=0,e=c.length;e>d;d++)u[c[d]]=!!(c[d]in k);return u.list&&(u.list=!(!b.createElement("datalist")||!a.HTMLDataListElement)),u}("autocomplete autofocus list placeholder max min multiple pattern required step".split(" ")),e.inputtypes=function(a){for(var e,f,h,d=0,i=a.length;i>d;d++)k.setAttribute("type",f=a[d]),e="text"!==k.type,e&&(k.value=l,k.style.cssText="position:absolute;visibility:hidden;",/^range$/.test(f)&&k.style.WebkitAppearance!==c?(g.appendChild(k),h=b.defaultView,e=h.getComputedStyle&&"textfield"!==h.getComputedStyle(k,null).WebkitAppearance&&0!==k.offsetHeight,g.removeChild(k)):/^(search|tel)$/.test(f)||(e=/^(url|email)$/.test(f)?k.checkValidity&&k.checkValidity()===!1:k.value!=l)),t[a[d]]=!!e;return t}("search tel url email datetime date month week time datetime-local number range color".split(" "))}var x,B,d="2.7.1",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k=b.createElement("input"),l=":)",m={}.toString,n=" -webkit- -moz- -o- -ms- ".split(" "),o="Webkit Moz O ms",p=o.split(" "),q=o.toLowerCase().split(" "),r={svg:"http://www.w3.org/2000/svg"},s={},t={},u={},v=[],w=v.slice,y=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))for(;d--;)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},z=function(){function d(d,e){e=e||b.createElement(a[d]||"div"),d="on"+d;var f=d in e;return f||(e.setAttribute||(e=b.createElement("div")),e.setAttribute&&e.removeAttribute&&(e.setAttribute(d,""),f=E(e[d],"function"),E(e[d],"undefined")||(e[d]=c),e.removeAttribute(d))),e=null,f}var a={select:"input",change:"input",submit:"form",reset:"form",error:"img",load:"img",abort:"img"};return d}(),A={}.hasOwnProperty;B=E(A,"undefined")||E(A.call,"undefined")?function(a,b){return b in a&&E(a.constructor.prototype[b],"undefined")}:function(a,b){return A.call(a,b)},Function.prototype.bind||(Function.prototype.bind=function(a){var b=this;if("function"!=typeof b)throw new TypeError;var c=w.call(arguments,1),d=function(){if(this instanceof d){var e=function(){};e.prototype=b.prototype;var f=new e,g=b.apply(f,c.concat(w.call(arguments)));return Object(g)===g?g:f}return b.apply(a,c.concat(w.call(arguments)))};return d}),s.flexbox=function(){return I("flexWrap")},s.canvas=function(){var a=b.createElement("canvas");return!(!a.getContext||!a.getContext("2d"))},s.canvastext=function(){return!(!e.canvas||!E(b.createElement("canvas").getContext("2d").fillText,"function"))},s.webgl=function(){return!!a.WebGLRenderingContext},s.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:y(["@media (",n.join("touch-enabled),("),h,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=9===a.offsetTop}),c},s.geolocation=function(){return"geolocation"in navigator},s.postmessage=function(){return!!a.postMessage},s.websqldatabase=function(){return!!a.openDatabase},s.indexedDB=function(){return!!I("indexedDB",a)},s.hashchange=function(){return z("hashchange",a)&&(b.documentMode===c||b.documentMode>7)},s.history=function(){return!(!a.history||!history.pushState)},s.draganddrop=function(){var a=b.createElement("div");return"draggable"in a||"ondragstart"in a&&"ondrop"in a},s.websockets=function(){return"WebSocket"in a||"MozWebSocket"in a},s.rgba=function(){return C("background-color:rgba(150,255,150,.5)"),F(j.backgroundColor,"rgba")},s.hsla=function(){return C("background-color:hsla(120,40%,100%,.5)"),F(j.backgroundColor,"rgba")||F(j.backgroundColor,"hsla")},s.multiplebgs=function(){return C("background:url(https://),url(https://),red url(https://)"),/(url\s*\(.*?){3}/.test(j.background)},s.backgroundsize=function(){return I("backgroundSize")},s.borderimage=function(){return I("borderImage")},s.borderradius=function(){return I("borderRadius")},s.boxshadow=function(){return I("boxShadow")},s.textshadow=function(){return""===b.createElement("div").style.textShadow},s.opacity=function(){return D("opacity:.55"),/^0.55$/.test(j.opacity)},s.cssanimations=function(){return I("animationName")},s.csscolumns=function(){return I("columnCount")},s.cssgradients=function(){var a="background-image:",b="gradient(linear,left top,right bottom,from(#9f9),to(white));",c="linear-gradient(left top,#9f9, white);";return C((a+"-webkit- ".split(" ").join(b+a)+n.join(c+a)).slice(0,-a.length)),F(j.backgroundImage,"gradient")},s.cssreflections=function(){return I("boxReflect")},s.csstransforms=function(){return!!I("transform")},s.csstransforms3d=function(){var a=!!I("perspective");return a&&"webkitPerspective"in g.style&&y("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(b){a=9===b.offsetLeft&&3===b.offsetHeight}),a},s.csstransitions=function(){return I("transition")},s.fontface=function(){var a;return y('@font-face {font-family:"font";src:url("https://")}',function(c,d){var e=b.getElementById("smodernizr"),f=e.sheet||e.styleSheet,g=f?f.cssRules&&f.cssRules[0]?f.cssRules[0].cssText:f.cssText||"":"";a=/src/i.test(g)&&0===g.indexOf(d.split(" ")[0])}),a},s.generatedcontent=function(){var a;return y(["#",h,"{font:0/0 a}#",h,':after{content:"',l,'";visibility:hidden;font:3px/1 a}'].join(""),function(b){a=b.offsetHeight>=3}),a},s.video=function(){var a=b.createElement("video"),c=!1;try{(c=!!a.canPlayType)&&(c=new Boolean(c),c.ogg=a.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,""),c.h264=a.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,""),c.webm=a.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,""))}catch(d){}return c},s.audio=function(){var a=b.createElement("audio"),c=!1;try{(c=!!a.canPlayType)&&(c=new Boolean(c),c.ogg=a.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/,""),c.mp3=a.canPlayType("audio/mpeg;").replace(/^no$/,""),c.wav=a.canPlayType('audio/wav; codecs="1"').replace(/^no$/,""),c.m4a=(a.canPlayType("audio/x-m4a;")||a.canPlayType("audio/aac;")).replace(/^no$/,""))}catch(d){}return c},s.localstorage=function(){try{return localStorage.setItem(h,h),localStorage.removeItem(h),!0}catch(a){return!1}},s.sessionstorage=function(){try{return sessionStorage.setItem(h,h),sessionStorage.removeItem(h),!0}catch(a){return!1}},s.webworkers=function(){return!!a.Worker},s.applicationcache=function(){return!!a.applicationCache},s.svg=function(){return!!b.createElementNS&&!!b.createElementNS(r.svg,"svg").createSVGRect},s.inlinesvg=function(){var a=b.createElement("div");return a.innerHTML="<svg/>",(a.firstChild&&a.firstChild.namespaceURI)==r.svg},s.smil=function(){return!!b.createElementNS&&/SVGAnimate/.test(m.call(b.createElementNS(r.svg,"animate")))},s.svgclippaths=function(){return!!b.createElementNS&&/SVGClipPath/.test(m.call(b.createElementNS(r.svg,"clipPath")))};for(var K in s)B(s,K)&&(x=K.toLowerCase(),e[x]=s[K](),v.push((e[x]?"":"no-")+x));return e.input||J(),e.addTest=function(a,b){if("object"==typeof a)for(var d in a)B(a,d)&&e.addTest(d,a[d]);else{if(a=a.toLowerCase(),e[a]!==c)return e;b="function"==typeof b?b():b,"undefined"!=typeof f&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},C(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return"string"==typeof a?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){if(c||(c=b),k)return c.createElement(a);d||(d=n(c));var g;return g=d.cache[a]?d.cache[a].cloneNode():f.test(a)?(d.cache[a]=d.createElem(a)).cloneNode():d.createElem(a),!g.canHaveChildren||e.test(a)||g.tagUrn?g:d.frag.appendChild(g)}function p(a,c){if(a||(a=b),k)return a.createDocumentFragment();c=c||n(a);for(var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;g>e;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return!s.shivCSS||g||c.hasCSS||(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var g,k,c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,h="_html5shiv",i=0,j={};!function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=1==a.childNodes.length||function(){b.createElement("a");var a=b.createDocumentFragment();return"undefined"==typeof a.cloneNode||"undefined"==typeof a.createDocumentFragment||"undefined"==typeof a.createElement}()}catch(c){g=!0,k=!0}}();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._prefixes=n,e._domPrefixes=q,e._cssomPrefixes=p,e.hasEvent=z,e.testProp=function(a){return G([a])},e.testAllProps=I,e.testStyles=y,e.prefixed=function(a,b,c){return b?I(a,b,c):I(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+v.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var A,B,l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}};B=function(a){function b(a){var e,f,g,a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a};for(f=0;d>f;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;b>f;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var c,b=0;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var m,n,h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var l,o,k=b.createElement("script"),e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var j,e=b.createElement("link"),c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};