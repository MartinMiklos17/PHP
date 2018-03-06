 <?php 
  session_start();
 ?> 
<!DOCTYPE html>

<head>
  <title>Regisztrációs Űrlap</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<!----------------------------Ide jön a php rész---------------->
<?php 
  $servername = "localhost";                 //"";
  $username =  "";                  //"";
  $password =  "";                  //"";
  $dbname =   "";                   //"";
  
  /*CONNECTION*/
  $conn = new mysqli($servername, $username, $password, $dbname);
  
 /*CHECK*/
  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);  } 
  
  // Change character set to utf8
  mysqli_set_charset($conn,"utf8");
  
  /*Getting DATA from FORM  with PROTECT aganist Mysql Injections*/                               
   $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
   $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
   $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
   $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
   $password2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_SPECIAL_CHARS);
   $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_SPECIAL_CHARS);
   $weight = filter_input(INPUT_POST, "weight", FILTER_SANITIZE_SPECIAL_CHARS);
   $height = filter_input(INPUT_POST, "height", FILTER_SANITIZE_SPECIAL_CHARS);
 
  /*INSERTING to SQL Database--------------*/
  $sql = "INSERT INTO table (name, username, password, password2, email, age, weight, height)
  VALUES ('$name', '$username', '$password', '$password2', '$email', '$age', '$weight', '$height')"; 
  
  /*CHECK INSERTing success--------*/
  if ($conn->query($sql) === TRUE) {
  /*header("refresh:0;url=http://www.fogyniakarokkozosseg.hu/redirect.php");*/
  $_SESSION["username"] = $username;
  } else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  }
?>
                                                    

<!----------------------------Ide jön a php rész---------------->
               
  

             
              <div class="col-lg-4"></div>
              <div class="col-lg-4"> 

            <div class="alert alert-info">
             <div class="well"><h1>Csatlakozz hozzánk!</h1></div>    
            <form method="post">
              <div class="form-group text-center">
                <input type="text" class="form-control" name="name" placeholder="Név" required><br>
                <input type="text" class="form-control" name="username" placeholder="Felhasználónév" required><br>
                <input type="password" class="form-control" name="password" placeholder="Jelszó" required> <br>
                <input type="password" class="form-control" name="password2" placeholder="Jelszó mégegyszer" required><br> <!----majd csináld meg h csak akkor engedje tovább ha egyenlő---->
                <input type="email" class="form-control" name="email" placeholder="E-mail cím" required><br>
                <input type="number" class="form-control" name="age" placeholder="Életkor"><br>
                <input type="number" class="form-control" name="weight" placeholder="Súly"><br>
                <input type="number" class="form-control" name="height" placeholder="Magasság"><br>
                <input type="hidden" name="event" value="reg">
            <!--    <div class="g-recaptcha" language="hu" data-sitekey="6Ld55w8TAAAAANrltHdhGC-RsSlKyDPls-QWWvhN"></div>
               <!-- <input type="hidden" name="event" value="beleptetes"> ez nem fog kelleni mert csak regisztrálni kell-->
                <button class="btn btn-success">Regisztráció</button>
                
                </div>
               </form>
              <a href="http://www.fogyniakarokkozosseg.hu/"><button class="btn btn-warning">Vissza</button></a>
             </div>
            </div>
           <div class="col-lg-4">
           <?php
            $postEvent = filter_input(INPUT_POST, "event", FILTER_SANITIZE_SPECIAL_CHARS);
            if ($postEvent == "reg") {
               
            ?>
           <div class="alert alert-success"> 
           <h2>Sikeres Regisztráció</h2><br>
           </div>
           <h2>Üdvözlünk a Fogyni.hu Közösségében Kedves <b><?php echo $username ?></b> !</h2><br>
           <a href="http://www.fogyniakarokkozosseg.hu/"><button class="btn btn-warning">Vissza</button></a>
           <a href="titok.php"><button class="btn btn-info">Személyes Oldal</button></a>
           <?php
            }
            else {
            ?>
           <div class="alert alert-warning">
           <h2>Kérjük Töltsd Ki Helyesen Az Űrlapot!</h2> 
           </div>
           <?php
            }
           ?>
           </div>
           
            
</body>
</html>
