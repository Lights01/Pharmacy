<?php
session_start();
include('include/db.php'); // Ensure this file exists and sets up $pdo correctly

// Define constants for HTML
define('SITE_TITLE', 'Modern Login Page | AsmrProg');
define('FAVICON_PATH', '../photos/PHARMA_small.png');
define('CSS_PATH', 'css/login.css');
define('FONT_AWESOME_CSS', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'sign-up') {
        // Handle signup form submission
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (NAME, email, PASSWORD) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashed_password]);
            $user = $stmt->fetch();

            echo "<script>alert('Registration successful! Please log in.');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Handle login form submission
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Query the database for the user with the given email
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Verify the password if a user was found
            if ($user && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
          

                // Redirect to the home page
                header("Location: index.php");
                exit;
            } else {
                // Invalid credentials
                echo "<script>alert('Invalid email or password');</script>";
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/png" href="<?= FAVICON_PATH ?>" />
  <link rel="stylesheet" href="<?= FONT_AWESOME_CSS ?>" />
  <link rel="stylesheet" href="<?= CSS_PATH ?>" />
  <title><?= SITE_TITLE ?></title>
  </head>

  <body>
  <div class="container" id="container">
    <!-- Sign Up Form -->
    <div class="form-container sign-up">
  <form method="POST" action="sign-up">
    <h1>Create Account</h1>
    <input type="text" id = "name" name="name" placeholder="Name" required />
    <input type="email" id = "name" name="email" placeholder="Email" required />
    <input type="password" id = "name" name="password" placeholder="Password" required />
    <span class="error-signUp"></span>
    <button type="submit">Sign Up</button>
    <!-- <input type="hidden" name="action" value="sign-up" /> -->
    <span>or register with social media platform</span>
    <div class="social-icons">
      <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
      <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
      </form>
    </div>
</div>

    <!-- Sign In Form -->
    <div class="form-container sign-in">
  <form method="POST" action="">
    <h1>Sign In</h1>
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <span class="error-signIn"></span>
    <a href="#">Forget Your Password?</a>
    <button type="submit">Sign In</button>
    <!-- <input type="hidden" name="action" value="login" /> -->
    <span>or use other platform</span>
    <div class="social-icons">
      <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
      <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
    </div>
  </form>
</div>

    <!-- Toggle Container -->
    <div class="toggle-container">
    <div class="toggle">
      <div class="toggle-panel toggle-left">
      <h1>Welcome Back!</h1>
      <p>Enter your personal details to use all of site features</p>
      <button class="hidden" id="login">Sign In</button>
      </div>
      <div class="toggle-panel toggle-right">
      <h1>Hello, Friend!</h1>
      <p>
        The best day to join Hamro App was one year ago. The second best
        is today!
      </p>
      <button class="hidden" id="register">Sign Up</button>
      </div>
    </div>
    </div>
  </div>

  <script src="login.js"></script>
  </body>
</html>
