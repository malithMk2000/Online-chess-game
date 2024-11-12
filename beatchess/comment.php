<?php
// Include the database configuration file
include 'config.php';

$userId = $_GET['userId'];
// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$userId = $_POST['userId'];
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    // Insert the new comment into the database
    $stmt = $pdo->prepare("INSERT INTO comments (userId, username, comment) VALUES (:userId, :username, :comment)");
    $stmt->execute(['userId' => $userId, 'username' => $username, 'comment' => $comment]);

    // Redirect to avoid form resubmission on page refresh
    header('Location: comment.php');
    exit;
}

// Retrieve all comments from the database
$stmt = $pdo->query("SELECT * FROM comments ORDER BY created_at DESC");
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments - BeatChess</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .comment {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .comment h3 {
            margin: 0;
            color: darkblue;
        }
        .comment p {
            margin: 5px 0;
            color: #555;
        }
        .comment small {
            color: #999;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input[type="text"], textarea {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: darkblue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>User Comments</h1>

    <!-- Display all comments -->
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <h3><?= htmlspecialchars($comment['username']) ?></h3>
            <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
            <small>Posted on <?= $comment['created_at'] ?></small>
        </div>
    <?php endforeach; ?>

    <hr>

    <!-- Comment submission form -->
    <form method="POST" action="">
        <input type="text" name="userId" placeholder="Your User ID" required>
        <input type="text" name="username" placeholder="Your Username" required>
        <textarea name="comment" rows="4" placeholder="Write your comment here..." required></textarea>
        <input type="submit" value="Submit Comment">
    </form>
</div>

</body>
</html>
