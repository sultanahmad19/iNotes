<?php 
include 'dbconnect.php';

$insert = false;
$update = false;
$delete = false;


if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  // echo $sno;
  $delete = true;
  $stmt = $conn->prepare(" DELETE FROM `notes` WHERE `notes`.`sno` = ?");
  $stmt->bind_param("i", $sno);
  $stmt->execute();
  
}
if ( isset($_POST['submit'])) {
  if (isset($_POST['snoEdit'])) {
    // Update records
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    $stmt = $conn->prepare("UPDATE `notes` SET `title` = ?, `description` = ? WHERE `notes`.`sno` = ?");
    $stmt->bind_param("ssi", $title, $description, $sno);
    
    if ($stmt->execute()) {
      $update = true;

      } else {
        echo "Error in preparing statement: " . $conn->error;
      }
      $stmt->close();
  }

  else{
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];  
    
    // Insert data into the database using prepared statement
    
    
    $stmt = $conn->prepare("INSERT INTO `notes` (`title`, `description`) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $description);
  
  

    if ($stmt->execute()) {
      $insert = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
  }
}

?>