<?php

/**
 * @author Michele Lorenzo 
 */

namespace App\Models;

require_once ("../core/DBConfig.php");

use App\Core\DBConfig;
use PDO;

class User {

  private $id;

  private $firstName;

  private $lastName;

  private $birthday;

  private $gender;

  private $email;

  private $phoneNumber;

  private $isSeller;

  private $password;

  function __construct(
    $firstName = null,
    $lastName = null,
    $birthday = null,
    $gender = null,
    $email = null,
    $phoneNumber = null,
    $isSaller = null,
    $password = null
  ) {
    $this->id = 0;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->birthday = $birthday;
    $this->gender = $gender;
    $this->email = $email;
    $this->phoneNumber = $phoneNumber;
    $this->isSeller = $isSaller;
    $this->password = $password;
  }

  function getId() {
    return $this->id;
  }

  function getFirstName() {
    return $this->firstName;
  }

  function getEmail() {
    return $this->email;
  }

  function getIsSeller() {
    return $this->isSeller;
  }

  function insertIntoDB() {
    $conn = DBConfig::DBConnect();

    $qFirstName = $conn->quote($this->firstName);
    $qLastName = $conn->quote($this->lastName);
    $qBirthday = $conn->quote($this->birthday);
    $qGender = $conn->quote($this->gender);
    $qEmail = $conn->quote($this->email);
    $qPhoneNumber = $conn->quote($this->phoneNumber);
    $qIsSeller = $conn->quote($this->isSeller);
    $qPassword = $conn->quote($this->password);

    $sql = "INSERT INTO users (first_name, last_name, birthday, gender, email, phone_number, seller, users.password)
      VALUES (
          $qFirstName,
          $qLastName, 
          $qBirthday, 
          $qGender, 
          $qEmail, 
          $qPhoneNumber, 
          $qIsSeller, 
          $qPassword
      )";

    $conn->exec($sql);
    $conn = null;
  }

  function selectFromDB($email, $password, $isSeller) {
    $conn = DBConfig::DBConnect();
    $qEmail = $conn->quote(filter_var($email, FILTER_SANITIZE_EMAIL));
    $qIsSeller = $conn->quote($isSeller);

    $stmt = $conn->prepare(
      "SELECT * 
        FROM users 
        WHERE email = $qEmail
        AND seller = $qIsSeller"
    );

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() != 0 && password_verify($password, $result["password"])) {
      $this->setAll($result);

      return true;
    } else
      return false;
  }

  function selectFromDBWithId($id) {
    $conn = DBConfig::DBConnect();
    $qId = $conn->quote($id);

    $stmt = $conn->prepare(
      "SELECT * 
        FROM users 
        WHERE id = $qId"
    );

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount()) {
      $this->setAll($result);

      return true;
    } else
      return false;
  }

  function sanitize() {
    $this->firstName = htmlspecialchars($this->firstName);
    $this->lastName = htmlspecialchars($this->lastName);
    $this->gender = htmlspecialchars($this->gender);
    $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
    $this->phoneNumber = htmlspecialchars($this->phoneNumber);
    $this->password = htmlspecialchars($this->password);
  }

  function checkData() {
    return !empty($this->firstName)
      && !empty($this->lastName)
      && !empty($this->birthday)
      && !empty($this->gender)
      && !empty($this->email)
      && !empty($this->phoneNumber)
      && !empty($this->password)
      && filter_var($this->email, FILTER_VALIDATE_EMAIL);
  }

  private function setAll($data) {
    $this->id = $data["id"];
    $this->firstName = $data["first_name"];
    $this->lastName = $data["last_name"];
    $this->birthday = $data["birthday"];
    $this->gender = $data["gender"];
    $this->email = $data["email"];
    $this->phoneNumber = $data["phone_number"];
    $this->isSeller = $data["seller"];
    $this->password = $data["password"];
  }
}
