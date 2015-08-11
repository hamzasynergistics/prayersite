<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<title>Prayer Time Plugin Website</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
</head>
<body>
	<header id="header">
		<a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/images/logo.jpg"></a>
		<form class="search-form" action="<?php echo base_url(); ?>index.php/home/search" method="get" >
                    <input type="text" name="location" id="location" placeholder="City, Country" value="<?php echo $data['loc']; ?>">
			<input type="submit" class="btn btn-primary" value="Search">
		</form>
		<ul class="social-network">
			<li><a href="#">facebook</a></li>
			<li class="twitter"><a href="#">twitter</a></li>
		</ul>
	</header>
	<?php if($data['status'] == 1){ ?>
		<div id="main">
			<div class="main-wrap">
				<span class="current-time">Current Time: 
                                    <?php 
                                    if(empty($data['time'])){
//                                        echo $time = date("h:i", strtotime('-2 hours'));
                                        echo $time = date("h:ia", strtotime('+3 hours'));
                                    }else{
                                        $time = substr($data['time'],'11','8');
                                        echo date('h:i a', strtotime($time));
                                    }
                                    ?>
                                </span>
				<img src="<?php echo base_url(); ?>assets/images/bg-main.png" class="main-img">
				<div class="map">
                                    <div id="map-canvas"></div>
                                    <div id="compass"></div>
				</div>
				<ul class="left-menu">
                                    <li>
                                        <input type="hidden" id="latlng" value="">
                                        <input type="hidden" id="latitude" value="<?php echo $data['lat']; ?>">
                                        <input type="hidden" id="longitude" value="<?php echo $data['long']; ?>">
                                        <span class="prayer-name">Fajr</span>
                                        <span class="fajr-time"><?php echo date("h:i a", strtotime($data['fajr'])); ?></span>
                                    </li>
                                    <li>
                                        <span class="prayer-name">Shurooq</span>
                                        <span class="shurooq-time"><?php echo date("h:i a", strtotime($data['shurooq'])); ?></span>
                                    </li>
                                    <li>
                                        <span class="prayer-name">Dhuhr</span>
                                        <span class="dhuhr-time"><?php echo date("h:i a", strtotime($data['dhuhr'])); ?></span>
                                    </li>
				</ul>
				<ul class="right-menu">
                                    <li>
                                        <span class="prayer-name">Asr</span>
                                        <span class="asr-time"><?php echo date("h:i a", strtotime($data['asr'])); ?></span>
                                    </li>
                                    <li>
                                        <span class="prayer-name">Magrib</span>
                                        <span class="maghrib-time"><?php echo date("h:i a", strtotime($data['maghrib'])-150); ?></span>
                                    </li>
                                    <li>
                                        <span class="prayer-name">Isha</span>
                                        <span class="isha-time"><?php echo date("h:i a", strtotime($data['isha'])); ?></span>
                                    </li>
				</ul>
			</div>
		</div>
    
    <?php }else{
        echo 'Location not Found !';
    } ?>
	<footer id="footer">
		<ul class="map-features">
			<li>
                            <span class="func-name">Latitude</span>
                            <span class="func-value" id="btm_lat"><?php echo $data['lat']; ?></span>
			</li>
			<li>
                            <span class="func-name">Longitude</span>
                            <span class="func-value" id="btm_lng"><?php echo $data['long']; ?></span>
			</li>
			<li>
                            <span class="func-name">Qibla Direction</span>
                            <span class="func-value"><?php echo $data['qibla']; ?></span>
			</li>
			<li>
                            <span class="func-name">Distance</span>
                            <span class="func-value" id="btm_dis"></span>
			</li>
		</ul>
		<span class="copyright"><?php echo date("Y"); ?> Synergistics FZ LLC &copy; All rights reserved.</span>
	</footer>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/rotate.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&zoom=true"></script>
	<script>
		var map;
		function initialize() {
                    var mapOptions = {
                     zoom: 16,
                     scrollwheel: false,
                     scaleControl: false,
                     draggable: false,
                     mapTypeControl: false,
                     zoomControl: false,
                     streetViewControl: false
                    };
                    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                    if(navigator.geolocation) {
                     navigator.geolocation.getCurrentPosition(function(position) {

                     var lat = document.getElementById('latitude').value;
                     var lng = document.getElementById('longitude').value;
                     if(lat == ''){
                          latitude = position.coords.latitude;
                          longitude = position.coords.longitude;
                     }else{
                          latitude = lat;
                          longitude = lng;
                     }
                     document.getElementById('latlng').value = latitude+','+longitude;
                     document.getElementById('btm_lat').textContent = latitude;
                     document.getElementById('btm_lng').textContent = longitude;

                      var pos = new google.maps.LatLng(latitude,longitude); 

                          map.setCenter(pos);
                     }, function() {
                          handleNoGeolocation(true);
                     });                      
                     
                    } else {
                     handleNoGeolocation(false);
                    }                   
		}
		google.maps.event.addDomListener(window, 'load', initialize);
                
	  </script>
	<script type="text/javascript">
		$("#compass").rotate(<?php echo $data['qibla'] ?>);
                               
                var latitude = document.getElementById('latitude').value;
                if(latitude == ''){
                    var delay;
                    delay = setInterval(function () {locate()}, 100);
                    
                    function locate(){
                        var latlng = document.getElementById('latlng').value;
                        var url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + latlng + "&sensor=false";
                        $.getJSON(url, function (data) {
                            var adress = data.results[0].formatted_address;
                            document.getElementById('location').value = adress;
                        });   
                        
                        setTimeout(function(){ 
                            var latlng = document.getElementById('latlng').value;
                            var data = latlng.split(',');
                            var lat = data[0];
                            var lng = data[1];

                            var radlat1 = Math.PI * lat/180;
                            var radlat2 = Math.PI * 21.4228714/180;
                            var radlon1 = Math.PI * lng/180;
                            var radlon2 = Math.PI * 39.8257347/180;
                            var theta = lng-39.8257347;
                            var radtheta = Math.PI * theta/180;
                            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                            dist = Math.acos(dist);
                            dist = dist * 180/Math.PI
                            dist = dist * 60 * 1.1515;
                            dist = dist * 1.609344; 
                            document.getElementById('btm_dis').textContent = Math.round(dist);
                        }, 400);
                        
                        clearInterval(delay);
                    }   
                }else{
                    var delay;
                    delay = setInterval(function () {distance()}, 400);
                    function distance() {
                        var latlng = document.getElementById('latlng').value;
                        var data = latlng.split(',');
                        var lat = data[0];
                        var lng = data[1];

                        var radlat1 = Math.PI * lat/180;
                        var radlat2 = Math.PI * 21.4220/180;
                        var radlon1 = Math.PI * lng/180;
                        var radlon2 = Math.PI * 39.8260/180;
                        var theta = lng-39.8260;
                        var radtheta = Math.PI * theta/180;
                        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                        dist = Math.acos(dist);
                        dist = dist * 180/Math.PI
                        dist = dist * 60 * 1.1515;
                        dist = dist * 1.609344; 
                        document.getElementById('btm_dis').textContent = Math.round(dist);
                        clearInterval(delay);                   
                    }   
                }
	</script>
</body>
</html>