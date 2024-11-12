<?php

include 'data base/config.php';

// Query to retrieve open challenges
$sql = "SELECT * FROM challenge WHERE status = 'open' AND id_made != '{$_GET['user_id']}'";
$result = mysqli_query($conn, $sql);

// Display open challenges
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>";
        echo "Challenge by <a href='player.php?opponentId={$row['id_made']}'>{$row['name_made']}</a> - Value: {$row['value']}";
        echo " <form action='accept.php' method='post'>";
        echo " <input type='hidden' name='challengeId' value='{$row['id']}'>";
        echo "<input type='hidden' name='user_id' value='{$_GET['user_id']}'>";
        echo "<input type='hidden' name='username' value='{$_GET['username']}'>";
        echo " <button type='submit'>Accept Challenge</button>";
        echo " </form>";
        echo "</p>";
    }
} else {
    echo "No open challenges.";
}

// Close the database connection
mysqli_close($conn);
?>
