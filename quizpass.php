<?php 
include('conn.php');
session_start();
$id= $_SESSION['id'];
$qid=$_GET['qid'];
if (!isset($_SESSION['firstname'])) {          
  header('location:signup.php');
  exit();
  }
  $sql_stm= " SELECT * From score WHERE ID = '$id' and  subId = '$qid' ";
  $result_stm = $conn->query($sql_stm); 
  if($result_stm->num_rows > 0){
    header("location:index.php");
  }
  
$sql = "SELECT password FROM exams WHERE id = '$qid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $storedPassword = $row['password'];
} else {
  echo "Exam not found.";
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $enteredPassword = $_POST['password'];
  if (password_verify($enteredPassword, $storedPassword)) {
    $_SESSION['qid']=$qid;
    header("Location: examRoom.php");
    exit;
  } else {
    $error = "Incorrect password. Please try again.";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Exam Password Input</title>
  <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <div class="container mt-3">
        <h1 class=" textcenter">Quiz Password</h1>
        <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" class="form-control aligncenter mb-3">
            <h4>Enter the Quiz's Password to Start</h4>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" value="Start Quiz" class="btn btn-outline-primary btn-info">Start Quiz</button>
        </form>
    </div>
</body>
</html>