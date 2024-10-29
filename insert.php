<?php
$Fname = $_POST['Fname'];
$Lname = $_POST['Lname'];
$Uname = $_POST['Uname'];
$pwd = $_POST['pwd'];

if (!empty($Uname) && !empty($pwd) && !empty($Fname) && !empty($Lname)) {
    $host = "sql12.freesqldatabase.com";
    $dbUsername = "sql12741546";
    $dbPassword = "KAexfLWQSP";
    $dbname = "sql12741546";

    // Create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare an SQL statement to insert data
    $stmt = $conn->prepare("INSERT INTO account (Fname,Lname,Uname,pwd) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $Fname, $Lname, $Uname, $pwd);

    // Execute the query
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap"
      rel="stylesheet"
    />
  </head>
  <body background="istockphoto-1349030917-612x612.jpg">
    <div class="signup-box">
      <h1>Sign Up</h1>
      <form method="POST">
        <label>First Name</label>
        <input type="text" placeholder="" name="Fname" required />
        <label>Last Name</label>
        <input type="text" placeholder="" name="Lname" required />
        <label>Username</label>
        <input type="text" placeholder="" name="Uname" required />
        <label>Password</label>
        <input type="password" placeholder="" name="pwd" required />
        <input type="submit"  /> 
        <input type="reset" />
        <p class="para-2">
          Already have an account? <a href="index.php">Login here</a>
        </p>
      </form>
    </div>
  </body>
</html>

