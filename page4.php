<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<!-- BASE URL -->
	
	<title>Opendatamap</title>
	
	<!-- META -->
    <!-- <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />	 -->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />	
	

	
	<!-- FAVICON -->	
	<link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico" />	
	
	<!-- STYLESHEETS -->
 	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/structure.css" media="screen" />
	
</head>
<body>

<div id="background"><img src="./img/background.jpg" id="bg"/></div>

<nav class="navbar navbar-default" role="navigation">
	<img style="margin:2%;float:left;" src="./img/splashpage/opendatamap_logo.png"  class="img-responsive " width="20%" />
	<img style="margin:2%;float:right;" src="./img/texts.png"  class="img-responsive " width="40%" />


    <div class="collapse navbar-collapse navbaropen" style="float:left;margin:2%;" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">Accueil</a></li>
        <li class="active"><a href="#">map</a></li>
        <li><a href="#">contribuer</a></li>
        <li><a href="#">presse</a></li>
        <li><a href="#">contact</a></li>
    </ul>
	</div>
</nav>
<div id="centerBlock2">
    <div class="row" >
      <div class="col-xs-6 col-md-3" >
      	<input style="width:74%; margin-bottom:2%;" type="text" class="form-control" placeholder="Rechercher...">

<div class="btn-group">
  <button class="btn btn-default btn-sm dropdown-toggle btnopendrop" type="button" data-toggle="dropdown">
    Sante <span class="caret"></span>
  </button>
<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu3">
  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Regular link</a></li>
  <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#">Disabled link</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another link</a></li>
</ul>
</div>
<div class="btn-group">
  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
    popular <span class="caret"></span>
  </button>
<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu3">
  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Regular link</a></li>
  <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#">Disabled link</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another link</a></li>
</ul>
</div>
<div class="btn-group">
  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
    Sett. Map <span class="caret"></span>
  </button>
<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu3">
  <li role="presentation"><a role="menuitem" tabindex="-1" onclick="toggleHeatmap_0()">Ajouter/Supprimer</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" onclick="changeGradient_0()">Change gradient</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" onclick="changeRadius_0()">Change radiusk</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" onclick="changeOpacity_0()">Change opacity</a></li>
</ul>
</div>
	<?php 
		if(file_exists("json-db/db-".$_SESSION['invite']."-1.json")){
			$json = file_get_contents("json-db/db-".$_SESSION['invite']."-1.json");
		}
		
		$json = unserialize($json);
		
		//print_r($json[0]);
	?>
<div class="table-responsive" style="height:500px;overflow-x:hidden;">
    <table class="table table-striped " style=" min-height:500px;">

        <tbody>
        <?php
			$i=0;
			foreach($json as $row){
				$arr[] = json_decode($row)->{'type'};
			}
			$arrayfromjson = array_unique($arr);
			foreach($arrayfromjson as $row){
				$i++;
				echo '<tr>
						<td class="col-xs-12 col-xs-6 col-sm-3"  style="font-size:1.4em; height:50px;">'.$row.'</td>   
						<td class="col-xs-12 col-xs-6 col-sm-1" >
							<a  onclick="toggleHeatmap_'.$i.'()" style="float:right;"><img src="./img/map_page/ajouter.png" id="imageid_'.$i.'" /></a>
							<br><br>
							<div class="btn-group">
							  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="margin-left:30px;"> Paramètre <span class="caret"></span>
							  </button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu3">
							  <li role="presentation"><a role="menuitem" tabindex="-1" onclick="changeGradient_'.$i.'()">Change gradient</a></li>
							  <li role="presentation"><a role="menuitem" tabindex="-1" onclick="changeRadius_'.$i.'()">Change radiusk</a></li>
							  <li role="presentation"><a role="menuitem" tabindex="-1" onclick="changeOpacity_'.$i.'()">Change opacity</a></li>
							</ul>
							</div>
						</td>
					</tr>';
			}
		?>
        </tbody>
    </table>
</div>

</div>
	  <?php
	  	echo '<a href="json-db/db-'.$_SESSION['invite'].'-1.json" target="_blank">Télécharger votre Json ici.</a>';
	  ?>
      <div class="col-xs-12 col-sm-6 col-md-9" style="min-height:570px;" id="map-canvas">google map<br><br><br></div>
      
    </div>
      <div class="col-xs-12 col-xs-6 col-sm-2" style="color:#23bbd2;"><a href="page2.php">+ Ajouter un fichier</a><br><br><br></div>
      <div class="col-xs-12 col-xs-6 col-sm-1" ><br><br><br></div>
      <!--<div class="col-xs-12 col-xs-6 col-sm-3" >
        <h4 style="color:white; margin:0; padding:0;">actifs:</h4>
        <div style="background-color: #808080;height:60px;padding:2%;color:white; ">
          <p style="float:left; width:20%;"><img src="./img/map_page/delete30.png" height="30"/></p>
          <p style="float:left;margin:0;padding:0; width:60%;font-size:1.4em;">Pharmacies<br><span style="font-size:0.7em;">(Association de pharmaciens)</span></p>
          <div style="float:right; width:20%;" class="onoffswitch">
              <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
              <label class="onoffswitch-label" for="myonoffswitch">
                  <span class="onoffswitch-inner"></span>
                  <span class="onoffswitch-switch"></span>
              </label>
          </div>
        </div>--></div>


    
    <?php
		/*echo $_SESSION['json'];
	
		$i=0;
		foreach($json as $row){
			$arr[] = json_decode($row)->{'type'};
		}
		$arrayfromjson = array_unique($arr);
		foreach($arrayfromjson as $row){
			echo  $row."<br>";
		}
		*/
	?>
    
</div>  
</body>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/function.jquery.js"></script>
    
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization"></script>
    <script>
	// Adding 500 Data Points
	var map, pointarray, heatmap;

	var all_location = [
	<?php
		$i=0;
		foreach($json as $row){
			echo "new google.maps.LatLng(".json_decode($json[$i])->{'lat'}.", ".json_decode($json[$i])->{'long'}."),";
			$i++;
		}
	?>
	];
	
	
	var overlay_1 = [ // à bouclé
	<?php
		$i=0;
		foreach($json as $row){
			if(json_decode($json[$i])->{'type'} == 'Commune'){
			echo "new google.maps.LatLng(".json_decode($json[$i])->{'lat'}.", ".json_decode($json[$i])->{'long'}."),";
			}
			$i++;
		}
	?>
	];
	
	var overlay_2 = [ // à bouclé
	<?php
		$i=0;
		foreach($json as $row){
			if(json_decode($json[$i])->{'type'} == 'C.P.A.S.'){
			echo "new google.maps.LatLng(".json_decode($json[$i])->{'lat'}.", ".json_decode($json[$i])->{'long'}."),";
			}
			$i++;
		}
	?>
	];

	function initialize() {
	  var mapOptions = {
		zoom: 8,
		center: new google.maps.LatLng(50.6246401, 5.5990901),
		mapTypeId: google.maps.MapTypeId.SATELLITE
	  };
	
	  map = new google.maps.Map(document.getElementById('map-canvas'),
		  mapOptions);
	
	  var pointArray_0 = new google.maps.MVCArray(all_location);
	  var pointArray_1 = new google.maps.MVCArray(overlay_1);// à bouclé
	  var pointArray_2 = new google.maps.MVCArray(overlay_2);// à bouclé
	  
	
	  heatmap_0 = new google.maps.visualization.HeatmapLayer({
		data: pointArray_0
	  });
	  
	  heatmap_1 = new google.maps.visualization.HeatmapLayer({// à bouclé
		data: pointArray_1
	  });
	  
	  heatmap_2 = new google.maps.visualization.HeatmapLayer({// à bouclé
		data: pointArray_2
	  });
	  
	  
	  /*heatmap_0.setMap(map);
	  heatmap_1.setMap(map);// à bouclé
	  heatmap_2.setMap(map);// à bouclé*/

	}

	function toggleHeatmap_0() {
	  heatmap_0.setMap(heatmap_0.getMap() ? null : map);
	}
	
	var clic = 0;
	function toggleHeatmap_1() {
	  heatmap_1.setMap(heatmap_1.getMap() ? null : map);
	  if(clic == 0){ document.getElementById("imageid_1").src="./img/map_page/suppr.png"; clic = 1;
	  }else{ document.getElementById("imageid_1").src="./img/map_page/ajouter.png"; clic = 0; }
	}
	
	function toggleHeatmap_2() {
	  heatmap_2.setMap(heatmap_2.getMap() ? null : map);
	  if(clic == 0){ document.getElementById("imageid_2").src="./img/map_page/suppr.png"; clic = 1;
	  }else{ document.getElementById("imageid_2").src="./img/map_page/ajouter.png"; clic = 0; }
	}
	
	
	function changeGradient_0() { // couleurs bleu -> rouge
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
	  heatmap_0.set('gradient', heatmap_0.get('gradient') ? null : gradient);
	}
	
	function changeGradient_1() { // couleurs bleu -> rouge
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
	  heatmap_1.set('gradient', heatmap_1.get('gradient') ? null : gradient);
	}
	
	function changeGradient_2() { // couleurs bleu -> rouge
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
	  heatmap_2.set('gradient', heatmap_2.get('gradient') ? null : gradient);
	}

	function changeRadius_0() {
	  heatmap_0.set('radius', heatmap_0.get('radius') ? null : 50);
	}
	function changeRadius_1() {
	  heatmap_1.set('radius', heatmap_1.get('radius') ? null : 50);
	}
	function changeRadius_2() {
	  heatmap_2.set('radius', heatmap_2.get('radius') ? null : 50);
	}
	
	function changeOpacity_0() {
	  heatmap_0.set('opacity', heatmap_0.get('opacity') ? null : 0.2);
	}
	
	function changeOpacity_1() {
	  heatmap_1.set('opacity', heatmap_1.get('opacity') ? null : 0.2);
	}
	
	function changeOpacity_2() {
	  heatmap_2.set('opacity', heatmap_2.get('opacity') ? null : 0.2);
	}
	
	
	google.maps.event.addDomListener(window, 'load', initialize);

    </script>


</html>