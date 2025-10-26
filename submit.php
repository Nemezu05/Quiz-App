<?php
include("connection.php");
session_start();

// Merge new answers from final page into session-stored answers
if (isset($_POST['answer'])) {
    foreach ($_POST['answer'] as $questionId => $userAnswer) {
        $_SESSION['answers'][$questionId] = $userAnswer;
    }
}

// Check if all questions have been answered
$allAnswered = true;
foreach ($_SESSION['questions'] as $question) {
    $id = $question['id'];
    if (!isset($_SESSION['answers'][$id]) || empty($_SESSION['answers'][$id])) {
        $allAnswered = false;
        break;
    }
}

if (!$allAnswered) {
    // Redirect back to quiz page with an error message
    $_SESSION['error'] = "Please answer all questions before submitting.";
    header("Location: quiz.php"); // Change this to the page showing the quiz
    exit();
}

// Calculate score
$score = 0;
$total = count($_SESSION['questions']); // Always 50

foreach ($_SESSION['questions'] as $question) {
    $id = $question['id'];
    $correct = strtolower($question['correct_option']);
    $userAnswer = strtolower($_SESSION['answers'][$id]);

    if ($userAnswer === $correct) {
        $score++;
    }
}

$_SESSION['score'] = $score;
$_SESSION['total'] = $total;

header("Location: result.php");
exit();
?>
