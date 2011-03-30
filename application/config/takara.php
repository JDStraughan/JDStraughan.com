<?php

return array(
	'tables' => array(
		'posts', 
		'pages', 
		'gallery',
		'faqs'
	),
	'gallery_uploads' => array(
		'images_dir' => './media/images/managed/',
		'thumbs_dir' => './media/images/managed/thumbs/',
		'thumb_height' => 100,
		'thumb_width' => 100,
		'image_max_height' => 600,
		'image_max_width' => 600
	),
	'rte_uploads' => array(
		'images' => './media/images/rte',
		'image_max_height' => 600,
		'image_max_width' => 600
	)
);