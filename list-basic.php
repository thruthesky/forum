<?php
get_header();
?>

    <style>
        #content {
            padding: 1em;
            font-family: "AppleGothic", "Gulim", "Dotum", serif;
        }
        #content #posts {

        }
        #content #posts article {

        }
        #content #posts article .title {
            margin: 0;
            padding: 0;
            font-size: 1.2rem;
        }

        article[data-status='close'] .data {
            display: none;
        }

    </style>

<script>
    jQuery( function( $ ) {
        var Post = {
            url : function ( id ) {
                return "<?php echo home_url('category/k-forum/?ajax=get_post&')?>" + "id=" + id;
            },
            load : function ( id, callback ) {
                var url = this.url( id );
                console.log(url);
                $.get( url, function( re ) {
                    callback(re);
                });
            },
            markup : {
                data : function ( post ) {

                }
            },
            isOpen : function ( $art ) {
                return $art.attr('data-status') == 'open';
            },
            close : function ( $art ) {
                $art.attr('data-status', 'close');
                this.clear( $art );
            },
            clear : function ($art) {
                $art.find('.content').empty();
            },
            setData : function ( $art, post ) {
                this.setContent( $art, post['data']['post_content'])
            }
        };
        $("article .title").click(function( event ){
            return;
            event.preventDefault();

            var $title = $(this);
            var $article = $title.parents( 'article' );
            if ( Post.isOpen( $article ) ) {
                Post.close( $article );
            }

            Post.load( $article.attr('data-post-id'), function( post ) {
                Post.setData($art, post);
                //$article.append(post['data']['post_content']);
                //$article.attr('data-status', 'open');
            } );

        });

    });
</script>
    <section id="posts">
        <?php
        if ( have_posts() ) : while( have_posts() ) : the_post();
            ?>
            <article data-post-id="<?php the_ID()?>" data-status="close">
                <?php the_title( sprintf( '<h2 class="title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                <div class="data">
                    <div class="content">
                        .data .content
                    </div>
                </div>
            </article>
            <?php
        endwhile; endif;
        ?>
    </section>
<?php


get_footer();