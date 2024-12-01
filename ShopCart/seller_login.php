<?php
include("functions.php");
session_start(); // Start the session

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Seller Login</title>
</head>
<body>

<div class="topnav">
    <h1><span>ShopCart</span></h1>  
    <a href="buyer_login.php">Buy Products</a>
    <a href="seller_sign_up.php">Sign Up</a>
</div>

<div class="container">
    <div class="box form-box">
        <div class="head">
            <header>Seller Login</header>
        </div> 

   <?php     
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shopcart";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Retrieve the input values from the form
    $email = $connect->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if the email exists
    $query = "SELECT seller_id, first_name, last_name, email, password, contact_number, address FROM sellers WHERE email = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stored_hashed_password = $user['password'];

        // Verify the password
        if (password_verify($password, $stored_hashed_password)) {
            // Store user details in the session
            $_SESSION['seller_id'] = $user['seller_id'];
            $_SESSION['seller_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['seller_email'] = $user['email'];
            $_SESSION['seller_contact_number'] = $user['contact_number'];
            $_SESSION['seller_address'] = $user['address'];

            header("Location: seller_page.php");
            exit();
        } else {
            echo "<div class='error-message'>Invalid password!</div>";
        }
    } else {
        echo "<div class='error-message'>No account found with this email. Please sign up.</div>";
    }

    $stmt->close();
    $connect->close();
} ?>

        <form action="" method="post">
            <div class="field input">
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" required><br><br>
            </div>
            <div class="field input">
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" required><br><br>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <p><?= htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <div class="field">
                <input class="btn" type="submit" value="Login"><br><br>
            </div>

            <label>Don't have an account? <a href="seller_sign_up.php">Sign Up</a></label>
        </form>
    </div>
</div>

</body>
</html>
