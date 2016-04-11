<?php
get_header();
?>
    <style>
        #posts,
        #posts td,
        #posts h2 {
            font-size: 1.2rem;
            font-family: "Malgun Gothic", "AppleGothic", "Gulim", "Dotum", serif;
        }

        #posts table {
            width: 100%;
        }

        #posts table tr,
        #posts table td {
            margin: 0;
            padding: 0;
        }


        #posts thead th {
            font-weight: normal;
            font-size: 1rem;
            text-align:center;
        }

        #posts .title {
            margin: 0;
            padding: 0;
            font-size: 1.2rem;
        }
        #posts .title h2 {
            margin: 0;
            padding: 0;
        }
        #posts .title a {
            display: block;
        }

        #posts tbody tr:nth-child(even) {
            background-color: #a9a9a9;
        }


        #posts .author,
        #posts .date,
        #posts .no-of-view {
            display:none;
        }

        #posts .author {
            min-width: 5em;
            text-align:left;
        }
        #posts .date {
            min-width: 5em;
            text-align: center;
        }
        #posts .no-of-view {
            min-width: 4em;
            text-align: right;
            padding-right: 1em;
            box-sizing: border-box;
        }

        @media all and ( min-width: 33.9em ) {
            #posts .author {
                display: table-cell;
            }
        }
        @media all and ( min-width: 47.9em ) {
            #posts .date,
            #posts .no-of-view {
                display: table-cell;
            }
        }


        /** post new */

        #post-new {
            display: none;
        }
        .post-new-button {
            cursor: pointer;
        }
    </style>

    <script>
        jQuery( function( $ ) {
            var $posts = $('#posts');
            $('.post-new-button').click(function(){
                $posts.hide();
                $('#post-new').show();
            });
        } );
    </script>

<?php

// Grab the first cat in the list.
$categories = get_the_category();
$category_id = $categories[0]->term_id;

?>

<section id="post-new">
    <form action="<?php echo home_url("category/forum")?>">

        <input type="hidden" name="do" value="post_create">
        <input type="hidden" name="category_id" value="<?php echo $category_id?>">
        <label for="new-title">Title</label>
        <div class="text">
            <input type="text" id="new-title" name="title">
        </div>

        <label for="new-content">Content</label>
        <div class="text">
            <textarea id="new-content" name="content"></textarea>
        </div>

        <label for="new-content"><input type="submit"></label>

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
    </main>
<?php

get_footer();
