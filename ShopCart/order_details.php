<?php
include("functions.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['buyer_id'])) {
    header("Location: buyer_login.php");
    exit();
}

// Ensure order details are available
if (!isset($_SESSION['email']) || !isset($_SESSION['total_product'])) {
    header("Location: buyer_login.php");
    exit();
}

// Get the email from session
$email = $_SESSION['email'];
$contact_number = $_SESSION['contact_number'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Success</title>
    <link rel="stylesheet" href="order_details.css">
</head>
<body>
    
<div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="seller_sign_up.php">Seller Centre</a>
    <a href="buyer_page.php">Buy Products</a>
    <a href="buyer_profile.php" name="buyer_profile">Profile</a>
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
    <div class='order-message-container'>
        <div class='message-container'>
            <?php echo "<h1>Thank You for shopping, " . htmlspecialchars($_SESSION['buyer_name']) . "!</h1>"; ?>
            <div class='order-detail'>
                <?php
                $query = "SELECT total_products, total_price FROM `orders` WHERE email = ? ORDER BY order_id DESC LIMIT 1";
                $stmt = mysqli_prepare($connect, $query);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $total_products =  $_SESSION['total_product'];
                    $total_price =  $_SESSION['price_total'];
                    ?>
                    <?php
                } else {
                    echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                }
                mysqli_stmt_close($stmt);
                ?>
            </div>
            
            <a href="download_receipt.php?
                name=<?= urlencode($_SESSION['buyer_name']); ?>&
                payment_method=<?= urlencode($_SESSION['payment_method']); ?>&
                total_product=<?= urlencode($total_products); ?>&
                total_price=<?= urlencode($total_price); ?>" 
                class="btn" name="view_receipt">View Receipt</a>
            <a href='buyer_page.php' class='btn'>Continue Shopping</a>
        </div>
    </div>
</body>
</html>
