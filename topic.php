<?php
    include 'db.php';
?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Create the topic
    $topicId = createTopic($title, $description, $userId);

    // Redirect to the topic page
    header("Location: topic.php?id=$topicId");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a topic</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form class="create-topic-form" action="topic.php" method="post">
        <h2>Create a topic</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit">Create</button>
    </form>
</body>
</html>