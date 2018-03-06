<?php
session_start();

$servername = "localhost";                 //"";
$usernameserver = "";                  //"";
$passwordserver = "";                  //"";
$dbname = "";                   //"";

/* CONNECTION */
$conn = new mysqli($servername, $usernameserver, $passwordserver, $dbname);
$username = $_SESSION['username'];
/* -----------itt iratjuk ki az adatokat SELECTel---- */
$sql = "SELECT name, email, age, weight, height FROM fogyni_reg WHERE username = '" . $_SESSION["username"] . "'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row["name"];
        $email = $row["email"];
        $age = $row["age"];
        $weight = $row["weight"];
        $height = $row["height"];
    }
}
/* ------------------------------Itt kezdődik a képfeltöltés logikája rész---------------------------- */
if (isset($_POST['kepfeltoltes'])) {

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $dirname = $username;
    $foldername = //directory URL     //a vizsgálandó mappa az uploads-on belül a felhasználónévvel azonos mappa


    $fileExt = explode('.', $fileName);        //szĂ©tvĂˇlasztjuk a fĂˇjlnevet a "." karakternĂ©l, 
    $fileActualExt = strtolower(end($fileExt));   //kis betĹ±kre ĂˇllĂ­tjuk a nagy betĹ±ket

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');     //engedĂ©lyezett fĂˇjlformĂˇtumok tĂ¶mbje
    if (in_array($fileActualExt, $allowed)) {    //ha a kiterjesztĂ©s benne van a megengedett tĂ¶mbbe
        if ($fileError === 0) { //Ă©s a feltĂ¶ltĂ©snĂ©l hibĂˇk szĂˇma = 0
            if ($fileSize < 7000000000000) { //Ă©s ha a mĂ©rete kisebb mint 7MB
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;    //kap egy Ăşj egyedi nevet 
                /* ide a php rész-------------------------------------------------- */
                if (!file_exists($foldername)) {    //ha a mappa nem létezik
                    mkdir($foldername);
                    $fileDestination = $foldername . '/' . $fileNameNew;  //a fájl útvonala: egy új, a felhasználónévvel aznos nevű mappa
                } else {
                    $fileDestination = $foldername . '/' . $fileNameNew;
                }
                /* idáig------------------------------------------------------------ */
                //  $fileDestination = 'uploads/' . $fileNameNew;    //mkdir("uploads/$username");ide mentjĂĽk
                move_uploaded_file($fileTmpName, $fileDestination);  //ĂˇthelyezzĂĽk az Ăˇtmeneti mappĂˇbĂłl az uploadsba
                echo "successful";
            } else {
                echo "Your file is too big to upload";
            }
        } else {
            echo "You cannot upload file this type because of 0!";
        }
    } else {
        echo "You cannot upload file this type because of allowed!";
    }
}
/* idáig------- */
?> 
<!DOCTYPE html>

<head>
    <title>Személyes oldal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron" style="background-image: url(../pic/hatter.jpg);">
            <h1>Üdvözlünk kedves <?php @print $username; ?></h1> 
            <p>Ez itt a személyes oldalad, ahol megváltoztathatod adataid.</p> 
        </div>
        <img src="user.png" style="border: solid 1px black; width: 100px; height: 100px;" class="img-circle" alt="Profilkép">

        <form method="post" enctype="multipart/form-data">
            <p>Tölts fel profilképet!</p>
            <input type="file" name="file" id="file">
            <input type="hidden" value="kepfeltoltes" name="kepfeltoltes">
            <button class="btn btn-primary" value="submit" name="submit">Feltöltés</button>    
        </form>
        <!-- - - - - - - - - - - - - - DATA DISPLAY- - - - - - - - - - - - - - -->
        <?php
        $changeView = filter_input(INPUT_POST, "changeView", FILTER_SANITIZE_SPECIAL_CHARS);
        if ($changeView !== "change") {
            ?>

            <p> E-mail címed: <?php @print $email; ?></p>
            <p> Életkorod: <?php @print $age; ?></p>
            <p> Magasságod: <?php @print $height; ?></p>
            <p> TestSúlyod: <?php @print $weight; ?></p>


            <form method="post">
                <input type="hidden" name="changeView" value="change">
                <button class="btn btn-primary" value="submit" name="submit">Adatok módosítása</button>
            </form> 
            <!-- - - - - - - - - - - - - - DATA EDIT FORM- - - - - - - - - - - - - - -->
            <?php
        } elseif ($changeView === "change") {
            ?>
            <form method="post">

                <input type="text" class="form-control" name="name" placeholder="Név megváltoztatása"><br>
                <input type="text" class="form-control" name="username" placeholder="Felhasználónév megváltoztatása"><br>
                <input type="password" class="form-control" name="password" placeholder="Jelszó megváltoztatása"> <br>
                <input type="password" class="form-control" name="password2" placeholder="Jelszó mégegyszer"><br> <!----majd csináld meg h csak akkor engedje tovább ha egyenlő---->
                <input type="email" class="form-control" name="email" placeholder="E-mail cím megváltoztatása"><br>
                <input type="number" class="form-control" name="age" placeholder="Életkor"><br>
                <input type="number" class="form-control" name="weight" placeholder="Súly megváltoztatása"><br>
                <input type="number" class="form-control" name="height" placeholder="Magasság megváltoztatása"><br>
                <input type="hidden" value="savingedited" name="saveEdit">
                <input type="submit" name="submit" value="submit">
            </form>
            <?php
        }
        $saveEdit = filter_input(INPUT_POST, "saveEdit", FILTER_SANITIZE_SPECIAL_CHARS);
        
               
            if ($saveEdit === "savingedited") {
        
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
            $password2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_SPECIAL_CHARS);
            $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_SPECIAL_CHARS);
            $weight = filter_input(INPUT_POST, "weight", FILTER_SANITIZE_SPECIAL_CHARS);
            $height = filter_input(INPUT_POST, "height", FILTER_SANITIZE_SPECIAL_CHARS);
            /* ha valaminek lett érték adva----- */
            if (isset($name) or isset($email) or isset($password) or isset($password2) or isset($age) or isset($weight) or isset($height)) {
                
                    //és ha a 2 jelszó egyenlő
                
                    $sql = "UPDATE fogyni_reg SET name = '$name', email = '$email', password = '$password', password2 = '$password2', age = '$age', weight = '$weight', height = '$height' WHERE username = '" . $_SESSION["username"] . "'";
                    $result = mysqli_query($conn, $sql);
                    mysqli_commit($conn);
                    if (isset($result)) {
                        header("Location: titok.php");
                    } else {
                        echo "nem sikerült módosítani";
                    }
                
            }
        }
        
                ?>
        <a href="http://fogyniakarokkozosseg.hu/"><button class="btn btn-warning">vissza</button></a>
    </div>
    <!-- - - - - - - - - FOOTER - - - - - - - -  - - - - - - - -->
    <footer style="width: 100%; height: 200px; margin-top: 10px;
            margin-bottom: 0px;
            text-align: center;
            color: white;
            background-color: black; 
            ">
        <h1 style="font-size: 60px;" >by Martin Miklós</h1>                      
        <p>for web-development service, please contact <a href="mailto:meanwhilecapital@gmail.com?Subject=Hello%20again" target="_top">meanwhilecapital@gmail.com</a> 
    </footer>
</body>
</html>
