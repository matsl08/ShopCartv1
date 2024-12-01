<?php
include("db.php");
session_start(); // Start the session


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sofia:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="sign_up.css">
    <title>Seller Sign Up</title>
</head>
<body>
<div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="buyer_login.php">Buy Products</a>
    <a href="seller_login.php">Login</a>
</div>
<div class="container">
    <div class="box form-box">
        <div class="head">
            <header>Seller Sign Up</header>
        </div> 
      <?php  if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $connect->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Set temporary values for contact number and address
    $contact_number = ""; // Temporary value
    $address = ""; // Temporary value

    // Check if email already exists
    $accCheck = "SELECT * FROM sellers WHERE email = '$email'";
    $result = $connect->query($accCheck);

    if ($result->num_rows > 0) {
        echo "<div class='error-message'>Email already exists. Please choose a different email.</div>";
    } else {
        // Check if passwords match
        if ($password !== $confirm_password) {
            echo "<div class='error-message'>Passwords do not match. Please try again.</div>";        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and bind the SQL statement
            $stmt = $connect->prepare("INSERT INTO sellers (first_name, last_name, email, password, contact_number, address) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssssss", $first_name, $last_name, $email, $hashed_password, $contact_number, $address);

                // Execute the statement
                if ($stmt->execute()) {
                    $_SESSION['seller_id'] = $stmt->insert_id; 
                    $_SESSION['seller_name'] = $first_name . ' ' . $last_name;
                    $_SESSION['seller_email'] = $email;
                    $_SESSION['seller_contact_number'] = $contact_number; // Temporary value
                    $_SESSION['seller_address'] = $address; // Temporary value
                    header("Location: seller_login.php");
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
                <label for="first_name">First Name</label><br>
                <input type="text" id="first_name" name="first_name" required><br><br>
            </div>
            <div class="field input">
                <label for="last_name">Last Name</label><br>
                <input type="text" id="last_name" name="last_name" required><br><br>
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
            <!-- Hidden inputs for temporary values -->
            <input type="hidden" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>">
            <input type="hidden" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
            <div class="field">
                <input class="btn" type="submit" value="Sign Up"><br><br>
            </div>
            <label>Already have an account? <a href="seller_login.php">Login</a></label>
        </form>
    </div>
</div>
</body>
</html>
