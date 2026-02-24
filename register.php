

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuvuke Pamoja - Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>

    <!-- Navbar -->
   

    <!-- Registration Form -->
    <section class="form-section">
        <div class="container">
            <h2>Create Your Account</h2>
            <p class="form-subtitle">Register to apply for a loan</p>

            <div class="form-card">
                <form action="join.php" method="POST">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="fullname" required placeholder="Enter your full name">
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" required placeholder="07XXXXXXXX">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required placeholder="Create password">
                    </div>

                    <button type="submit" class="btn-primary form-btn">Register</button>

                    <p class="form-info">
                        Already have an account? <a href="login.php">Login here</a>
                    </p>

                </form>
            </div>
        </div>
    </section>

</body>
</html>
