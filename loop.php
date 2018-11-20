<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */?>

<?php if (array_key_exists('trashed', $_GET) && $_GET['trashed']) { ?>
    <p class="notice">
        <?php $trashedpost = get_post($_GET['ids']); printf(__('<em>%s</em> has been moved to the <a href="%s">trash.'), $trashedpost->post_title, get_option('site_url').'/wp-admin/edit.php?post_status=trash&post_type=post'); ?> 
    </p>
<?php } ?>

<div id="tag-trail">
    <?php if (!is_tag()) { ?>
        <h1 class="page-title"><?php _e("tag filter:"); ?></h1>
    <?php } ?>
    
    <form id="tag-filter" action="<?php echo $action; ?>" method=="GET">
        <input type="text" name="tag" id="tag" />
    </form>
</div><!-- # tag-trail -->

<?php if (current_user_can('edit_posts')) { ?>

<?php } ?>


<?php $first = TRUE; ?>
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php 
/*
 if ( $wp_query->max_num_pages > 1 ) : ?>
    <div id="nav-above" class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
    </div><!-- #nav-above -->
<?php endif;
/**/
 ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
    <div id="post-0" class="post error404 not-found">
        <h1 class="entry-title"><?php _e( 'Not Found', 'twentyten' ); ?></h1>
        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </div><!-- #post-0 -->
<?php endif; ?>

<?php
    /* Start the Loop.
     *
     * In Twenty Ten we use the same loop in multiple contexts.
     * It is broken into three main parts: when we're displaying
     * posts that are in the gallery category, when we're displaying
     * posts in the asides category, and finally all other posts.
     *
     * Additionally, we sometimes check for whether we are on an
     * archive page, a search page, etc., allowing for small differences
     * in the loop on each template without actually duplicating
     * the rest of the loop that is shared.
     *
     * Without further ado, the loop:
     */
?>
<?php while ( have_posts() ) : the_post(); global $post; ?>

<?php /* How to display posts of the Aside format. The asides category is the old way. */ ?>
<?php if (is_new_day() && !$first) echo "</div><!-- day -->"; ?>
<?php $first = FALSE; ?>
<?php the_date('j M y', '<div class="day"><h2 class="date">', '</h2>', true); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="entry-content">
            <?php if(get_post_type($post) == 'bookmark'){ ?>
                <a href="<?php echo get_post_meta(get_the_ID(), 'link_url', true) ?>" class="title"><?php the_title(); ?></a>
                <?php if($desc=get_post_meta(get_the_ID(), 'link_desc', true)) { echo '<div class="description">' . $desc . '</div>'; } ?>
            <?php }else{ ?>
                <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                <?php the_content(); ?>
            <?php } ?>
            </div><!-- .entry-content -->

            <div class="entry-tags">
                <?php the_tags('<span class="a-tag">', '', '</span>'); ?>
            </div><!-- .entry-tags -->

            <div class="entry-utility">
                <?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
                <?php if (current_user_can('edit_posts')) { ?> <span class="meta-sep">|</span> <a href="<?php echo get_delete_post_link( $post->ID, '', false ) ?>">Delete</a> <?php } ?>
            </div><!-- .entry-utility -->
        </div><!-- #post-## -->

<?php endwhile; // End the loop. Whew. ?>
</div><!-- day -->

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php
/*
 if (  $wp_query->max_num_pages > 1 ) : ?>
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
                    <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
                </div><!-- #nav-below -->
<?php endif;
/**/
 ?>
