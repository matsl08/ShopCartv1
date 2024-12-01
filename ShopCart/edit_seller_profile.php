<?php
include("db.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['seller_id'])) {
    header("Location: seller_login.php"); // Redirect to login if not logged in
    exit();
}

if (isset($_POST['update_details'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $contact_number = mysqli_real_escape_string($connect, $_POST['contact_number']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);

    // Update seller details using prepared statements to prevent SQL injection
    $query = "UPDATE `sellers` SET contact_number = ?, address = ? WHERE email = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "iss", $contact_number, $address, $email);

    if (mysqli_stmt_execute($stmt)) {
        // Store updated details in session
        $_SESSION['name'] = $name;
        $_SESSION['contact_number'] = $contact_number;
        $_SESSION['email'] = $email;
        $_SESSION['address'] = $address;

        // Redirect to seller_profile.php
        header("Location: seller_profile.php");
        exit;
    } else {
        echo "<h3>Submission of details failed. Please try again!</h3>";
    }

    mysqli_stmt_close($stmt); // Close the prepared statement
}


if (isset($_GET['error'])) {
    echo "<div class='error-message'>" . htmlspecialchars($_GET['error']) . "</div>";
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Seller's Profile</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="edit_profile.css">

   <div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="seller_page.php">Products</a>
    <a href="buyer_page.php">Buy Products</a>
    <a href="log_out.php" name="log_out">Log Out</a>
    
    <!-- Back Button -->
    <?php
    // Check if the referrer is available
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        echo '<a href="' . htmlspecialchars($previousPage) . '" class="back-button">⬅ Back</a>';
    } else {
        echo '<a href="#" class="back-button disabled">⬅ Back</a>';
    }
    ?>
</div>
</head>
<body>
<div class="container">
<center><div class="heading">Edit Profile</div></center>
<form action="" method="post">
    <div class="flex">
        <div class="inputBox">
            <span>Full Name</span>
            <input type="text" placeholder="Enter your name" name="name" value="<?= htmlspecialchars($_SESSION['seller_name']) ?? '' ?>" required>
        </div>
        <div class="inputBox">
            <span>Contact Number</span>
            <input type="number" placeholder="Enter your number" name="contact_number" value="<?=htmlspecialchars($_SESSION['seller_contact_number']) ?? '' ?>"  required>
        </div>
        <div class="inputBox">
            <span>Email Address</span>
            <input type="email" placeholder="Enter your email" name="email" value="<?= htmlspecialchars($_SESSION['seller_email']) ?? '' ?>" required>
        </div>
        <div class="inputBox">
            <span>Address</span>
            <input type="text" placeholder="Enter your address" name="address" value="<?= htmlspecialchars($_SESSION['seller_address']) ?? '' ?>"  required>
        </div>
    </div>
    <input type="submit" value="Update Details" name="update_details" class="btn">
</form>
</div>
</body>
</html>