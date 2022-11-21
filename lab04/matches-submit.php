<!--
	Author:         Michele Lorenzo
	Course:         B
	Description:    PHP page for processing the matches' form.
	Content:        PHP & HTML code
--> 

<?php
#Funzioni PHP

/**
 * Funzione che restituisce le informazioni dei single divise per campi.
 * @return array Array di array contente le informazioni dei single nel seguente ordine 
 * (name, gender, age, personality type, favourite os, max age, min age).
 */
function get_singles() {
    $splitted_singles = array();

    foreach (file("singles.txt") as $single) 
        $splitted_singles[] = explode(",", $single);

    return $splitted_singles;
}

/**
 * Funzione che restituisce le informazioni relative all'utente.
 * @param string $nameUser Nome dell'utente.
 * @return array Informazioni relative all'utente.
 */
function get_user($nameUser) {
    foreach (get_singles() as $single) 
        if ($single[0] == $nameUser) 
            return $single;

    return null;
}

/**
 * Confronta due Personality Type.
 * @param string $userType Personality Type dell'utente.
 * @param string $otherType Personality Type del single da confrontare.
 * @return bool true se nella stessa posizione una lettera è uguale, false altrimenti.
 */
function type_matches($userType, $otherType) {
    for ($i=0; $i < strlen($userType); $i++) 
        if (strcmp($userType[$i], $otherType[$i]) == 0)
            return true;

    return false;
}

/**
 * Restituisce i signle che soddisfano i parametri dell'utente.
 * @param string $nameUser Nome dell'utente.
 * @return array Singles che soddisfano i parametri dell'utente. 
 */
function filter_singles($nameUser) {
    $filter_singles = array();
    list($uName, $uGender, $uAge, $uPt, $uFos, $uMinAge, $uMaxAge) = get_user($nameUser);

    foreach (get_singles() as $single) {
        list($name, $gender, $age, $pt, $fos, $minAge, $maxAge) = $single;

        if (strcmp($gender, $uGender) != 0 && strcmp($age, $uMinAge) >= 0 && strcmp($age, $uMaxAge) <= 0 && strcmp($uFos, $fos) == 0 && type_matches($uPt, $pt))
            $filter_singles[] = $single;
    }

    return $filter_singles;
}

include("top.html");
?>

<p><strong>Matches for <?= $_GET["name"] ?></strong></p>

<?php 
foreach (filter_singles($_GET["name"]) as $single) {
    list($name, $gender, $age, $pt, $fos, $minAge, $maxAge) = $single;
?>

<div class="match">
    <p>
        <img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/4/user.jpg" alt="profile image">
        <?= $name ?>
    </p>

    <ul>
        <li><strong>gender:</strong> <?= $gender ?></li>
        <li><strong>age:</strong> <?= $age ?></li>
        <li><strong>type:</strong> <?= $pt ?></li>
        <li><strong>OS:</strong> <?= $fos ?></li>
    </ul>
</div>

<?php
}

include("bottom.html");
?>