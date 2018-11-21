<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<div id="tag-trail">
					<h1 class="page-title"><?php 
					$tags = explode('+', $tag);
					$tagtitle = '';
					foreach ($tags as $atag) {
						$thetag = get_term_by('slug', $atag, 'post_tag', ARRAY_A);
						$taglink = '';
						$minusthistag = array_diff($tags, array($atag));
						if (empty($minusthistag)) $taglink = '/';
						else $taglink = '/tag/'.implode('+', $minusthistag);
						$tagtitle .= $thetag['name'] . ' <a href="'.$taglink.'" class="remove-tag" title="remove '.$thetag['name'].'">x</a> ';
					}
					
					echo $tagtitle;
					?></h1>
				</div>

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>