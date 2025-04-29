<?php
session_start();
$conn = new mysqli("localhost", "root", "", "geo_quiz");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

function haversine_distance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earth_radius * $c;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lat = filter_input(INPUT_POST, 'latitude', FILTER_VALIDATE_FLOAT);
    $lon = filter_input(INPUT_POST, 'longitude', FILTER_VALIDATE_FLOAT);

    if ($lat === false || $lon === false) {
        header("Location: quiz.php");
        exit();
    }

    $distance = haversine_distance($_SESSION['correct_lat'], $_SESSION['correct_lon'], $lat, $lon);
    $points = max(5000 - $distance, 0);
    $_SESSION['score'] += round($points);

    $user_id = $_SESSION['user_id'];
    $_SESSION['question_count']++;

    $stmt = $conn->prepare("UPDATE users SET last_question_number = ?, current_score = ? WHERE id = ?");
    if ($stmt === false) {
        die("Błąd przygotowania zapytania UPDATE do users: " . $conn->error);
    }
    $stmt->bind_param("iii", $_SESSION['question_count'], $_SESSION['score'], $user_id);
    if (!$stmt->execute()) {
        die("Błąd wykonania zapytania UPDATE do users: " . $stmt->error);
    }
    $stmt->close();

    header("Location: quiz.php");
    exit();
}
?>