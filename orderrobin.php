<?php
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$email = $_POST['email'];

$phone = $_POST['phone'];
$order = $_POST['order'];

if (!empty($firstname) || !empty($lastname) || !empty($email) || !empty($phone)) || !empty($order){
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "log";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From orderrobin Where email = ? Limit 1";
     $INSERT = "INSERT Into orderrobin (firstname, lastname, email, phone, order) values(?, ?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssis", $firstname, $lastname, $email, $phone, $order);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>