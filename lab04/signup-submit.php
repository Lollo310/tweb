<!--
	Author:         Michele Lorenzo
	Course:         B
	Description:    PHP page for processing the signup's form.
	Content:        PHP & HTML code
--> 

<?php
#Funzioni PHP

/**
 * Funzione per scrivere il nuovo utente sul file singles.txt
 */
function writeFile() {
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $personalityType = $_POST["personalityType"];
    $favoriteOS = $_POST["favoriteOS"];
    $minAge = $_POST["minAge"];
    $maxAge = $_POST["maxAge"];

    file_put_contents("singles.txt", "\n$name,$gender,$age,$personalityType,$favoriteOS,$minAge,$maxAge", FILE_APPEND);
}

include("top.html");
?>

<div>
    <p>
        <strong>Thank you!</strong>
    </p>

    <p>
        Welcome to NerdLuv, <?= $_POST["name"]?>!
    </p>

    <p>
        Now <a href="matches.php">log in to see your matches!</a>
    </p>

    <?php
       writeFile();
    ?>
</div>

<?php include("bottom.html"); ?>