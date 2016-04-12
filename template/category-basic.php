<?php
get_header();
wp_enqueue_style( 'category-basic', get_stylesheet_directory_uri() . '/forum/css/category-basic.css' );
wp_enqueue_script( 'category-basic', get_stylesheet_directory_uri() . '/forum/js/category-basic.js' );
wp_enqueue_script( 'forum', get_stylesheet_directory_uri() . '/forum/js/forum.js' );
wp_enqueue_script( 'jquery-form' );
$categories = get_the_category();
if ( empty($categories) ) {
    $category = get_category_by_slug( segment(2) );
    $category_id = $category->term_id;

}
else $category_id = $categories[0]->term_id;
?>
<script>
    var url_endpoint = "<?php echo home_url("category/forum")?>";
    var max_upload_size = <?php echo wp_max_upload_size();?>;
</script>


    <section id="post-new">
        <form action="<?php echo home_url("category/forum")?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="do" value="post_create">
            <input type="hidden" name="category_id" value="<?php echo $category_id?>">
            <label for="title">Title</label>
            <div class="text">
                <input type="text" id="title" name="title">
            </div>

            <label for="content">Content</label>
            <div class="text">

                <?php
                $content = '';
                $editor_id = 'content';
                $settings = array( 'media_buttons' => false, 'textarea_rows' => 20,
                    'quicktags' => false
                );
                wp_editor( $content, $editor_id, $settings );

                ?>

            </div>

            <div class="photos"></div>
            <div class="files"></div>

            <div class="file-upload">
                <span class="dashicons dashicons-camera"></span>
                <span class="text">Choose File</span>
                <input type="file" name="file" onchange="forum.on_change_file_upload(this);" style="opacity: .001;">
            </div>
            <div class="loader">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/forum/img/loader14.gif">
                File upload is in progress. Please wait.
            </div>

            <label for="post-submit-button"><input id="post-submit-button" type="submit"></label>
            <label for="post-cancel-button"><div id="post-cancel-button">Cancel</div></label>

        </form>
    </section>




    <main id="posts">


        <div class="post-new-button">
            POST NEW
        </div>

        <table>
            <thead>
            <th class="title">Title</th>
            <th class="author">Author</th>
            <th class="date">Date</th>
            <th class="no-of-view" title="No. of Views">View</th>
            </thead>
            <tbody>
            <?php
            if ( have_posts() ) : while( have_posts() ) : the_post();
                ?>
                <tr data-post-id="<?php the_ID()?>">
                    <td class="title">
                        <h2>
                            <a href="<?php echo esc_url( get_permalink() )?>">
                                <?php
                                $content = get_the_title();
                                if ( strlen( $content ) > 100 ) {
                                    $content = substr( get_the_title(), 0, strpos(get_the_title(), ' ', 100) );
                                }
                                echo $content;
                                ?>
                                <span class="title-no-of-view"><?php
                                    $count = wp_count_comments( get_the_ID() );
                                    if ( $count->approved )  echo "({$count->approved})";
                                    ?></span>
                                <?php
                                if ( post()->getNoOfImg( get_the_content() ) ) {
                                    echo '<span class="dashicons dashicons-format-gallery"></span>';
                                }
                                ?>
                            </a>

                        </h2>
                    </td>
                    <td class="author"><div><?php the_author()?></div></td>
                    <td class="date"><div title="<?php echo get_the_date()?>"><?php post()->the_date()?></div></td>
                    <td class="no-of-view"><div><?php echo number_format(post()->getNoOfView( get_the_ID() ) )?></div></td>
                </tr>
                <?php
            endwhile; endif;
            ?>
            </tbody>
        </table>


        <?php


        // Previous/next page navigation.
        the_posts_pagination( array(
            'mid_size'              => 5,
            'prev_text'             => 'PREV',
            'next_text'             => 'NEXT',
            'before_page_number'    => '[',
            'after_page_number'     => ']',

        ) );

        ?>
    </main>
<?php

get_footer();
