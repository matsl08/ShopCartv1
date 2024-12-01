<?php
include("db.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['buyer_id'])) {
    header("Location: buyer_login.php");
    exit();
}

// Sanitize session input
$buyer_id = filter_var($_SESSION['buyer_id'], FILTER_SANITIZE_NUMBER_INT);

// Retrieve the buyer's first and last name from the database
$query = "SELECT fname, lname, contact_number, email, address FROM buyers WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $buyer_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fname, $lname, $contact_number, $email, $address);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Concatenate fname and lname for display
$name = trim(htmlspecialchars($fname) . ' ' . htmlspecialchars($lname));

// Sanitize other output data
$contact_number = htmlspecialchars($contact_number);
$email = htmlspecialchars($email);
$address = htmlspecialchars($address);

// Check if profile is complete
$is_profile_complete = $name && $contact_number && $email && $address;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Buyer's Profile</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="seller_sign_up.php">Seller Centre</a>
    <a href="buyer_page.php">Buy Products</a>
    <a href="cart.php">Cart</a>
    <a href="log_out.php" name="log_out">Log Out</a>
    
<!-- Back Button -->
<div style="margin: 20px;">
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
</div>

<?php if (!$is_profile_complete): ?>
    <!-- Redirect to complete profile details -->
    <?php 
    header("Location: edit_buyer_profile.php");
    exit(); 
    ?>
<?php else: ?>
    <!-- Display profile details -->
    <div class="container">
    <div class="profile-details">
        <center><div class="heading">Profile</div></center>
        <p><strong>Full Name:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Contact Number:</strong> <?= htmlspecialchars($contact_number) ?></p>
        <p><strong>Email Address:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
    </div>
    <div style="margin-top: 20px;">
        <a href="edit_buyer_profile.php" class="btn">Edit Profile</a>
    </div>
    </div>
<?php endif; ?>

</body>
</html>