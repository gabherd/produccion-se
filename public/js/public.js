

$(document).ready(function(){
    var id_user = $('#id_user').text();
    
    if (getCookie("update-showed") != id_user) {
        Swal.fire({
            title: '¡Nueva actualización!',
            text: 'Ahora podrás ver los registros de fechas pasadas haciendo click en el calendario',
            imageUrl: 'img/updates/update-v2.4.0.png',
            imageWidth: 200,
            imageHeight: 300,
            imageAlt: 'Custom image',
        }).then((result) => {
            document.cookie = "update-showed="+id_user; 
        });
    };
});


$('#date-selected').on('change', function(){
    var date = $(this).val();
    
    $('.loader').show();

    $.ajax({
            url: "/changeDate/"+date,
            dataType: "JSON",
            method:"GET",
            success: function(data, textStatus, xhr){
                console.log(xhr.status);
                document.location.reload(true);
            }, 
            error: function(data, textStatus, xhr){
                console.log(xhr.status);
            }
    });
});

//opciones de cuenta de usuario
$('body').click(function(e){
    if ($(e.target).is('.user-image')) {
        $('.box-options-account').toggle();
    }else{
        $('.box-options-account').hide();
    }
});

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
}


function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
