<?php
    session_start();
   /*CREATE fuggveny ami vizsgalja h van e bejelentkezett session?---*/ 
    function bejelentkezve() {
        return isset($_SESSION["username"]);
    }
    /*Connecting to database------------------*/
    $servername = "localhost";                 
  $usernameserver =  "root";                  
  $passwordserver =  "";                  
  $dbname =   "fogyni.hu";                   
  
  /*CONNECTION*/
      $conn = new mysqli($servername, $usernameserver, $passwordserver, $dbname);
    /*GETting DATA from FORM---------------------------*/
    $postEvent = filter_input(INPUT_POST, "event", FILTER_SANITIZE_SPECIAL_CHARS);
    $getEvent = filter_input(INPUT_POST, "event", FILTER_SANITIZE_SPECIAL_CHARS);
   /*HA beléptek------------------------------------------->>>>>*/
    if ($postEvent == "beleptetes") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
  /*ide jon az összehasonlító kód---------------------------------------*/
        $sql = "SELECT username, password FROM felhasznalok WHERE username = '".$username."' AND  password = '".$password."'"; //lekérdező kód
        $result = mysqli_query($conn, $sql);  //végrehajtja a fenti utasitast es beteszi $resultba   
        if (mysqli_num_rows($result) == 1)  {  // ha jo adatokat adott meg akkor 1 lesz a sorok száma
            $_SESSION["username"] = $username;   //kapja a sessiont stb
            $uzenet = "Sikeres belépés! Üdvözlünk kedves $username!";
        } else { // ha rosszak az adatok
            $uzenet = "Sikertelen belépés!";
        }
    } else
    if ($getEvent == "kilepes") {
        unset($_SESSION["username"]);
        $uzenet = "Sikeres kilépés!";
    }
?>
<!DOCTYPE html>

<head>
  <title>Beleptető Rendszer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    .ul {
    list-style-type: none;
    text-decoration: none;
}
    p { color: white; }
</style>
</head>
<body>

    <!-------------------------------Menu---------------------------->
      <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
     
   
    <ul class="nav navbar-nav">
    <!-----------------HA NINCS BEJELENTKEZVE--------------------------------------------->
 <?php
   
    if (!bejelentkezve()) {
 ?>
<!------------------------------------------------------------------------>
 
     <li>  <form method="post" class="navbar-form navbar-left">
      <div class="form-group">
            <input type="text" name="username" placeholder="Felhasználónév" required>
            <input type="password" name="password" placeholder="Jelszó" required>
            <input type="hidden" name="event" value="beleptetes">
            <button>Belépés</button>
        </form> </div></li>
        <li><a href="reg.php">Regisztráció</a></li>
        
<!------------------------------------------------------------------------>
<?php
    }
?>
<!------------------------------------------------------------------------>
        <li style="list-style-type: none; text-decoration: none;"><a href="landingpages/edzeslanding.php">Edzésterv</a></li> 
        <li style="list-style-type: none; text-decoration: none;"><a href="landingpages/etrendlanding.php">Étrendek</a></li>
        <li style="list-style-type: none; text-decoration: none;"><a href="landingpages/eletmodlanding.php">Életmód Tanácsok</a></li>
       
<!-------------------HA BEJELENTKEZVE IGEN----------------------------------------------------->
<?php
        if (bejelentkezve()) {
?>
            <li style="list-style-type: none; text-decoration: none;"><a href="titok.php">Személyes Oldal</a></li>
            <li style="list-style-type: none; text-decoration: none;"><form method="post"><button name="event" value="kilepes">Kilépés</button></form></li>
          <!--  <li><a href="?event=kilepes">Kilépés</a></li> a másik megoldás kilépés gombra-->
          
            <li style="list-style-type: none; text-decoration: none;">
            <?php

if (isset($uzenet)) {
        echo "<p><b>$uzenet</b></p>";
    } ?></li>
<!------------------------------------------------------------------------>
<?php
        }
?>
<!------------------------------------------------------------------------>
    </ul>
     
     </div>
     </div>
</nav>

 <!----
if (isset($uzenet)) {
        echo "<p><b>$uzenet</b></p>";
    } -->
</body>
</html>