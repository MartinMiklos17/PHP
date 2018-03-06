<?php
session_start();
$username = $_SESSION['username'];


if (isset($_POST['submit'])) {

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $dirname = $username;
    $foldername = "/home/fogyniak/domains/fogyniakarokkozosseg.hu/public_html/uploads/" . $dirname.'/';     //a vizsg�land� mappa az uploads-on bel�l a felhaszn�l�n�vvel azonos mappa


    $fileExt = explode('.', $fileName);        //szétválasztjuk a fájlnevet a "." karakternél, 
    $fileActualExt = strtolower(end($fileExt));   //kis betűkre állítjuk a nagy betűket

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');     //engedélyezett fájlformátumok tömbje
    if (in_array($fileActualExt, $allowed)) {    //ha a kiterjesztés benne van a megengedett tömbbe
        if ($fileError === 0) { //és a feltöltésnél hibák száma = 0
            if ($fileSize < 7000000000000) { //és ha a mérete kisebb mint 7MB
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;    //kap egy új egyedi nevet 
                /* ide a php r�sz-------------------------------------------------- */
                if (!file_exists($foldername)) {    //ha a mappa nem l�tezik
                    mkdir($foldername);
                    $fileDestination = $foldername . '/' . $fileNameNew;  //a f�jl �tvonala: egy �j, a felhaszn�l�n�vvel aznos nev� mappa
                } else {
                    $fileDestination = $foldername . '/' . $fileNameNew;
                }
                /* id�ig------------------------------------------------------------ */
                //  $fileDestination = 'uploads/' . $fileNameNew;    //mkdir("uploads/$username");ide mentjük
                move_uploaded_file($fileTmpName, $fileDestination);  //áthelyezzük az átmeneti mappából az uploadsba
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
$current = getcwd();
echo $current;
?>
<!DOCTYPE html>
<html>
    <body>

        <form method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="file" id="file">
            <input type="submit" value="submit" name="submit">
        </form>

    </body>
</html>