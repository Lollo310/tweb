<?php
/**
 * Contiene le funzioni php richiamate in getMovieList.
 * @author Michele Lorenzo
 * Corso: B
 */

 if(!isset($_SESSION)) session_start();

/**
 * Cerca nel DB tutti i film dell'attore passato come parametro.
 * @param conn Connessione al DB.
 * @param firstname Nome dell'attore
 * @param lastname Cognome dell'attore.
 * @return rows Elenco dei film dove ha avuto un ruolo l'attore o null.
 */
function searchAll($conn, $firstname, $lastname) {
    $res = searchID($conn, $firstname, $lastname);
    $id = $res->fetch(PDO::FETCH_ASSOC);
    $rows = null;

    if ($id["id"] != null) {
        $qid = $conn->quote((int) $id["id"]);
        $query = "SELECT m.name, m.year 
            FROM actors a JOIN roles r ON a.id = r.actor_id JOIN movies m ON r.movie_id = m.id
            WHERE a.id = $qid
            ORDER BY m.year DESC, m.name";
        $rows = $conn->query($query);
    }

    return $rows;
}

/**
 * Cerca nel DB tutti i film dove ha avuto un ruolo anche Kevin Bacon dell'attore passato come 
 * parametro.
 * @param conn Connessione al DB.
 * @param firstname Nome dell'attore.
 * @param lastname Cognome dell'attore.
 * @return rows Elenco dei film dove ha avuto un ruolo l'attore e Kevin Bacon o null.
 */
function searchKevin($conn, $firstname, $lastname) {
    $res = searchID($conn, $firstname, $lastname);
    $id = $res->fetch(PDO::FETCH_ASSOC);
    $rows = null;

    if ($id["id"] != null) {
        $qid = $conn->quote((int) $id["id"]);
        $kevin = $conn->quote("Kevin");
        $bacon = $conn->quote("Bacon");
        $query = "SELECT m.name, m.year
            FROM actors a1 JOIN roles r1 ON a1.id = r1.actor_id JOIN movies m ON r1.movie_id = m.id
            JOIN roles r2 ON m.id = r2.movie_id JOIN actors a2 ON r2.actor_id = a2.id
            WHERE a1.id = $qid 
            AND a2.first_name = $kevin
            AND a2.last_name = $bacon
            ORDER BY m.year DESC, m.name";
        $rows = $conn->query($query);
    }

    return $rows;
}

/**
 * Trova l'id dell'attore passato come parametro.
 * @param conn Connessione al DB.
 * @param firstname Nome dell'attore.
 * @param lastname Cognome dell'attore.
 * @return conn->query ID dell'attore.
 */
function searchID($conn, $firstname, $lastname) {
    $qfirstname = $conn->quote($firstname . "%");
    $qlastname = $conn->quote($lastname);
    $query = "SELECT MIN(id) id 
        FROM actors 
        WHERE first_name LIKE $qfirstname 
        AND last_name=$qlastname 
        AND film_count = (
            SELECT MAX(film_count) film_count 
            FROM actors 
            WHERE first_name LIKE $qfirstname 
            AND last_name=$qlastname
        )";
    
    return $conn->query($query);
}

/**
 * Controlla se gli argomenti sono validi.
 * @param firstname Nome dell'attore.
 * @param lastname Cognome dell'attore.
 * @param all Tipo di ricerca (true => searchAll OR false => searchKevin).
 * @throws InvalidArgumentException Se gli argomenti non sono validi.
 */
function testArguments($firstname, $lastname, $all) {
    if (empty($firstname) || empty($lastname))
        throw new InvalidArgumentException("Firstname or lastname can't be empty");

    if ($all=="false" && strcasecmp($firstname,"kevin") == 0 && strcasecmp($lastname,"bacon") == 0)
        throw new InvalidArgumentException("Kevin Bacon can't make movies with himself");
}

/**
 * Produce l'output(i film) in formato JSON.
 * @param firstname Nome dell'attore.
 * @param lastname Cognome dell'attore.
 * @param result Righe prodotte dalle funzioni searchKevin/searchAll conteneni i film.
 * @throws Exception Se result e' null o vuoto.
 */
function printJson($firstname, $lastname, $result) {
    if (!$result)
        throw new Exception("$firstname $lastname not found."); 
    
    if ($result->rowCount() == 0)
        throw new Exception("$firstname $lastname wasn't in any films with Kevin Bacon");

    $json = array(
        "firstname" => $firstname,
        "lastname" => $lastname,
        "movies" => $result->fetchAll(PDO::FETCH_ASSOC)
    );

    echo json_encode($json);
}

/**
 * Effettua la connessione con il DB.
 * @return conn Connessione al DB.
 * @throws PDOException Se il tentativo di connessione non termina con successo.
 */
function DBConnect() {
    $conn = new PDO("mysql:host=localhost:3306; dbname=imdb", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}

/**
 * Contolla se l'username e la password sono corretti.
 * @param username Username utente.
 * @param password Password utente.
 * @param conn Connessione al DB.
 */
function checkPassword($username, $password, $conn) {
    $qusername = $conn->quote($username);
    $query = "SELECT u.password
    FROM users u
    WHERE u.username = $qusername";
    $stmt = $conn->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return ($stmt->rowCount() != 0) ? password_verify($password, $result["password"]) : false;
}

?>