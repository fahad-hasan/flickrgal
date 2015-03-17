<?php
load_view('header');

$page = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1;
$query = (isset($_GET['q']) && !empty($_GET['q'])) ? $_GET['q'] : "";

//Cleaning up the query string
$query = htmlspecialchars(strip_tags($query));
$query = str_replace('"', "", $query);
$query = str_replace("'", "", $query);
//print_r($_SESSION['flickrgal_cache']);
?>

<div class="container">
    <form method="GET" action="?page=1">
        <input name="q" type="text" placeholder="Search..." value="<?php echo $query; ?>" />
        <input type="submit" value="GO" />
    </form>
<?php
if (!empty($query)) {
    $flickrgal = new gallary;
    $data = $flickrgal->searchFlickr($query, $page);
    $data = json_decode($data);
    //print_r($data);
?>
    <div class="pagination">
        <?php
        $cur_page = $data->photos->page;
        $total_pages = $data->photos->pages;
        $previous = ($cur_page - 1) <= 0 ? "#" : '?q='.$query.'&page='.($cur_page - 1);
        $next = ($cur_page + 1) > $total_pages ? "#" : '?q='.$query.'&page='.($cur_page + 1);
        $first = $cur_page > 1 ? '?q='.$query.'&page=1' : "#";
        $last = $cur_page < $total_pages ? '?q='.$query.'&page='.$total_pages : "#";

        $show_prev = $previous == "#" ? "display:none;" : "";
        $show_next = $next == "#" ? "display:none;" : "";
        $show_first = $first == "#" ? "display:none;" : "";
        $show_last = $last == "#" ? "display:none;" : "";
        ?>
        <p>Search for <strong><?php echo $query; ?></strong> returned <?php echo $data->photos->total; ?> photos</p>
        <?php
        if ($data->photos->total > 0) {
            ?>
            <span>Displaying <?php echo $cur_page; ?> of <?php echo $total_pages; ?> pages</span>
            <a style="<?php echo $show_last ?>" class="last" href="<?php echo $last; ?>">Last</a>
            <a style="<?php echo $show_next ?>" class="next" href="<?php echo $next; ?>">Next</a>
            <a style="<?php echo $show_prev ?>" class="prev" href="<?php echo $previous; ?>">Prev</a>
            <a style="<?php echo $show_first ?>" class="first" href="<?php echo $first; ?>">First</a>
            <?php
        }
        ?>
    </div>
    <div class="gallery">
        <ul>
            <?php
            foreach($data->photos->photo as $photo) {
                //Thumbnail URL
                //http://farm{farm-id}.static.flickr.com/{server-id}/{id}_{secret}_t.jpg
                $original = 'http://farm' . $photo->farm . '.static.flickr.com/' . $photo->server . '/' . $photo->id . '_' . $photo->secret . '_b.jpg';
                if (property_exists($photo, 'originalsecret') && property_exists($photo, 'originalformat')) {
                    $original = 'http://farm' . $photo->farm . '.static.flickr.com/' . $photo->server . '/' . $photo->id . '_' . $photo->originalsecret . '_o.'.$photo->originalformat;
                }
                echo '<li><a title="Click to open large image in new window" target="_blank" href="'.$original.'"><img src="http://farm' . $photo->farm . '.static.flickr.com/' . $photo->server . '/' . $photo->id . '_' . $photo->secret . '_t.jpg"></a></li>';
            }
            ?>
        </ul>
    </div>
<?php
}
?>
</div>

<?php
load_view('footer');
?>