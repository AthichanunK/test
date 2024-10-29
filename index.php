
<?php
$Uname = isset($_GET['Uname']) ? $_GET['Uname'] : '';
$pwd = isset($_GET['pwd']) ? $_GET['pwd'] : '';

if (!empty($Uname) && !empty($pwd)) {
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

    // Prepare an SQL statement to check if the user exists
    $stmt = $conn->prepare("SELECT * FROM account WHERE Uname = ? AND pwd = ?");
    $stmt->bind_param("ss", $Uname, $pwd);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching user is found
    if ($result->num_rows > 0) {
        echo "Welcome to our Dashboard";
        header("Location: dashBoard.html");
        exit();
    } else {
        echo "Invalid username or password";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap"
      rel="stylesheet"
    />
  </head>
  <body background="city-economic-pulse-stockcake.jpg">
    <div class="login-box">
      <h1>Login</h1>
      <form method="get">
        <label>Username</label>
        <input type="text" name="Uname" placeholder="" />
        <label>Password</label>
        <input type="password" name="pwd" placeholder="" />
        <input type="submit" />
      </form>
    </div>
    <p class="para-2">
      Not have an account? <a href="insert.php">Sign Up Here</a>
    </p>
  </body>
</html>