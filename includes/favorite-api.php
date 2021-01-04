<?php

add_action( 'rest_api_init', 'fv_post_register_routes' );
function fv_post_register_routes() {
    register_rest_route(
        'favorite-post/v2',
        '/author/(?P<id>\d+)',
        array(
            'methods' => 'GET',
            'callback' => 'fv_find_favorite_post_details',
            'permission_callback' =>  '__return_true',
        )
    );

    register_rest_route(
        'favorite-post/v2',
        '/author/',
        array(
            'methods' => 'PUT',
            'callback' => 'fv_update_favorite_post_details',
            'permission_callback' =>  '__return_true',
        )
    );
}


function fv_find_favorite_post_details( $data ) {


    $get_all_list = get_user_meta($data['id'],'favorite_post_list',true);
    $explode_list = array_filter(explode(',',$get_all_list));

    $result = array();


    if(is_array($explode_list)){
        foreach ($explode_list as $item) {
            $result[] = array(
                'id' => $item,
                'title' => get_the_title($item),
                'page_url' => get_page_link($item),
            );
        }

    }


    if ( empty( $result ) ) {
        return null;
    }

    return $result;
}


function fv_update_favorite_post_details( $data ) {
    $author_id = $data['author_id'];
    $old_post_id = $data['old_post_id'];
    $new_id = $data['new_id'];

    $get_all_list = get_user_meta($author_id,'favorite_post_list',true);

    $explode_list = array_filter(explode(',',$get_all_list));

    if( in_array($old_post_id,$explode_list) ){
        if (($key = array_search($old_post_id, $explode_list)) !== false) {
            unset($explode_list[$key]);
        }
        array_push($explode_list,$new_id);
        update_usermeta( $author_id , 'favorite_post_list', implode(',',$explode_list) );
        $result['type'] = "updated successfully";
    }
    else{
        $result['type'] = "error";
    }

    return $result;
}