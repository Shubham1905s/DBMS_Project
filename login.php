<?php
$login = 0;
$invalid = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'connect.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if username and password match
  $stmt = $con->prepare("SELECT * FROM `registration` WHERE `username` = ? AND `password` = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result) {
    $num = $result->num_rows;
    if ($num > 0) {
      $login = 1;
      session_start();
      $_SESSION["username"] = $username;
      header("Location: home.php");
    } else {
      $invalid = 1;
    }
  } else {
    $invalid = 1;
  }

  // Close the statement and the connection
  $stmt->close();
  $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
</head>
<body>

<?php
if ($login) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> You have successfully logged in
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

if ($invalid) {
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Sorry!</strong> Invalid Credentials
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>

<div class="Signup">
  <h2 class="text-center">Login Page</h2>
</div>
<div class="container mt-5">
  <form action="login.php" method="post">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">UserName</label>
      <input type="text" placeholder="Enter your Username" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" placeholder="Enter your Password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>

</body>
</html>