<?php
include("functions.php");
session_start(); // Start session at the top

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
if (!$is_profile_complete) {
    header("Location: buyer_profile.php?error=Please complete your profile to proceed.");
    exit();
}

if(isset($_POST["add_more_products"])) {
   header("Location: buyer_page.php");
   exit();
}



if (isset($_POST['order'])) {
   // Validate form inputs to avoid undefined array key warnings
   $_SESSION['name'] = $_POST['buyer_name'] ?? '';
   $_SESSION['contact_number'] = $_POST['contact_number'] ?? '';
   $_SESSION['email'] = $_POST['email'] ?? '';
   $_SESSION['payment_method'] = $_POST['payment_method'] ?? '';
   $_SESSION['address'] = $_POST['address'] ?? '';

   // Calculate total and product list from cart
   $cart_query = mysqli_query($connect, "SELECT * FROM `cart`");
   $price_total = 0;
   $product_name = [];

   while ($product_item = mysqli_fetch_assoc($cart_query)) {
       $product_name[] = $product_item['item_name'] . ' (' . $product_item['item_quantity'] . ')';
       $price_total += $product_item['item_price'] * $product_item['item_quantity'];

       // Update stock using prepared statement
       $update_stock_query = "UPDATE products SET stocks = stocks - ? WHERE item_name = ?";
       $stmt = mysqli_prepare($connect, $update_stock_query);
       mysqli_stmt_bind_param($stmt, 'is', $product_item['item_quantity'], $product_item['item_name']);
       mysqli_stmt_execute($stmt);
   }

   $_SESSION['total_product'] = implode(', ', $product_name);
   $_SESSION['price_total'] = $price_total;

   // Insert order details into the database using a prepared statement
   $insert_order = "INSERT INTO `orders` (name, contact_number, email, payment_method, address, total_products, total_price) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
   $stmt = mysqli_prepare($connect, $insert_order);
   mysqli_stmt_bind_param($stmt, 'sssssss', $name, $contact_number, 
                           $email, $_SESSION['payment_method'], $address, 
                          $_SESSION['total_product'], $_SESSION['price_total']);

   if (mysqli_stmt_execute($stmt)) {
       // Clear the cart after placing the order
       mysqli_query($connect, "DELETE FROM `cart`");
       header("Location: order_details.php");
       exit();
   } else {
       echo "<h3>Order failed. Please try again!</h3>";
   }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="checkout.css">

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

<div class="container">

<section class="checkout-form">

   <h1 class="heading">Complete Your Order</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($connect, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($row = mysqli_fetch_assoc($select_cart)){
            $total_price = $row['item_price'] * $row['item_quantity'];
            $grand_total = $total += $total_price;
      ?>
      <p><?= $row['item_name']; ?>(<?= $row['item_quantity']; ?>)</p>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> Grand Total: ₱<?= number_format($total, 2); ?> </span>
   </div>

<?php if (!$is_profile_complete): ?>
    <!-- Redirect to complete profile details -->
    <?php 
    header("Location: edit_buyer_profile.php");
    exit(); 
    ?>
<?php else: ?>
   <form action="" method="post">
 
    <!-- Display profile details -->
    <div class="profile-details">
        <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Contact Number:</strong> <?= htmlspecialchars($contact_number) ?></p>
        <p><strong>Email Address:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
    </div>
<?php endif; ?>
      <div class="inputBox">
         <span>Payment Method</span>
         <select name="payment_method">
            <option value="cash on delivery" selected>Cash on Delivery</option>
            <option value="credit card">Credit Card</option>
            <option value="gcash">Gcash</option>
         </select>
      </div>
      <div class="button_container">
      <input type="submit" value="Place Order" name="order" class="btn">
      <input type="submit" value="Add More Products" name="add_more_products" class="btn">
   </div>
   </div>
</form>
</section>
</div>
</body>
</html>