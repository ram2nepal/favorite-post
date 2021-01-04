<?php
function favorite_post_register_widget() {
    register_widget( 'favorite_post_widget' );
}
add_action( 'widgets_init', 'favorite_post_register_widget' );

class favorite_post_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
// widget ID
            'favorite_post_widget',
// widget name
            __('Favorite Posts Lists Widget', ' favorite_post_widget_domain'),
// widget description
            array( 'description' => __( 'Show your favorite posts', 'favorite_post_widget_domain' ), )
        );
    }
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
//if title is present
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
//output

        $get_all_list = get_user_meta(get_current_user_id(),'favorite_post_list',true);

        $explode_list = array_filter(explode(',',$get_all_list));

        if(is_array($explode_list)){
            echo '<ul>';
            foreach ($explode_list as $item) {
                echo '<li><a href="'.get_page_link($item).'">'.get_the_title($item).'</a></li>';
            }
            echo '</ul>';

        }

        echo $args['after_widget'];
    }
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) )
            $title = $instance[ 'title' ];
        else
            $title = __( 'Default Title', 'favorite_post_widget_domain' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}