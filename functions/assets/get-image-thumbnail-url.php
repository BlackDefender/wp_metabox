<?php
define('WP_USE_THEMES', false);
require( dirname( __FILE__ ) . '/../../../../../wp-blog-header.php' );

$image_id = intval($_GET['image_id']);
$image_arr = wp_get_attachment_image_src($image_id);
echo $image_arr[0];