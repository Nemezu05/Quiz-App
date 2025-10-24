<?php
session_start();
$score = $_SESSION['score'] ?? 0;
$total = $_SESSION['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz Result</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container text-center py-5">
    <h2>🎉 Quiz Completed!</h2>
    <p class="lead">You scored <strong><?php echo $score; ?></strong> out of <strong><?php echo $total; ?></strong>.</p>
    <a href="restart.php" class="btn btn-primary">Try Again</a>
  </div>
</body>
</html>
