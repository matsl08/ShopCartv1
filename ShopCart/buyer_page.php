<?php
include("functions.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['buyer_id'])) {
    header("Location: buyer_login.php"); // Redirect to login if not logged in
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = new Functions($connect);
    $response = $product->addToCart();

    if ($response === true) {
        echo "<div class='success-message'>Product added to cart successfully!</div>";
    } else {
        $_SESSION['message'] = $response; // e.g., "Product already in the cart."
    }

    // Redirect to the same page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// If there's a message, refresh the page after 3 seconds
if (isset($_SESSION['message'])) {
    // Send refresh header with 3-second delay
    header("Refresh: 3; URL=" . $_SERVER['PHP_SELF']);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="buyer_page.css">
    <title>Buyer Page</title>

<div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="seller_sign_up.php">Seller Centre</a>
    <a href="buyer_profile.php" name="buyer_profile">Profile</a>
    <a href="cart.php">Cart</a>
    <a href="log_out.php" name="log_out">Log Out</a>
</div>
<div class="user_header">
<?php echo "<h4>Welcome, " . htmlspecialchars($_SESSION['buyer_name']) . "!</h4>"; ?>
</div>
</head>
<body>

<center>
<!-- Products List -->
<div class="content">
    <h2>Products List</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class='order-message-container'>
            <div class='message-container'>
                <h3><?= htmlspecialchars($_SESSION['message']); ?></h3>
            </div>
        </div>
        <?php unset($_SESSION['message']); // Clear the message after displaying ?>
    <?php endif; ?>

    <?php
    $product = new Functions($connect);
    $addedProducts = $product->getProducts();

    while ($row = mysqli_fetch_assoc($addedProducts)) : ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display:inline;">
            <div class="gallery">
                <img src="ShopCartv11/<?php echo htmlspecialchars($row['item_image']); ?>" alt="Product Image">
                <p class="desc"><?php echo htmlspecialchars($row['item_name']); ?></p>
                <p class="itemPrice"><?php echo "₱" . number_format($row['item_price'], 2); ?></p>
                <p class="itemDesc"><?php echo htmlspecialchars($row['item_desc']); ?></p>
                <p class="itemQty"><?php echo "Stocks: " . htmlspecialchars($row['stocks']); ?></p>

                <input type="hidden" name="item_price" value="<?php echo $row['item_price']; ?>">
                <input type="hidden" name="item_name" value="<?php echo $row['item_name']; ?>">
                <input type="hidden" name="item_image" value="<?php echo $row['item_image']; ?>">
                <input type="submit" class="btn" value="Add To Cart" name="add_to_cart">
            </div>
        </form>
    <?php endwhile; ?>

</div>
<?php if (isset($_POST['add_to_cart'])) {
        echo "<div class='success-message'>Product added to cart successfully!</div>";
        header("refresh: 2;");
        exit();
} ?>
</center>
</body>
</html>
