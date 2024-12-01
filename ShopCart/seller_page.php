<?php
include("functions.php");
session_start();

    
// Check if the user is logged in
if (!isset($_SESSION['seller_id'])) {
    header("Location: seller_login.php"); // Redirect to login if not logged in
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sofia:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="seller_page.css">
    <title>Seller Page</title>
</head>
<body>

<div class="topnav">
    <h1><span>ShopCart</span></h1>
    <a href="seller_profile.php">Profile</a>
    <a href="buyer_page.php">Buy Products</a>
    <a href="log_out.php" name="log_out">Log Out</a>
</div>
<?php echo "<h4>Welcome, " . htmlspecialchars($_SESSION['seller_name']) . "!</h4>"; ?>
<div class="container">
    <div class="box form-box">
        <center><div class="head">
            <header>Add Product</header>
        </div></center>
        <form action="" method="post" enctype="multipart/form-data" >

            <div class="field input">
                <label for="item_name">Item Name</label><br>
                <input type="text" id="item_name" name="item_name" required><br><br>
            </div>

            <div class="field input">
                <label for="item_image">Item Image</label><br>
                <input type="file" id="item_image" name="item_image" accept="image/*" style="cursor: pointer;" required><br><br>
            </div>

            <div class="field input">
                <label for="item_desc">Item Description</label><br>
                <input type="text" id="item_desc" name="item_desc" required><br><br>
            </div>

            <div class="field input">
                <label for="item_price">Item Price</label><br>
                <input type="number" id="item_price" name="item_price" required><br><br>
            </div>

            <div class="field input">
                <label for="stocks">Stocks</label><br>
                <input type="number" id="stocks" name="stocks" required><br><br>
            </div>

            <div class="field input">
                <label for="product_category">Product Category</label><br>
                <input type="text" id="product_category" name="product_category" required><br><br>
            </div>

           <center><div class="field">
                <button class="btn" type="submit" value="Add Product">Add Product</button><br><br>
            </div></center> 
        </form>
    </div>
</div>

<h2>Products List</h2>
<table>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Item Image</th>
            <th>Item Description</th>
            <th>Item Price</th>
            <th>Item Quantity</th>
            <th>Product Category</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
  
    <?php
    // Instantiate Product class
$product = new Functions($connect);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $product->addProduct($_POST, $_FILES);
    if ($response === true) {
        
        echo "Product added successfully!";
    } else {
        echo $response;
    }
}
    $addedProducts = $product -> getProducts();
    while ($row = mysqli_fetch_assoc($addedProducts)) : ?>
        <tr>
                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td>
                    <img src="ShopCartv11/<?php echo htmlspecialchars($row['item_image']); ?>" alt="Item Image" style="width:100px;height:auto;">
                </td>
                <td><?php echo htmlspecialchars($row['item_desc']); ?></td>
                <td><?php echo "₱" . number_format($row['item_price'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['stocks']); ?></td>
                <td><?php echo htmlspecialchars($row['product_category']); ?></td>
                <td>
                <a href="edit_products.php?product_id=<?php echo $row['product_id']; ?>">
                    <button>Edit</button></a> 
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display:inline;">
                    
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </td>
        <?php

    

        
    // Handle delete product request
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $product_id = $_POST['product_id'];
    if ($product->deleteProduct($product_id)) {
        header("refresh: 0;");
    } else {
        echo "Error deleting product.";
    }
}

         // Handle edit product request
         if (isset($_POST['action']) && $_POST['action'] === 'edit') {
            $product_id = $_POST['product_id'];
            header("Location: edit_products.php");
            exit();
            
        }               

        ?>
        </tr>
        <?php endwhile; ?>

    </tbody>
    


</table>
</body>
</html>
