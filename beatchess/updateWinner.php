<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if challengeId is set in the POST request
if (isset($_POST['challengeId']) && isset($_POST['WinnerId'])) {
    $challengeId = $_POST['challengeId'];
    $WinnerId = $_POST['WinnerId'];
    $loserId = $_POST['loserId'];
    echo "challengeId: " . $challengeId . "<br>";
    echo "playerId: " . $WinnerId . "<br>";

    // Sanitize the input (optional, but recommended)
    $challengeId = $conn->real_escape_string($challengeId);
    $WinnerId = $conn->real_escape_string($WinnerId);
    $loserId = $conn->real_escape_string($loserId);

    // Your SQL update code here
    $sql = "UPDATE challenge SET winner_id = $WinnerId WHERE id = $challengeId";

    // Execute your SQL query
    if ($conn->query($sql) === TRUE) {
        // Additional logic after updating challenge table
        // Update Challenge Status
        $sqlUpdateChallengeStatus = "UPDATE challenge SET status = 'closed' WHERE id = $challengeId";
        $conn->query($sqlUpdateChallengeStatus);

        // Retrieve Challenge Data
        $sqlRetrieveChallengeData = "SELECT value FROM challenge WHERE id = $challengeId";
        $result = $conn->query($sqlRetrieveChallengeData);
        $challengeData = $result->fetch_assoc();
        $challengeValue = $challengeData['value'];

        // Update Winner's Balance
        $sqlUpdateWinnerBalance = "UPDATE users SET balance = balance + ($challengeValue * 1.85) WHERE id = $WinnerId";
        $conn->query($sqlUpdateWinnerBalance);

        $sqlAddBonusToUser7 = "UPDATE users SET balance = balance + ($challengeValue * 0.15) WHERE id = 7";
        $conn->query($sqlAddBonusToUser7);

        // Update Winner's Skill Points
        $sqlUpdateWinnerSkillPoints = "UPDATE skill SET points = points + 2 WHERE id = $WinnerId";
        $conn->query($sqlUpdateWinnerSkillPoints);

        // Check if the winner's points are >= 100 and update level accordingly
        $sqlCheckWinnerPoints = "SELECT points FROM skill WHERE id = $WinnerId";
        $result = $conn->query($sqlCheckWinnerPoints);
        $row = $result->fetch_assoc();
        $winnerPoints = $row['points'];

        if ($winnerPoints >= 100) {
            $sqlUpdateWinnerLevel = "UPDATE skill SET points = 0, level = level + 1 WHERE id = $WinnerId";
            $conn->query($sqlUpdateWinnerLevel);
        }
        
        // Increment Winner's Wins
        $sqlIncrementWinnerWins = "UPDATE skill SET wins = wins + 1 WHERE id = $WinnerId";
        $conn->query($sqlIncrementWinnerWins);

        // Increment Loser's Losses
        $sqlIncrementLoserLosses = "UPDATE skill SET lost = lost + 1 WHERE id = $loserId";
        $conn->query($sqlIncrementLoserLosses);

        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
    exit;
}
?>
