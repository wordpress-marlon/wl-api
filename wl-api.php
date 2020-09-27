<?php


/**
 * Plugin Name: Custom API
 * Plugin URI: http://marlonfalcon.cl
 * Description : APÏ
 * Version : 1.0
 * Author : Marlon Falcon
 * Author URL: http://marlonfalcon.cl 

 */

# Estandar
 # http://localhost:10003/wp-json/wp/v2/posts

# http://localhost:10003/wp-json/wl/v1/posts
function wl_posts(){
    $args = [
        'numbersposts' =>  9999,
        'posts_type' => 'post' # page, product
    ];

    $posts = get_posts($args);

    $data = [];
    $i = 0;

    foreach($posts as $post){
        $data[$i]['id'] = $post->ID;
        $data[$i]['title'] = $post->post_title;
        $data[$i]['content'] = $post->post_content;
        $i++;
    }

    return $data;
}



# http://localhost:10003/wp-json/wl/v1/posts/1
function wl_post($slug){
    $args = [
        'id' =>  $slug['slug'],
        'posts_type' => 'post',
    ];

    $post = get_posts($args);

    $data['id'] = $post[0]->ID;
    $data['title'] = $post[0]->post_title;
    $data['content'] = $post[0]->post_content;
  

    return $data;
}

 add_action( 'rest_api_init', function(){

     register_rest_route('wl/v1', 'posts',[
        'method' => 'GET',
        'callback' => 'wl_posts',
     ]);

     register_rest_route('wl/v1', 'posts/(?P<slug>[a-zA-Z0-9-]+)', array(
        'method' => 'GET',
        'callback' => 'wl_post',
     ));


 });

?>