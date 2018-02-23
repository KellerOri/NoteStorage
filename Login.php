<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  $servername = "localhost:8889";
  $username = "root";
  $password = "root";
  $dbname = "NotesDB";

  $name = $_POST['name'];
  $pass = $_POST['password'];

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $resultArr = array();
  if ($name != "" && $pass != "") {
    $sql = "SELECT Name, Password, UserID FROM Users WHERE Name='";
    $sql .= $name;
    $sql .= "' AND Password='";
    $sql .= $pass;
    $sql .= "';";

    if($result = $conn->query($sql)) {
      $userArr = array();
      while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        $userArr[] = array("name"=>utf8_encode($rs['Name']), "password"=>utf8_encode($rs['Password']), "userID"=>utf8_encode($rs['UserID']));
      }
      if (count($userArr)>0){
        $resultArr['success'] = true;
        $resultArr['user'] = $userArr;
      } else{
        $resultArr['success'] = false;
        $resultArr['errorMsg'] = "No such user was found";
      }
    } else {
      $resultArr['success'] = false;
      $resultArr['errorMsg'] = "Query unsuccessful; user not found";
    }
  } else {
    $resultArr['success'] = false;
    $resultArr['errorMsg'] = "Username and/or password invalid";
  }

  echo json_encode($resultArr);

  $conn->close();
?>
