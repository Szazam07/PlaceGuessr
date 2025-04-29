<?php
session_start();
$conn = new mysqli("localhost", "root", "", "geo_quiz");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$stmt = $conn->prepare("SELECT current_score, last_question_number FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($current_score, $last_question_number);
$stmt->fetch();
$stmt->close();

$_SESSION['score'] = $current_score ?? 0;
$_SESSION['question_count'] = $last_question_number ?? 0;
if (!isset($_SESSION['answered_questions'])) {
    $_SESSION['answered_questions'] = [];
}

if (isset($_POST['reset_game'])) {
    $_SESSION['score'] = 0;
    $_SESSION['question_count'] = 0;
    $_SESSION['answered_questions'] = [];
    $stmt = $conn->prepare("UPDATE users SET current_score = 0, last_question_number = 0 WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

if ($_SESSION['question_count'] >= 5) {
    header("Location: results.php");
    exit();
}

$answered_questions = empty($_SESSION['answered_questions']) ? '0' : implode(',', $_SESSION['answered_questions']);
$question_query = $conn->query("SELECT * FROM questions WHERE id NOT IN ($answered_questions) ORDER BY RAND() LIMIT 1");
$question = $question_query->fetch_assoc();

if (!$question) {
    header("Location: results.php");
    exit();
}

$_SESSION['question_id'] = $question['id'];
$_SESSION['correct_lat'] = $question['latitude'];
$_SESSION['correct_lon'] = $question['longitude'];
$_SESSION['answered_questions'][] = $question['id'];

$stmt = $conn->prepare("UPDATE users SET last_question_number = ? WHERE id = ?");
$stmt->bind_param("ii", $_SESSION['question_count'], $_SESSION['user_id']);
$stmt->execute();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geo Quiz</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="flex-row">
        <div class="H-left">
            <h1>Gdzie znajduje się to miejsce?</h1>
        </div>
        <div class="H-right flex-row">
            <h2>Runda: <?php echo $_SESSION['question_count'] + 1; ?>/5</h2>
            <h2>Wynik: <?php echo $_SESSION['score']; ?></h2>
        </div>
    </header>
    <main class="main flex-row flex-SA">
        <div class="left flex">
            <img src="<?php echo htmlspecialchars($question['image_url']); ?>" width="500" height="300" alt="Pytanie">
        </div>
        <div class="right flex flex-col">
            <div id="map" style="height: 400px;"></div>
            <form method="POST" action="check_answer.php" class="flex">
                <input type="hidden" name="question_id" value="<?php echo $_SESSION['question_id']; ?>">
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <button type="submit">Wyślij odpowiedź</button>
            </form>
        </div>
    </main>
    <script>
        var map = L.map('map').setView([20, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;
        function onMapClick(e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        }
        map.on('click', onMapClick);
    </script>
</body>
</html>