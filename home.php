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
            createResponds($topicId, $userId, $content);
            header('Location: home.php');
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
    <link rel="icon" href="./assets/favicon.png" /> 
</head>

<body>
    <?php
    include 'nav.php'
    ?>
    <div class="link">
        <a href="create-topic.php">Create a Topic</a>
    </div>
    <div class="post-container">
        <?php foreach ($topics as $topic) : ?>

            <section class="topic">
                <img src="" alt="">
                <h1><?= $topic['title'] ?></h1>
                <p><?= $topic['description'] ?></p>
                <p id="author"><?= "by " . getUserNameById($topic['user_id']) ?></p>
                <div class="post-add">
                    <div class="details">
                        <p><?= "Comment: ". getCountResponsesByTopicId($topic['_id'])?></p>
                        <h4 id="add-resp">click to respond</h4>
                    </div>
                    <form class="form-post display-none" action="home.php" method="POST">
                        <textarea name="content" rows="4" cols="50" placeholder="Write you comment..."></textarea>
                        <input type="hidden" name="topic_Id" value="<?= $topic['_id'] ?>">
                        <input type="hidden" name="topicUserId" value="<?= $topic['user_id'] ?>">
                        <input type="submit" value="submit">
                    </form>
                </div>
            </section>
            <section class="responses <?php if (empty(getRespondsByTopicId($topic['_id']))) {
                                            echo 'display-none';
                                        } ?>">

                <div class="response-block">
                    <?php
                    // Fetch responses for this topic
                    $responsesByTopic = getRespondsByTopicId($topic['_id']);
                    foreach ($responsesByTopic as $response) :
                    ?>
                        <div class="response">
                            <p>
                                <?= $response['content'] ?>

                            </p>
                            <span> by <?= getUserNameById($response['userId']) ?> </span>

                            <h4 id="add-resp-to-resp">click to respond</h4>
                            <form class="form-post-to-resp display-none" method="POST" action="create-topic.php">
                                <textarea name="content" rows="4" cols="50" placeholder="Write you comment..."></textarea>
                                <input type="hidden" name="topic_Id" value="<?= $topic['_id'] ?>">
                                <input type="hidden" name="topicUserId" value="<?= $topic['user_id'] ?>">
                                <input type="submit" value="submit">
                            </form>

                        </div>
                    <?php endforeach; ?>
                </div>

            </section>
        <?php endforeach; ?>

    </div>
</body>
<script type="text/javascript" src="js.js"></script>

</html>