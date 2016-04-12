jQuery( function( $ ) {
    var $posts = $('#posts');
    $('.post-new-button').click(function(){
        $posts.hide();
        $('#post-new').show();
    });
    $('#post-cancel-button').click(function(){
        $('#post-new').hide();
        $posts.show();
    });



} );

