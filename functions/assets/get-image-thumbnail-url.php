<?php
define('WP_USE_THEMES', false);
require( dirname( __FILE__ ) . '/../../../../../wp-blog-header.php' );

$image_id = intval($_GET['image_id']);
$image_arr = wp_get_attachment_image_src($image_id);

if($image_arr){
    header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
    echo $image_arr[0];
}else{
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
}
