<?php

function favorite_post_show_button( $content ) {
    if( is_single() ) {
        global $post;
        $get_all_list = get_user_meta(get_current_user_id(),'favorite_post_list',true);

        $explode_list = array_filter(explode(',',$get_all_list));

        $class = '';
        $html_text = __('Add To Favorite?','favorite-post');
        if( in_array(get_the_ID(),$explode_list) ){
            $class = 'added';
            $html_text = __('Remove From Favorite?','favorite-post');
        }

        $html = wp_kses_post('<br /><a href="#" class="favorite-post '.$class.'" data-post_id="'.get_the_ID().'">'.$html_text.'</a>');
        $content .= $html;
    }
    return $content;
}
add_filter( 'the_content', 'favorite_post_show_button',1 );



add_action("wp_ajax_add_favorite_post", "add_favorite_post");
add_action("wp_ajax_nopriv_add_favorite_post", "my_must_login");

function add_favorite_post() {
    $get_post_id = $_POST['post_id'];
    $current_user_id = get_current_user_id();

    $get_all_list = get_user_meta($current_user_id,'favorite_post_list',true);

    $explode_list = array_filter(explode(',',$get_all_list));

    if( !in_array($get_post_id,$explode_list) ){
        array_push($explode_list,$get_post_id);
        update_usermeta( $current_user_id , 'favorite_post_list', implode(',',$explode_list) );
        $result['type'] = "success";
    }
    else{
        if (($key = array_search($get_post_id, $explode_list)) !== false) {
            unset($explode_list[$key]);
        }
        update_usermeta( $current_user_id , 'favorite_post_list', implode(',',array_filter($explode_list))  );
        $result['type'] = "success";
    }
    if(!is_user_logged_in()){
        $result['type'] = "error";
    }

    $result = json_encode($result);
    echo $result;
    die();
}


add_action( 'show_user_profile', 'fv_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'fv_add_custom_user_profile_fields' );

function fv_add_custom_user_profile_fields( $user ) {
    $get_all_list = get_user_meta(get_current_user_id(),'favorite_post_list',true);

    $explode_list = array_filter(explode(',',$get_all_list));
    ?>
    <h3><?php _e('Extra Profile Information', 'favorite-post'); ?></h3>

    <table class="form-table">
        <tr>
            <th>
                <label for="address"><?php _e('Favorite Posts', 'favorite-post'); ?></label>
            </th>
            <td>
                <?php foreach ($explode_list as $list): ?>
                <li><?php echo esc_html(get_the_title($list)) ?></li>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>
<?php }


add_shortcode('favorite_post_display','fv_display_favorite_posts');

function fv_display_favorite_posts(){

    $get_all_list = get_user_meta(get_current_user_id(),'favorite_post_list',true);

    $explode_list = array_filter(explode(',',$get_all_list));

    $html = '';

    if(is_array($explode_list)){
        $html .= '<h2>My Favorite Lists</h2>';
        $html .= '<ul>';
        foreach ($explode_list as $item) {
            $html .= '<li><a href="'.get_page_link($item).'">'.get_the_title($item).'</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}