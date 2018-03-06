<?php
session_start();
$username = $_SESSION['username'];


if (isset($_POST['submit'])) {

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $dirname = $username;
    $foldername = "/home/fogyniak/domains/fogyniakarokkozosseg.hu/public_html/uploads/" . $dirname.'/';     //a vizsgálandó mappa az uploads-on belül a felhasználónévvel azonos mappa


    $fileExt = explode('.', $fileName);        //szÃ©tvÃ¡lasztjuk a fÃ¡jlnevet a "." karakternÃ©l, 
    $fileActualExt = strtolower(end($fileExt));   //kis betÅ±kre Ã¡llÃ­tjuk a nagy betÅ±ket

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');     //engedÃ©lyezett fÃ¡jlformÃ¡tumok tÃ¶mbje
    if (in_array($fileActualExt, $allowed)) {    //ha a kiterjesztÃ©s benne van a megengedett tÃ¶mbbe
        if ($fileError === 0) { //Ã©s a feltÃ¶ltÃ©snÃ©l hibÃ¡k szÃ¡ma = 0
            if ($fileSize < 7000000000000) { //Ã©s ha a mÃ©rete kisebb mint 7MB
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;    //kap egy Ãºj egyedi nevet 
                /* ide a php rész-------------------------------------------------- */
                if (!file_exists($foldername)) {    //ha a mappa nem létezik
                    mkdir($foldername);
                    $fileDestination = $foldername . '/' . $fileNameNew;  //a fájl útvonala: egy új, a felhasználónévvel aznos nevû mappa
                } else {
                    $fileDestination = $foldername . '/' . $fileNameNew;
                }
                /* idáig------------------------------------------------------------ */
                //  $fileDestination = 'uploads/' . $fileNameNew;    //mkdir("uploads/$username");ide mentjÃ¼k
                move_uploaded_file($fileTmpName, $fileDestination);  //Ã¡thelyezzÃ¼k az Ã¡tmeneti mappÃ¡bÃ³l az uploadsba
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