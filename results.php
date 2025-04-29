<?php
session_start();
$conn = new mysqli("localhost", "root", "", "geo_quiz");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$score = $_SESSION['score'] ?? 0;

$stmt = $conn->prepare("SELECT best_score FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($best_score);
$stmt->fetch();
$stmt->close();

if ($score > $best_score) {
    $stmt = $conn->prepare("UPDATE users SET best_score = ? WHERE id = ?");
    $stmt->bind_param("ii", $score, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

$_SESSION['score'] = 0;
$_SESSION['question_count'] = 0;
$_SESSION['answered_questions'] = [];
$stmt = $conn->prepare("UPDATE users SET current_score = 0, last_question_number = 0 WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wyniki</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Twój wynik: <?php echo htmlspecialchars($score); ?> punktów</h2>
    <div class="flex-col">
        <form method="POST" action="quiz.php" class="flex">
            <button type="submit" name="reset_game" class="restart">Zagraj ponownie</button>
        </form>
        <form method="POST" action="scores.php" class="flex">
            <button type="submit" class="results">Zobacz tabelę wyników</button>
        </form>
        <form method="POST" action="index.php" class="flex">
            <button type="submit" name="logout" class="logout">Wyloguj</button>
        </form>
    </div>
</body>
</html>