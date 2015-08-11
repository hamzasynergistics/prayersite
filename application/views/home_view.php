<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<title>Prayer Time Plugin Website</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
</head>
<body>
	<div id="wrapper">
		<header id="header">
			<div class="time-area">
				<span class="current-time">
					<?php 
					if(empty($data['time'])){					
                                            echo $time = date("h:ia", strtotime('-14 hours'));
//                                            echo $time = date("h:ia", strtotime('+3 hours'));
                                            ?>
                                    <div id="time"></div>
                                    <?php
					}else{
                                            $time = substr($data['time'],'11','8');
                                            echo date('h:i a', strtotime($time));
					}
					?>
				</span>
                                <span class="current-location" id="location"><?php echo $data['loc']; ?></span>
			</div>
			<form class="search-form" action="<?php echo base_url(); ?>index.php/home/search" method="get" >
				<input type="text" name="location" placeholder="City, Country">
				<input type="submit" class="btn btn-primary" value="Search">
			</form>
			<a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/images/logo.png"></a>
		</header>
		<div class="w1">
			<div class="w2">
				<?php if($data['status'] == 1){ ?>
					<div id="main">
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
	</div>
    <?php }else{
        echo 'Location not Found !';
    } ?>
        <div class="method-area">
            <span class="text">Method:</span>
            <?php
            if($data['method'] == 1){
            ?>
                <a href="#" class="popup-open">Egyptian General Org</a>
            <?php
            }
            if($data['method'] == 2){
            ?>
                <a href="#" class="popup-open">University of Islamic Sciences, Karachi (Shafi)</a>
            <?php
            }
            if($data['method'] == 3){
            ?>
                <a href="#" class="popup-open">University of Islamic Sciences, Karachi (Hanfi)</a>
            <?php
            }
             if($data['method'] == 4){
            ?>
                <a href="#" class="popup-open">University Society of North America</a>
            <?php
            }
            if($data['method'] == 6){
            ?>
                <a href="#" class="popup-open">Umm al-Qura</a>
            <?php
            }
            if($data['method'] == 7){
            ?>
                <a href="#" class="popup-open">Fixed Isha</a>
            <?php
            }
            if($data['method'] == 5){
            ?>
                <a href="#" class="popup-open">Muslim World League</a>    
           <?php         
            }
            ?>
        </div>
        <footer id="footer">
            <ul class="social-network">
                <li><a href="#">instagram</a></li>
                <li class="twitter"><a href="#">twitter</a></li>
                <li class="facebook"><a href="#">facebook</a></li>
            </ul>
            <ul class="map-features">
                <li id="btm_lng">Longitude: </li>
                <li id="btm_lat">Latitude: </li>
                <li id="btm_dis">Distance: </li>
                <li>Qibla Direction: <?php echo $data['qibla']; ?> </li>
            </ul>
            <a href="http://synergistics.ae" class="syn-logo"><img src="<?php echo base_url(); ?>assets/images/syn-logo.png"></a>
        </footer>
	</div>
        <div class="popup">
            <div class="inner-popup">
                <h2>Calculation Method</h2>
                <ul class="method-list">
                    <li value="1"><a href="#">Egyptian General Org</a></li>
                    <li value="2"><a href="#">University of Islamic Sciences, Karachi (Shafi)</a></li>
                    <li value="3"><a href="#">University of Islamic Sciences, Karachi (Hanafi)</a></li>
                    <li value="4"><a href="#">University Society of North America</a></li>
                    <li value="5"><a href="#">Muslim World League</a></li>
                    <li value="6"><a href="#">Umm al-Qura</a></li>
                    <li value="7"><a href="#">Fixed Isha</a></li>
                </ul>
                <a href="#" class="btn-close">close</a>
            </div>
        </div>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/rotate.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&zoom=true"></script>
	<script>
                        
		var map;
		function initialize() {
                    var mapOptions = {
                     zoom: 14,
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
                     document.getElementById('btm_lat').textContent = 'Latitude: '+latitude;
                     document.getElementById('btm_lng').textContent = 'Longitude: '+longitude;
//                     document.getElementById('btm_lat').textContent = 'Latitude: '+parseFloat(latitude.toFixed(4));
//                     document.getElementById('btm_lng').textContent = 'Longitude: '+parseFloat(longitude.toFixed(4));
                     
                    updates();
                     
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
                    document.getElementById('btm_dis').textContent = 'Distance: '+dist.toFixed(0)+' km';

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
                
            function updates(){
                    
                var latitude = document.getElementById('latitude').value;
                if(latitude == ''){
                    var delay;
                    delay = setInterval(function () {locate()}, 100);
                    
                    function locate(){
                        var latlng = document.getElementById('latlng').value;
                        var url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + latlng + "&sensor=false";
                        $.getJSON(url, function (data) {
                            var adress = data.results[0].formatted_address;
                            document.getElementById('location').textContent = adress;
                        });   
                                                
                        if(latlng != ''){
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
                                document.getElementById('btm_dis').textContent = 'Distance: '+dist.toFixed(0)+' km';
                            }, 100);
                        }else{
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
                            document.getElementById('btm_dis').textContent = 'Distance: '+dist.toFixed(0)+' km';
                        }
                        clearInterval(delay);
                    }   
                   
                }      
                $(".btn-close").click(function(e){
                        e.preventDefault();
                        $(".popup").hide();
                });
                $(".popup-open").click(function(e){
                        e.preventDefault();
                        $(".popup").show();
                });
                $(".method-list li").click(function(e){
                        e.preventDefault();
                        var loc = $('#location').text();
                        var met = $(this).val();
                        window.location.href = "<?php echo base_url();?>index.php/home/search/?location="+loc+"&method="+met;
//                        $(".popup").hide();
                });
            }
                               
                
	</script>
</body>
</html>