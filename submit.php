<?php
include("connection.php");
session_start();

// Merge new answers from final page into session-stored answers
if (isset($_POST['answer'])) {
    foreach ($_POST['answer'] as $questionId => $userAnswer) {
        $_SESSION['answers'][$questionId] = $userAnswer;
    }
}

$score = 0;
$total = count($_SESSION['questions']); // Always 50

foreach ($_SESSION['questions'] as $question) {
    $id = $question['id'];
    $correct = strtolower($question['correct_option']);
    $userAnswer = isset($_SESSION['answers'][$id]) ? strtolower($_SESSION['answers'][$id]) : null;

    if ($userAnswer && $userAnswer === $correct) {
        $score++;
    }
}

$_SESSION['score'] = $score;
$_SESSION['total'] = $total;

header("Location: result.php");
exit();
?>
