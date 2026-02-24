<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuvuke Pamoja - Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="form-container">
    <h2>Login</h2>

    <form action="login1.php" method="POST">
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>

</body>
</html>
