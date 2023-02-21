<?php
// Include the database connection and topic model
require_once 'db.php';
// require_once 'topic.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


$topics = getTopics();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['topicId'])) { //The value of the topicId input is being set dynamically using $topic['_id'], which is being fetched from the $topics array using a foreach loop. However, the topicId input may not be present in the $_POST array when the form is submitted, which could be causing the "Undefined array key" error.

        // Get the topic ID
        $topicId = $_POST['topicId'];

        // Get the current user ID
        $userId = $_SESSION['user_id'];
        
        // Get the response content from the form
        $content = $_POST['content'];

        // Create the new response
        createResponse($topicId, $userId, $content);

        // // Redirect to this page to avoid form resubmission
        // header("Location: topic.php?id=$topicId");
        // exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Forum - Topic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./CSS/topic.css">
</head>

<body>
    <?php foreach ($topics as $topic) : ?>
        <h1><?= $topic['title'] ?></h1>
        <p><?= $topic['description'] ?></p>

        

        <h4>Add a response</h4>
        <form method="POST">
            <label for="content">Content:</label><br>
            <textarea name="content"></textarea><br><br>
            <input type="hidden" name="topicId" value="<?= $topic['_id'] ?>">
            <input type="submit" value="Submit">
        </form>
    <?php endforeach; ?>

    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>

</html>