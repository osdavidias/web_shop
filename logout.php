<?php
session_start();
unset($_SESSION["user"]);
unset($_SESSION["pass"]);
echo '<h2>Odlogirali ste se!</h2>';

header('Refresh: 2; URL = index.php');



?>