window.addEventListener("load", function(){

    //Que se active el puntero al pasar el raton
    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    //Botón de like
    function like(){
        //Al clickar el dislike
        $('.btn-dislike').unbind('click').click(function(){
            console.log('like');
            //se añade el like y se quita el dislike
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', 'img/like_red.png');
            //llamamos a la función dislike
            dislike();
        });
    };
    like();

    //Botón de dislike
    function dislike(){
        $('.btn-like').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', 'img/like_empty.png');
            like();
        });
    };
    dislike();
});
