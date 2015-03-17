<?php
set_error_handler("warning_handler", E_WARNING);
function warning_handler() {
    //DO NOTHING
}

//Utility functions
function load_view($name) {
    global $CONFIG;
    if (file_exists($CONFIG['view_path'].$name.".php")) {
        include $CONFIG['view_path'].$name.".php";
    } else {
        die('Can not find '.$name.'.php in '.$CONFIG['view_path']);
    }
}

//Routing
$route = $CONFIG['default_route'];
if (isset($_GET['route']) && !empty($_GET['route'])) {
    $route = $_GET['route'];
}

//Loading controller
if (file_exists($CONFIG['controller_path'].$route."Controller.php")) {
    include $CONFIG['controller_path'].$route."Controller.php";
}

//Loading views
load_view($route);

?>