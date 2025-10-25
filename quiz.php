<?php
session_start();
include("connection.php");

// Save submitted answers from previous page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    foreach ($_POST['answer'] as $questionId => $userAnswer) {
        $_SESSION['answers'][$questionId] = $userAnswer;
    }
}

// Start the quiz and store 50 questions in session
if (!isset($_SESSION['questions'])) {
    $questions = [];
    $sql = "SELECT * FROM questions ORDER BY RAND() LIMIT 50";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
    $_SESSION['questions'] = $questions;
    $_SESSION['answers'] = [];
    $_SESSION['quiz_start_time'] = time();
}

// Page logic
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$totalPages = ceil(count($_SESSION['questions']) / $perPage);
$startIndex = ($page - 1) * $perPage;
$questionsToShow = array_slice($_SESSION['questions'], $startIndex, $perPage);

// Timer logic
$totalQuizDuration = 1800; // 30 minutes
$elapsed = time() - $_SESSION['quiz_start_time'];
$timeLeft = $totalQuizDuration - $elapsed;
if ($timeLeft <= 0) {
    header("Location: submit.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quiz</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style2.css" />
</head>
<body>
  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>📝 Quiz - Page <?php echo $page; ?>/<?php echo $totalPages; ?></h2>
      <div class="text-danger fw-bold" id="timer"></div>
    </div>

    <form action="quiz.php?page=<?php echo $page + 1; ?>" method="POST" id="quizForm">
      <?php
      $qNum = $startIndex + 1;
      foreach ($questionsToShow as $question) {
          echo "<div class='mb-4'>";
          echo "<p><strong>Q{$qNum}. " . htmlspecialchars($question['question_text']) . "</strong></p>";

          foreach (['a', 'b', 'c', 'd'] as $opt) {
              $optionText = htmlspecialchars($question['option_' . $opt]);
              $checked = isset($_SESSION['answers'][$question['id']]) && $_SESSION['answers'][$question['id']] == $opt ? 'checked' : '';
              echo "<div class='form-check'>";
              echo "<input class='form-check-input' type='radio' name='answer[{$question['id']}]' value='{$opt}' id='q{$question['id']}{$opt}' {$checked}>";
              echo "<label class='form-check-label' for='q{$question['id']}{$opt}'>{$optionText}</label>";
              echo "</div>";
          }

          echo "</div>";
          $qNum++;
      }
      ?>
      <?php if ($page < $totalPages): ?>
        <button type="submit" class="btn btn-primary mt-3">Next</button>
      <?php else: ?>
        <button type="submit" formaction="submit.php" class="btn btn-success mt-3">Submit Quiz</button>
      <?php endif; ?>
    </form>
  </div>

  <script>
    let timeLeft = <?php echo $timeLeft; ?>;
    const timerEl = document.getElementById("timer");

    const countdown = setInterval(() => {
      if (timeLeft <= 0) {
        clearInterval(countdown);
        alert("Time's up! Submitting your quiz...");
        document.getElementById("quizForm").submit();
      } else {
        const mins = Math.floor(timeLeft / 60);
        const secs = timeLeft % 60;
        timerEl.textContent = `Time left: ${mins}m ${secs < 10 ? "0" : ""}${secs}s`;
        timeLeft--;
      }
    }, 1000);
  </script>
</body>
</html>
