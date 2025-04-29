<?php
session_start();
$conn = new mysqli("localhost", "root", "", "geo_quiz");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$scores_query = $conn->query("SELECT username, best_score FROM users ORDER BY best_score DESC");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Tabela wyników</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Tabela wyników</h2>
    <table border="1">
        <thead>
            <tr><th>Użytkownik</th><th>Wynik</th></tr>
        </thead>
        <tbody>
            <?php while ($row = $scores_query->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['best_score']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="flex-col">
        <form method="POST" action="quiz.php" class="flex">
            <button type="submit" name="reset_game" class="restart">Zagraj ponownie</button>
        </form>
        <form method="POST" action="index.php" class="flex">
            <button type="submit" name="logout" class="logout">Wyloguj</button>
        </form>
    </div>
</body>
</html>