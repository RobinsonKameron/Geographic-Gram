<?php
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
if (!empty($_GET['location'])){
    /**
     * Here we build the url we'll be using to access the google maps api
     */
    $maps_url = 'http://'.
        'maps.googleapis.com/'.
        'maps/api/geocode/json'.
        '?address=' . urlencode($_GET['location']);
    $maps_json = file_get_contents($maps_url);
    $maps_array = json_decode($maps_json, true);
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];
//Check longitude and latitude
    //echo "          ".$lat . "and " . $lng;
    /**IG PASS*/
    $instagram_url = 'https://'.
        'api.instagram.com/v1/media/search' .
        '?lat=' . $lat .
        '&lng=' . $lng .
        '&client_id=602a6dfff44543d8974577c885e95329'; //CLIENT-ID
    $instagram_json = file_get_contents($instagram_url, false, stream_context_create($arrContextOptions));
    $instagram_array = json_decode($instagram_json, true);
    //echo $instagram_array;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Geographic Gram</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/bigPicture.js"></script>
    <link href="Stylesheet.css" rel="stylesheet" />
    <title>geogram</title>
</head>
<body>
    <div class="dropdown-backdrop" class="img">
<body background="//t1.gstatic.com/images?q=tbn:ANd9GcQiUb98WB_9LpeUkP07Gp1PyId8rHa3lH6LSYJOMactYhYkUTCiM5TypOg0ZA">
</div>
<!-- Navigation bar -->
<div class = "navbar navbar-default navbar-static-top">
    <div class="container">
        <a href="#" class = "navbar-brand">Geographic Gram</a>
        <button class="navbar-toggle" data-toggle ="collapse" data-target = ".navHeaderCollapse">
            <span class ="icon-bar"></span>
            <span class ="icon-bar"></span>
            <span class ="icon-bar"></span>
        </button>
        <div class = "collapse navbar-collapse navHeaderCollapse">
            <ul class = "nav navbar-nav navbar-right">
                <form action="">
                    <br>
                    <input type="text" name="location"/>
                    <button type="submit">Search!</button>
                </form>
            </ul>
        </div>
    </div>
</div>
<!--End Nav bar-->
<div align="center">
    <h2 class="main-text"><mark>Search for a place to see the instagram feed by location</mark></h2>
</div>
<div class="container">
    <div class="row">
            <?php
            if(!empty($instagram_array)){
                foreach($instagram_array['data'] as $key=>$image){
                    echo '<div class="col-sm-4 col-sm-6 col-xs-12"><img src="'.$image['images']['low_resolution']['url'].'" alt=""/><br/><br/><br/></div>';
                            }
                        }
            ?>
        
    </div>
</div>
</body>
</html>
