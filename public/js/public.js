//Modal encima de otra modal
$(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

$('#btn-menu').on('click', function(){
    $('.menu-container').toggle();
    //toggle overflow y
    $('html').css("overflow", function(_,val){ 
           return val == "hidden" ? "scroll" : "hidden";
    });
});

$('.space-free').on('click', function(){
    $('.menu-container').toggle();
    //toggle overflow y
    $('html').css("overflow", function(_,val){ 
           return val == "hidden" ? "scroll" : "hidden";
    });
});

//obtiene el ancho del scroll lateral
function getScrollBarWidth () {
    var $outer = $('<div>').css({visibility: 'hidden', width: 100, overflow: 'scroll'}).appendTo('body'),
        widthWithScroll = $('<div>').css({width: '100%'}).appendTo($outer).outerWidth();
    $outer.remove();
    return 100 - widthWithScroll;
};