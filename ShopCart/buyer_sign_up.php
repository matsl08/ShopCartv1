<?php
include("db.php");
session_start(); // Start the session


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="sign_up.css">
    <title>Buyer Sign Up</title>
</head>
<body>
<div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="seller_login.php">Seller Centre</a>
    <a href="buyer_login.php">Login</a>
</div>
<div class="container">
    <div class="box form-box">
        <div class="head">
            <header>Sign Up</header>
        </div> 
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "shopcart";
        
            $connect = new mysqli($servername, $username, $password, $dbname);
        
            // Check connection
            if ($connect->connect_error) {
                die("Connection failed: " . $connect->connect_error);
            }
        
            // Get the form data
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $connect->real_escape_string($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $contact_number = ""; // Temporary value
            $address = ""; // Temporary value
        
            // Check if email already exists
            $accCheck = "SELECT * FROM buyers WHERE email = '$email'";
            $result = $connect->query($accCheck);
        
            if ($result->num_rows > 0) {
                echo "<div class='error-message'>Email already exists. Please choose a different email.</div>";
            } else {
                // Check if passwords match
                if ($password !== $confirm_password) {
                    echo "<div class='error-message'>Passwords do not match. Please try again.</div>";
                } else {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
                    // Prepare and bind the SQL statement
                    $stmt = $connect->prepare("INSERT INTO buyers (fname, lname, email, password) VALUES (?, ?, ?, ?)");
                    if ($stmt) {
                        $stmt->bind_param("ssss", $fname, $lname, $email, $hashed_password);
        
                        // Execute the statement
                        if ($stmt->execute()) {
                            $_SESSION['buyer_id'] = $stmt->insert_id; 
                            $_SESSION['buyer_name'] = $fname . ' ' . $lname;
                            $_SESSION['buyer_email'] = $email;
                            $_SESSION['buyer_contact_number'] = $user['contact_number'];
                            $_SESSION['buyer_address'] = $user['address'];
                            header("Location: buyer_login.php");
                            exit();
                        } else {
                            echo "Error: " . $stmt->error;
                        }
                        $stmt->close();
                    } else {
                        echo "Error preparing SQL: " . $connect->error;
                    }
                }
            }
            $connect->close();
        }


        ?>

        <form action="" method="post"> <!-- Keep action empty to post to the same page -->
            <div class="field input">
                <label for="fname">First Name</label><br>
                <input type="text" id="fname" name="fname" required><br><br>
            </div>
            <div class="field input">
                <label for="lname">Last Name</label><br>
                <input type="text" id="lname" name="lname" required><br><br>
            </div>
            <div class="field input">
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" required><br><br>
            </div>
            <div class="field input">
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" required><br><br>
            </div>
            <div class="field input">
                <label for="confirm_password">Confirm Password</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            </div>
            <div class="field">
                <input class="btn" type="submit" value="Sign Up"><br><br>
            </div>
            <!-- Hidden inputs for temporary values -->
            <input type="hidden" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>">
            <input type="hidden" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
            <label>Already have an account? <a href="buyer_login.php">Login</a></label>
        </form>
    </div>
</div>
</body>
</html>
