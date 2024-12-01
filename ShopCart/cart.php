<?php
ob_start(); // Start buffering
include("functions.php");
session_start();

$grand_total = 0;
$cart_empty = true;  // Assume cart is empty by default

// Check if the user is logged in
if (!isset($_SESSION['buyer_id'])) {
    header("Location: buyer_login.php");
    exit();
}

// Database connection (replace as per your setup)
$buyer_id = $_SESSION['buyer_id'];


// Handle other cart operations (update, remove, delete all, etc.)
if (isset($_POST['update'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_sql = "UPDATE `cart` SET item_quantity = ? WHERE product_id = ?";
    $stmt = mysqli_prepare($connect, $update_sql);
    mysqli_stmt_bind_param($stmt, 'ii', $update_value, $update_id);
    mysqli_stmt_execute($stmt);
    header("Location: cart.php");
    exit();
}

if (isset($_POST['remove'])) {
    $remove_id = $_POST['remove_id'];
    $delete_query = "DELETE FROM `cart` WHERE product_id = ?";
    $stmt = mysqli_prepare($connect, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $remove_id);
    mysqli_stmt_execute($stmt);
    header("Location: cart.php");
    exit();
}

if (isset($_POST['delete_all'])) {
    mysqli_query($connect, "DELETE FROM cart");
    header("Location: cart.php");
    exit();
}

// Fetch cart products
$product = new Functions($connect);
$addedProductsToCart = $product->getProductsAddedToCart();
$cart_empty = mysqli_num_rows($addedProductsToCart) === 0; // Check if cart is empty
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cart.css">
    <title>Cart</title>
</head>
<body>

<div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="seller_sign_up.php">Seller Centre</a>
    <a href="buyer_page.php">Buy Products</a>
    <a href="buyer_profile.php" name="buyer_profile">Profile</a>
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
<center>
<h2 class="heading">Cart</h2>

<?php if (isset($_GET['error'])): ?>
    <div class="error-message">
        <p><?= htmlspecialchars($_GET['error']); ?></p>
    </div>
<?php endif; ?>

<table border="1">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Item Image</th>
            <th>Item Price</th>
            <th>Item Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($addedProductsToCart)): 
        $sub_total = $row['item_price'] * $row['item_quantity'];
        $grand_total += $sub_total;
    ?>
        <tr>
            <td><?= htmlspecialchars($row['item_name']); ?></td>
            <td>
                <img src="ShopCartv11/<?= htmlspecialchars($row['item_image']); ?>" 
                     alt="Item Image" style="width:100px;height:auto;">
            </td>
            <td><?= "₱" . number_format($row['item_price'], 2); ?></td>

            <td>
                <form action="cart.php" method="post">
                    <input type="number" name="update_quantity" min="1" 
                           value="<?= $row['item_quantity']; ?>" required>
                    <input type="hidden" name="update_quantity_id" value="<?= $row['product_id']; ?>">
                    <input type="submit" class="btn_update" name="update" value="Update">
                </form>
            </td>

            <td><?= "₱" . number_format($sub_total, 2); ?></td>

            <td>
                <form action="cart.php" method="post">
                    <input type="hidden" name="remove_id" value="<?= $row['product_id']; ?>">
                    <input type="submit" class="btn_remove" value="Remove" name="remove">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>

    <tr class="table-bottom">
        <td>
            <form action="buyer_page.php" method="post">
                <input type="submit" class="btn" value="Continue Shopping">
            </form>
        </td>
        <td colspan="3">Grand Total</td>
        <td><?= "₱" . number_format($grand_total, 2); ?></td>
        <td>
            <form action="cart.php" method="post">
                <input type="submit" class="btn_delete_all" name="delete_all" value="Delete All">
            </form>
        </td>
    </tr>
    </tbody>
</table>

<br><br>
<div class="checkout-btn">
    <form action="" method="post">
    <input class="btn" type="submit" name="checkout" value="Proceed to Checkout">
    <?php 
        if (isset($_POST['checkout'])) {
            if ($cart_empty){
                echo "<div class='error-message'>Your cart is empty! Please add items to proceed.</div>";
            } else {
                header("Location: checkout.php");
                exit();
            }
        }
    ?>
    </form>
</div>

</center>
<?php ob_end_flush(); ?>
</body>
</html>
