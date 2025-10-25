<?php
session_start();

$score = $_SESSION['score'] ?? 0;
$total = $_SESSION['total'] ?? 0;
$questions = $_SESSION['questions'] ?? [];
$answers = $_SESSION['answers'] ?? [];

// Feedback logic
$percentage = $total > 0 ? ($score / $total) * 100 : 0;
if ($percentage === 100) {
    $feedback = "🏆 Excellent! You got a perfect score!";
} elseif ($percentage >= 70) {
    $feedback = "🎉 Great job! You did very well.";
} elseif ($percentage >= 50) {
    $feedback = "👍 Not bad! You can still improve.";
} else {
    $feedback = "💡 Keep practicing! You'll get better.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Quiz Result</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style3.css" />
</head>
<body>
  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="mb-3">🎓 Quiz Completed</h2>
      <p class="fs-4">You scored <strong><?= $score ?></strong> out of <strong><?= $total ?></strong>.</p>
      <p class="lead"><?= $feedback ?></p>
      <a href="restart.php" class="btn btn-primary mt-3 px-4">Try Again</a>
    </div>

    <div class="card shadow-sm">
      <div class="card-header bg-info text-white">📝 Answer Review</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Question</th>
              <th>Your Answer</th>
              <th>Correct Answer</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($questions as $index => $q): 
              $qid = $q['id'];
              $correct = strtoupper($q['correct_option']);
              $user = isset($answers[$qid]) ? strtoupper($answers[$qid]) : "-";
              $status = $user === $correct ? "✅" : "❌";
            ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($q['question_text']) ?></td>
                <td><?= $user ?></td>
                <td><?= $correct ?></td>
                <td><?= $status ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
