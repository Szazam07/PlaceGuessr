<?php
session_start();
$conn = new mysqli("localhost", "root", "", "geo_quiz");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

function haversine_distance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earth_radius * $c;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Geo Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="">
        <div class="flex-col">
            <h2>Login</h2>
            <form method="POST">
                Username: <input type="text" name="username" required>
                Password: <input type="password" name="password" required>
                <button type="submit" name="login">Login</button>
            
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
                        $username = $_POST['username'];
                        $result = $conn->query("SELECT * FROM users WHERE username='$username'");
                        if ($row = $result->fetch_assoc()) {
                            if (password_verify($_POST['password'], $row['password'])) {
                                $_SESSION['user_id'] = $row['id'];
                                $_SESSION['username'] = $username;
                                $_SESSION['score'] = 0;
                                header("Location: quiz.php");
                                exit();
                            }
                        }
                        echo "Zły login!";
                    }
                ?>
            </form>
        </div>
        <div class="flex-col">
            <h2>Register</h2>
            <form method="POST">
                Username: <input type="text" name="username" required>
                Password: <input type="password" name="password" required>
                <button type="submit" name="register">Register</button>
            
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
                        $username = $_POST['username'];
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
                        echo "Zarejestrowano!";
                    }
                ?>
            </form>
        </div>
    </div>
</body>
</html>