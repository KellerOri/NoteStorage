<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  $servername = "localhost:8889";
  $username = "root";
  $password = "root";
  $dbname = "NotesDB";

  $titleErr = $contentErr = $userIdErr = "";
  $title = $contentErr = "";
  $user_id = 0;
  $isError = false;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['title'])) {
      $titleErr = "Title is required";
      $isError = true;
    } else {
      $title = test_input($_POST['title']);
    }
    if (empty($_POST['content'])) {
      $contentErr = "Content is required";
      $isError = true;
    } else {
      $content = test_input($_POST['content']);
    }
    if (empty($_POST['user_id'])) {
      $userIdErr = "User ID is required";
      $isError = true;
    } else {
      $user_id = test_input($_POST['user_id']);
    }
  }

  //Make sure input is safe data
  function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $conn = new mysqli($servername, $username, $password, $dbname);
  $resultArr = array();

  if ($isError) {
    $resultArr['success'] = false;
    $resultArr['errorMsg'] = "Error in input";
  } else {
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO Notes(Title, Content, UserID) VALUES('";
    $sql .= $title;
    $sql .= "', '";
    $sql .= $content;
    $sql .= "', ";
    $sql .= $user_id;
    $sql .= ");";

    if ($conn->query($sql) === TRUE) {
      $resultArr['success'] = true;
    } else {
      $resultArr['success'] = false;
      $resultArr['errorMsg'] = "SQL: " . $sql;
    }

    echo json_encode($resultArr);

    $conn->close();
  }
?>
