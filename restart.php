<?php
session_start();

// Clear answers and reset timer
unset($_SESSION['answers']);
unset($_SESSION['score']);
unset($_SESSION['total']);
$_SESSION['quiz_start_time'] = time(); // Restart timer

header("Location: quiz.php?page=1");
exit();
?>
