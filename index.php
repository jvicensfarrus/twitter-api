<!DOCTYPE html>
<!--
Developed by JORDI VICENS FARRUS
Important note: Could not work in the localhost (XAMP/LAMP/WAMP..) so if you have an online site, test it there.
-->
<?php
class Twitter{
    function getTweets($user){
        ini_set('display_errors', 1);
        require_once('TwitterAPIExchange.php'); //This file is a must, you can use it or get it from the original creator: http://github.com/j7mbo/twitter-api-php

        //We set all the tokens and keys for get the access inside the Twitter API(You must fill them if you want to run it successfully).
        $settings = array(
					'oauth_access_token' => "",
					'oauth_access_token_secret' => "",
					'consumer_key' => "",
					'consumer_secret' => ""
				);

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name='.$user.'&count=10';//Here you can change the number of tweets that you will show, in my case, I am showing 10.
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
        $json =  $twitter->setGetfield($getfield)
                         ->buildOauth($url, $requestMethod)
                         ->performRequest();
        return $json;

    }

    function getArrayTweets($jsonraw){
        $rawdata = "";
        $json = json_decode($jsonraw);
        $num_items = count($json);

        //We will create de rawed data
        for($i=0; $i<$num_items; $i++){

            $user = $json[$i];

            $fecha = $user->created_at;
            $url_imagen = $user->user->profile_image_url;
            $screen_name = $user->user->screen_name;
            $tweet = $user->text;

            $imagen = "<a href='https://twitter.com/".$screen_name."' target=_blank><img src=".$url_imagen."></img></a>";
            $name = "<a href='https://twitter.com/".$screen_name."' target=_blank>@".$screen_name."</a>";

            $rawdata[$i][0]=$fecha;
            $rawdata[$i]["Date"]=$fecha;
            $rawdata[$i][1]=$imagen;
            $rawdata[$i]["Image"]=$imagen;
            $rawdata[$i][2]=$name;
            $rawdata[$i]["User"]=$name;
            $rawdata[$i][3]=$tweet;
            $rawdata[$i]["Tweet"]=$tweet;
        }
        return $rawdata;
    }

    function displayTable($rawdata){

        //We will show all the data inside this table.
        echo '<table class="table table-striped">';
        $columnas = count($rawdata[0])/2;
        $filas = count($rawdata);

        //We will print the header of each col
       for($i=1;$i<count($rawdata[0]);$i=$i+2){
            next($rawdata[0]);
            echo "<th class='text-center'><b>".key($rawdata[0])."</b></th>";
            next($rawdata[0]);
        }
        //And then, we will print the rest of the data
        for($i=0;$i<$filas;$i++){
            echo "<tr>";
            for($j=0;$j<$columnas;$j++){
                echo "<td>".$rawdata[$i][$j]."</td>";

            }
            echo "</tr>";
        }
        echo '</table>';
    }
}

 ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>How to use the Twitter API</title>
<!-- Google fonts -->
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600' rel='stylesheet' type='text/css'>
<!-- Bootstrap styles CDN -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="text-align:center;" id="">
				<h1>Twitter API</h1>
				<p>Simple demostration of how to use the twitter API for fetch some tweets.</a></p>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="text-align:center;" id="">
        <?php
          //And then, we will call the functions that we have created and that's it, I hope you will enjoy it.
          $twitterObject = new Twitter();
          $jsonraw =  $twitterObject->getTweets("JordiiVicens");
          $rawdata =  $twitterObject->getArrayTweets($jsonraw);
          $twitterObject->displayTable($rawdata);
         ?>
			</div>
		</div>
	</div>
  <div class="container-fluid footer">
  	<div class="row">
  		<div class="col-md-12 text-center" id="">
  			<p><strong>Designed and developed by <a href="http://www.jordivicensfarrus.com">Jordi Vicens Farrús</a>.</strong></p>
  		</div>
  	</div>
  </div>

<!--  jQuery CDN -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- Bootstrap script CDN -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

</body>
</html>
