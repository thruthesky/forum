<?php
/**
 * The template for displaying all single posts and attachments
 *
 *
 */

get_header();
if ( ! have_posts() ) {
    // If it comes here, it is an error.
}
the_post();



?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="title">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </div>

            <div class="info">
                No. of Views : <?php  echo post()->increaseNoOfView( get_the_ID() )?>
            </div>


            <div class="content">
                <?php
                the_content();

                if ( '' !== get_the_author_meta( 'description' ) ) {
                    get_template_part( 'biography' );
                }
                ?>
            </div>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            ?>


    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
