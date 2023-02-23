<?php
    include 'db.php';
?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Authenticate the user
    $userId = authenticateUser($email, $password);

    if ($userId) {
        // Set the user ID in the session
        $_SESSION['user_id'] = $userId;

        // Redirect to the home page
        header('Location: get_topic.php');
        exit;
    } else {
        // Show an error message
        $errorMessage = 'Invalid email or password';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./CSS/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&display=swap" rel="stylesheet">
    
    
</head>
<body>
    <form class="login-form" action="login.php" method="post">
        <h2>Login</h2>
        <?php if (isset($errorMessage)): ?>
            <div class="error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Enter</button>
        <p class="message">Not registered? <a href="register.php">Create an account</a></p>
    </form>
</body>
</html>
