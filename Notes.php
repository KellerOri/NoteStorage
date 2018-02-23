<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  $servername = "localhost:8889";
  $username = "root";
  $password = "root";
  $dbname = "NotesDB";

  $user_id = $_POST['user_id'];

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $resultArr = array();

  if ($user_id >= 1){
    $sql = "SELECT Title, Content FROM Notes WHERE UserID=";
    $sql .= $user_id;
    $sql .= ";";

    if ($result = $conn->query($sql)){
      $noteArr = array();
      while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        $noteArr[] = array("title"=>utf8_encode($rs['Title']), "content"=> utf8_encode($rs['Content']));
      }

      if (count($noteArr)>0) {
        $resultArr['success'] = true;
        $resultArr['note'] = $noteArr;
      } else {
        $resultArr['success'] = false;
        $resultArr['errorMsg'] = "No notes were found";
      }
    } else {
      $resultArr['success'] = false;
      $resultArr['errorMsg'] = "Query unsuccessful; notes not found";
    }
  } else {
    $resultArr['success'] = false;
    $resultArr['errorMsg'] = "Invalid login";
  }

  echo json_encode($resultArr);

  $conn->close();

?>
