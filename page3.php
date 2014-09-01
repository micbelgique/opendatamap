<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<!-- BASE URL -->
	
	<title>Opendatamap</title>
	
	<!-- META -->
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />	
	

	
	<!-- FAVICON -->	
	<link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico" />	
	
	<!-- STYLESHEETS -->
 	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/structure.css" media="screen" />
	
</head>
<body style="background:url(./img/background.jpg)">
<nav class="navbar navbar-default" role="navigation">
	<img style="margin:2%;float:left;" src="./img/splashpage/opendatamap_logo.png"  class="img-responsive " width="20%" />
	<img style="margin:2%;float:right;" src="./img/texts.png"  class="img-responsive " width="40%" />


</nav>
<form action='' method='post' enctype="multipart/form-data">

<div style="margin-left:10%;margin-left:right; width:80%; height:705px; overflow:scroll; position:">
<?php
function getGeoPosition($address){
    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false" . "&address=" . urlencode($address);

    $json = file_get_contents($url);

    $data = json_decode($json, TRUE);

     if($data['status']=="OK"){
      return $data['results'];
    }

}

include 'reader.php';
$excel = new Spreadsheet_Excel_Reader();

if(isset($_FILES['xls_file'])){
	$_FILES['xls_file']['name'];
	$_FILES['xls_file']['type'];
	$_FILES['xls_file']['size'];
	$_FILES['xls_file']['tmp_name'];
	$_FILES['xls_file']['error'];
	
	$xls_file = "fichiers/".$_FILES['xls_file']['name'];
	$resultat = move_uploaded_file($_FILES['xls_file']['tmp_name'],$xls_file);
	
	if ($_FILES['xls_file']['error'] > 0) { 
		$erreur = "Erreur lors du transfert"; 
		echo "<script>window.location = 'page2.html';</script>";
	}
	
	if ($resultat){
	
    echo "<table class='table table-hover container'>
			<thead>
				<tr>";
	
    $excel->read('fichiers/'.$_FILES['xls_file']['name']);
    $x=1;
	echo "</tr>
		</thead><tbody><tr>";

	for($j = 0;$j < $excel->sheets[0]['numCols']; $j++){
		echo "<td><input type='text' name='datatype".$j."'></td>";$x++;
	}
	echo "</tr>";
	for($i = 0;$i < 19; $i++){
		echo "<tr>";
		$y=1;
		
		while($y<=$excel->sheets[0]['numCols']) {
			$cell = isset($excel->sheets[0]['cells'][$i][$y]) ? $excel->sheets[0]['cells'][$i][$y] : '';
			echo "<td>$cell</td>";
			$y++;
		}
		echo "</tr>";
	}
	echo "</tbody></table>";
}
}

$_SESSION['json'] = "";
if(isset($_POST["file"])){
	$excel->read('fichiers/'.$_POST["file"]);
	for($i = 1;$i < $excel->sheets[0]['numRows']; $i++){ //$excel->sheets[0]['numRows']
		$y=1;
		$json = "";
		while($y<=$excel->sheets[0]['numCols']) {
			$cell_name = isset($excel->sheets[0]['cells'][1][$y]) ? $excel->sheets[0]['cells'][1][$y] : '';
			$cell_data = isset($excel->sheets[0]['cells'][$i+1][$y]) ? $excel->sheets[0]['cells'][$i+1][$y] : '';
			
			if($y != $excel->sheets[0]['numCols']){
				
				if(isset($_POST['datatype'.($y-1)]) && $_POST['datatype'.($y-1)] != ""){
					$json = $json .'"'.utf8_encode($_POST['datatype'.($y-1)]).'": "'.utf8_encode(str_replace('"', "",$cell_data)).'",';
					if($y <= $excel->sheets[0]['numCols'] && $i ==1) $_SESSION['json'] = $_SESSION['json'] . utf8_encode($_POST['datatype'.($y-1)]) . ";";
				}else{
					$json = $json . '"'.utf8_encode($cell_name).'": "'.utf8_encode(str_replace('"', "",$cell_data)).'",';
					if($y <= $excel->sheets[0]['numCols'] && $i ==1) $_SESSION['json'] = $_SESSION['json'] . $cell_name . ";";
				}
				
			}else{
				
				if(isset($_POST['datatype'.($y-1)]) && $_POST['datatype'.($y-1)] != ""){
					$json = $json . '"'.utf8_encode($_POST['datatype'.($y-1)]).'": "'.utf8_encode(str_replace('"', "",$cell_data)).'"';
					if($y <= $excel->sheets[0]['numCols'] && $i ==1) $_SESSION['json'] = $_SESSION['json'] . utf8_encode($_POST['datatype'.($y-1)]) . ";";
				}else{
					$json = $json . '"'.utf8_encode($cell_name).'": "'.utf8_encode(str_replace('"', " ",$cell_data)).'"';
					if($y <= $excel->sheets[0]['numCols'] && $i ==1) $_SESSION['json'] = $_SESSION['json'] . $cell_name . ";";
				}
			}
			
			$y++;
		}
		$json = '{'.$json.'}';

		
		$json_db[$i-1] = $json;
	}
	
	if(!(isset($_SESSION['invite']))){
		$_SESSION['invite'] = rand(25000,900000);
	}

	$data = serialize($json_db);
	
	$monfichier = fopen('json-db/db-'.$_SESSION['invite'].'-1.json', 'w+');
	fwrite($monfichier, $data);
	fclose($monfichier);

	echo "<script>document.location = 'page4.php';</script>";
	
}
?>
</div>
		<div style='margin-left:10%;margin-top:10px;'>
        	<input type="hidden" name="file" id="file" value="<?php  if(isset($_FILES['xls_file'])) { echo $_FILES['xls_file']['name']; } ?>">
			<a href='index.php' ><button type='button' class='btn-lg btn-default openbtn'>retour</button></a>
			<input type='submit' value='Envoyer' class='btn-lg btn-default openbtn'>
		</div>
	</form>
	
</body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/function.jquery.js"></script>

</html>