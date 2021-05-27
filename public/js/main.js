var url = 'http://tembi.com.devel';

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
            $(this).attr('src', url+'/img/like_red.png');

            //Llamar a la url que inserta el like en la ddbb
            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Liked correctly');
                    }else{
                        console.log('Like failed')
                    }
                }
            });
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
            $(this).attr('src', url+'/img/like_empty.png');

            //Llamar a la url que elimina el like de la ddbb
            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Disliked correctly');
                    }else{
                        console.log('Dislike failed')
                    }
                }
            });
            like();
        });
    };
    dislike();

    //Buscador de people
    $('#browser').submit(function(e){
        $(this).attr('action',url+'/people/'+$('#browser #search').val());
    })
});
