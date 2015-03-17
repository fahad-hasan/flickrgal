<?php
session_start();
include 'application/config.php';
include 'application/routing.php';

/*
Application: flickrgal
Description: An example of flickr gallery using raw PHP, HTML and CSS
Author: Floyd Hasan
Date: 17 March 2015
This is the default index page. This exists only for routing purpose.
Example: http://localhost/flickrgal/?route={gallery}
The above URL will initialize the following:
1. {gallery}Controller.php from application/controllers/ folder. This is where all controller logic should be placed.
2. {gallery}.php from application/views/ folder. This is where the rendering HTML should be placed.

CONFIG
The config file is located at application/config.php
$CONFIG['default_route'] defines the default route to execute in case $_GET['route'] is empty
$CONFIG['controller_path'] defines the controllers path.
$CONFIG['view_path'] defines the views path.

Custom configs can be added in the same format and will be available across the application.
$CONFIG['custom_key'] = 'custom_value';
*/
?>