<?php
    require_once 'db.php';
    
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
    


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Create the topic
    $topicId = createTopic($title, $description, $userId);

    // Redirect to the topic page
    header("Location: home.php");
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
    <link rel="stylesheet" type="text/css" href="./CSS/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&display=swap" rel="stylesheet">
    <link rel="icon" href="./assets/favicon.png" /> 
</head>
<body>
    <?php 
        include 'nav.php'
    ?>
    <form class="create-topic-form" action="create-topic.php" method="post">
        <h1>Create a topic</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" maxlength="500" required></textarea>
        <button type="submit">Create</button>
    </form>
    <a href="home.php">return to home</a>
</body>
</html>