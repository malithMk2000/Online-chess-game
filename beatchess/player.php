<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player Profile</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    
    <div>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "beatchess";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve opponent's details from the users table
        $opponentId = $_GET['opponentId'] ?? null;

        if ($opponentId) {
            $sql = "SELECT * FROM users WHERE id = $opponentId";
            $result = mysqli_query($conn, $sql);
            $userData = mysqli_fetch_assoc($result);
            
            if ($userData) {
                $username = $userData['username'];
                $firstname = $userData['firstname'];
                $lastname = $userData['lastname'];
                $country = $userData['country'];

                // Retrieve opponent's skill from the skill table
                $sqlSkill = "SELECT * FROM skill WHERE id = $opponentId";
                $resultSkill = mysqli_query($conn, $sqlSkill);
                $skillData = mysqli_fetch_assoc($resultSkill);

                if ($skillData) {
                    $level = $skillData['level'];
                    $points = $skillData['points'];
                    $wins = $skillData['wins'];
                    $lost = $skillData['lost'];
                }

                // Display opponent's profile
                echo "<h2>{$username}'s Profile</h2>";
                echo "<p>Username: {$username}</p>";
                echo "<p>Name: {$firstname} {$lastname}</p>";
                echo "<p>Country: {$country}</p>";
                echo "<p>Level: {$level}</p>";
                echo "<p>Points: {$points}</p>";
                echo "<p>Wins: {$wins}</p>";
                echo "<p>Lost: {$lost}</p>";
            } else {
                echo "Player not found.";
            }
        } else {
            echo "Invalid player ID.";
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
