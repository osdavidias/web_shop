<!DOCTYPE html>
<html>
<head>

<title>Web shop</title>
<meta name="description" content="Web shop trgovina">
<meta name="keywords" content="Web shop, trgovina, kupovina, odjeća">
<meta charset="UTF-8">
  
<link rel="stylesheet" type="text/css" href="stil.css">	
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
 function initialize() {
   var mapProp = {
     center:new google.maps.LatLng(45.5511100, 18.6938900),
     zoom:14,
     mapTypeId:google.maps.MapTypeId.ROADMAP
   };
   var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
 }
 google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<ul style="float:right;list-style-type:none;">
    <li><a href="registracija.php">Registracija</a></li>
    <li><a href="login.php">Login</a></li>
    <br><li><a href="kosarica.php"><b>Košarica</b></a></li>
  </ul>
</ul>
<h1 align="center">WEB SHOP TRGOVINA</h1>
   <nav>
   <a href="index.php">Početna</a> |
   <a href="onama.php">O nama</a>  |
   <a href="gdjesmo.php">Gdje smo</a> |
 </nav>
 <?php
session_start();
 ?>
<h2>Kontakt:</h2>
<b>tel: 05642334343
<br>email: webshop@webshop.hr
</b>

<h2>Naša lokacija:</h2>


<br>	
<div id="googleMap" style="width:500px;height:380px;"></div>

<div align="center"><footer>© Web Shop Trgovina </footer></div>
</body>

</html> 