<?php
// Include the database connection and topic model
require_once 'db.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$topics = getTopics();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['topic_Id'])) { //The value of the topicId input is being set dynamically using $topic['_id'], which is being fetched from the $topics array using a foreach loop. However, the topicId input may not be present in the $_POST array when the form is submitted, which could be causing the "Undefined array key" error.

        // Get the topic ID
        $topicId = $_POST['topic_Id'];

        // Get the current user ID
        $userId = $_SESSION['user_id'];

        // Get the response content from the form
        $content = $_POST['content'];

        $topicUserId = $_POST['topicUserId'];

        $topicUserName = getUserNameById($topicUserId);

        if ($content != '') {
            // Create the new response
            createResponse($topicId, $userId, $content);
        };
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&display=swap" rel="stylesheet">
</head>

<body>
    <div class="header">
        <img src="./assets/forum-svgrepo-com.svg" alt="">
        <h1>The Forum</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="post-container">
        <?php foreach ($topics as $topic) : ?>

            <section class="topic">
                <img src="" alt="">
                <h1><?= $topic['title'] ?></h1>
                <p><?= $topic['description'] ?></p>
                <p id="author"><?= "by " . getUserNameById($topic['user_id']) ?></p>
                <div class="post-add">
                    <h4>Add a response</h4>
                    <form class="form-post display-none" method="POST">
                        <textarea name="content" rows="4" cols="50"></textarea>
                        <input type="hidden" name="topic_Id" value="<?= $topic['_id'] ?>">
                        <input type="hidden" name="topicUserId" value="<?= $topic['user_id'] ?>">
                        <input type="submit" value="submit">
                    </form>
                </div>



                <?php
                // Fetch responses for this topic
                $responsesByTopic = getResponsesByTopicId($topic['_id']);
                foreach ($responsesByTopic as $response) :
                ?>
                    <div class="response">
                        <p><?= $response['content'] ?></p>
                    </div>
                <?php endforeach; ?>
            </section>

        <?php endforeach; ?>

    </div>
    <!-- <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form> -->
</body>
<script type="text/javascript" src="js.js"></script>

</html>
