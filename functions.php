<?php

add_action('widgets_init', 'tag_list_widget_setup');
add_filter('pre_get_posts', 'my_get_posts');

// local tag list

function tag_list_widget_setup() {
    register_widget('Tag_List_Widget');
}

function my_get_posts( $query ) 
{
    $isSuppressFilters = false;
    if (array_key_exists('suppress_filters', $query->query_vars)) {
        $isSuppressFilters = ($query->query_vars['suppress_filters'] != false);
    }
    if ( (is_home() || is_search() || is_tag() || is_category()) && !$isSuppressFilters )
        $query->set( 'post_type', array( 'post', 'bookmark' ) );

    return $query;
}

class Tag_List_Widget extends WP_Widget {

    function __construct() {
            $widget_ops = array( 'description' => __('Lists all tags') );
            $control_ops = array( 'width' => 400, 'height' => 200 );
            parent::__construct( 'tag_list', __('Tag List'), $widget_ops, $control_ops );
        }

    function widget($args, $instance) {
            extract( $args );
            echo $before_widget; 
            
            $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Top Tags' ) : $instance['title']);
            echo $before_title . $title . $after_title;
            ?>
            <ul id="tag-list-widget">
            <?php
            $tags = get_terms('post_tag', array(
                'fields' => 'all', 
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => $instance['num']  ));
            foreach ($tags as $tag) {
                echo '<li><a href="/tag/'.$tag->slug.'">'.$tag->name.'<span class="count">'.$tag->count.'</span></a></li>';
            }
            
            ?>
            </ul>
           <?php
            echo $after_widget;
    }
    
    function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['num'] = (int)$new_instance['num'];
            return $instance;
    }

    function form( $instance ) {
            //Defaults
                $instance = wp_parse_args( (array) $instance, array( 
                        'title' => 'Top Tags',
                        'num' => 45,
                            )); 
    ?>  
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of links to show:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $instance['num']; ?>" /></p>
        <?php
    }
}
?>
