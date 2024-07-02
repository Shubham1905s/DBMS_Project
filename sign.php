<?php

$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'connect.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if username already exists
  $stmt = $con->prepare("SELECT * FROM `registration` WHERE `username` = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result) {
    $num = $result->num_rows;
    if ($num > 0) {
      // echo "<br>Username already exists";
      $user = 1;
    } else {
      // Insert new user
      $stmt = $con->prepare("INSERT INTO `registration` (`username`, `password`) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $password);
      if ($stmt->execute()) {
        // echo "<br>Signup successful";
        $success = 1;
        header("Location:login.php");
      } else {
        echo "Error: " . $stmt->error;
      }
    }
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close the statement and the connection
  $stmt->close();
  $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign-up Page</title>
</head>

<body>
  <?php

  if ($user) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Invalid Username </strong> User already exists
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  }
  ?>

  
  <?php

  if ($success) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success </strong> You have successfully Signed in
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  }
  ?>



  <div class="Signup">
    <h2 class="text-center">
      Sign-up Page
    </h2>
  </div>
  <div class="container mt-5">
    <form action="sign.php" method="post">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">UserName</label>
        <input type="text" placeholder=" Enter your Username" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" placeholder=" Enter your Password" name="password" class="form-control" id="exampleInputPassword1">
      </div>
      <!-- <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div> -->
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>

</html>