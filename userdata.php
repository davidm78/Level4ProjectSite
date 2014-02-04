<?php

$username = $_POST["username"];
$password = hash('sha256', $_POST["password"]); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

	<title> <?php echo $username?>'s Pedometer Site! </title>

	<style>

	#map-canvas {
    	height: 100%;
    	width:1000px;
    	margin: 0px;
    	padding: 0px;
  	}

  	</style>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/starter-template.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">

</head>

<body>

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.html">Pedometer Data</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="./index.html">Home</a></li>
					<li><a href="about.html">About</a></li>
					<li><a href="contact.html">Contact</a></li>
					<li><a href="login.html">Log Out</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>

	<div class="container">

		<div class="starter-template">
			<h1> <?php echo $username ?>'s Walking Information </h1>
			<p class="lead">Welcome <?php echo $username ?>! Here lies all the scary information about your walking HABITS!</p>
			<p class="lead">Your email address is: <?php echo "omgwtfbbq1111111@gmail.com" ?></p>
			<p class="lead"> <?php echo $jsonString ?> </p>
		</div>

		<div id="panel">
			<button onclick="toggleHeatmap()">Toggle Heatmap</button>
			<button onclick="changeGradient()">Change gradient</button>
			<button onclick="changeRadius()">Change radius</button>
			<button onclick="changeOpacity()">Change opacity</button>
			<button onclick="changeDay()">Change day</button>
		</div>
		<div id="map_canvas"></div>

	</div>

	<!-- Javascript Placed at the end of the document so the pages load faster -->

	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=visualization"></script>

	<script type="text/javascript">

	var locationArray = new Array();
    var map, pointarray, heatmap;
    var walkData = [];
    var userName = "<?php echo $username ?>";
    console.log(userName);

    $.ajax({
    	type:"POST",
        url: "http://tethys.dcs.gla.ac.uk/davidsteps/scripts/personalheatmap.php",
        async: false,
        dataType: 'json',
        data: {username: userName},
        success: function(data) {

          for (var i=0; i<data.locationinfo.length; i++)
          {
            var latitude = data.locationinfo[i].Latitude;
            var longitude = data.locationinfo[i].Longitude;
            walkData.push(new google.maps.LatLng(latitude, longitude));
          }

        }
    });

    console.log(walkData.length);

	function initialize() {
      var map_canvas = document.getElementById('map_canvas');
      var map_options = {
        center: new google.maps.LatLng(55.873516, -4.292634),
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.SATELLITE
      }
      var map = new google.maps.Map(map_canvas, map_options);
      var pointArray = new google.maps.MVCArray(walkData);

      heatmap = new google.maps.visualization.HeatmapLayer({
        data: pointArray
      });

      heatmap.setMap(map);
    }

    function toggleHeatmap() {
      heatmap.setMap(heatmap.getMap() ? null : map);
    }

    function changeGradient() {
      var gradient = [
      'rgba(0, 255, 255, 0)',
      'rgba(0, 255, 255, 1)',
      'rgba(0, 191, 255, 1)',
      'rgba(0, 127, 255, 1)',
      'rgba(0, 63, 255, 1)',
      'rgba(0, 0, 255, 1)',
      'rgba(0, 0, 223, 1)',
      'rgba(0, 0, 191, 1)',
      'rgba(0, 0, 159, 1)',
      'rgba(0, 0, 127, 1)',
      'rgba(63, 0, 91, 1)',
      'rgba(127, 0, 63, 1)',
      'rgba(191, 0, 31, 1)',
      'rgba(255, 0, 0, 1)'
      ]
      heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
    }

    function changeRadius() {
      heatmap.set('radius', heatmap.get('radius') ? null : 20);
    }

    function changeOpacity() {
      heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
    }

    function changeDay() {
    	
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>

	</body>
</html>