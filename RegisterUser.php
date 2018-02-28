<html></html>
<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  $servername = "localhost:8889";
  $username = "root";
  $password = "root";
  $dbname = "NotesDB";

  $nameErr = $passErr = "";
  $name = $pass = "";
  $isError = false;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST['name'])){
      $nameErr = "Name is required";
      $isError = true;
    } else {
      $name = test_input($_POST['name']);
    }
    if(empty($_POST['password'])){
      $passErr = "Password is required";
      $isError = true;
    } else {
      $pass = test_input($_POST['password']);
    }
  }

  // Make sure input is safe data
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
      return $data;
  }

  $conn = new mysqli($servername, $username, $password, $dbname);
  $resultArr = array();

  if ($isError){
    $resultArr['success'] = false;
    $resultArr['errorMsg'] = "Error in input";
  } else {
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Users(Name, Password) VALUES ('";
    $sql .= $name;
    $sql .= "', '";
    $sql .= $pass;
    $sql .= "');";

    if ($conn->query($sql) === TRUE){
      $resultArr['success'] = true;
    } else {
      $resultArr['success'] = false;
      $resultArr['errorMsg'] = "SQL: " . $sql;
    }

  }

  echo json_encode($resultArr);

  $conn->close();
?>
