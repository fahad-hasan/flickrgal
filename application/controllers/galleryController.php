<?php

class gallary {
    public function searchFlickr($searchString = null, $page = null) {
        global $CONFIG;
        $page = (empty($page) || $page < 1) ? 1 : $page;

        //FIXING THE PAGINATION
        //The default flickr pagination does not support more than 10000 pages.
        //So we need to reduce the number of pages by requesting larger per_page (500 instead of 5) and then implement our own pagination logic
        $start = ($page - 1) * 5;
        $page_500 = floor($start / 500) + 1;
        $start = $start - ($page_500 - 1) * 500;

        //Caching KEY
        $cache_key = str_replace(' ', '_', $searchString).'_'.$page_500;

        $result = "";

        //Check if the result is in Cache
        if(array_key_exists($cache_key, $_SESSION['flickrgal_cache'])){
            $result = $_SESSION['flickrgal_cache'][$cache_key];
        } else {
            unset($_SESSION['flickrgal_cache']);
            //Base REST endpoint
            $search = 'http://flickr.com/services/rest/?';

            if (empty($params)) $params = array();



            //Parameters for the REST call
            $params['api_key'] = '53fa8bb8fde5e03d39edf65ce07a243e';
            $params['method'] = 'flickr.photos.search';
            $params['text'] = $searchString;
            $params['page'] = $page_500;
            $params['per_page'] = 500;
            $params['format'] = 'php_serial';
            $params['extras'] = 'original_format';

            //Building the REST url from parameters
            if (empty($params)) $params = array();
            foreach ($params as $var => $val) {
                $var = urlencode($var);
                $val = urlencode($val);
                $search .= '&' . $var . '=' . $val;
            }


            $result = file_get_contents($search);
            //Put the results in cache
            $result = unserialize($result);
            $_SESSION['flickrgal_cache'][$cache_key] = $result;
        }

        //Initializing empty objects for json return
        $returnObj = new stdClass;
        $returnObj->photos = new stdClass;

        //Slicing the 500 sized page to get our desired 5 photos
        $length = $page * 5 > $result['photos']['total'] ? $result['photos']['total'] - (($page - 1) * 5) : 5;
        $result_slice = array_slice($result['photos']['photo'], $start, $length, true);

        //Preparing the returnObj with pagination and photo metadata
        $returnObj->photos->page = $page;
        //$returnObj->photos->page_original = $page_500;
        $returnObj->photos->total = $result['photos']['total'];
        $returnObj->photos->pages = ceil($result['photos']['total'] / 5);
        //$returnObj->photos->pages_original = $result['photos']['pages'];
        $returnObj->photos->photo = $result_slice;

        //echo "Displaying $start to $length from original page $page_500; array length: ".count($result['photos']['photo']);

        return json_encode($returnObj);
    }
}

?>