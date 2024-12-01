<?php
// Set the FPDF font path if you are using custom fonts
define('FPDF_FONTPATH', 'font/'); 

// Include necessary files
include("db.php");
require('fpdf.php'); // Ensure the FPDF path is correct for your project

ob_start(); // Start output buffering

// Check if all required parameters are provided
if (isset($_GET['name'], $_GET['payment_method'], $_GET['total_product'], $_GET['total_price'])) {
    $name = htmlspecialchars($_GET['name']);
    $payment_method = htmlspecialchars($_GET['payment_method']);
    $total_product = htmlspecialchars($_GET['total_product']);
    $total_price = htmlspecialchars($_GET['total_price']);

    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Title
    $pdf->Cell(0, 10, 'Order Receipt', 0, 1, 'C');
    $pdf->Ln(10); // Add a line break

    // Receipt Details Section
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Timestamp:', 0, 0);
    $pdf->Cell(0, 10, date("Y-m-d H:i:s"), 0, 1);

    $pdf->Cell(50, 10, 'Name:', 0, 0);
    $pdf->Cell(0, 10, $name, 0, 1);

    $pdf->Cell(50, 10, 'Payment Method:', 0, 0);
    $pdf->Cell(0, 10, $payment_method, 0, 1);

    $pdf->Cell(50, 10, 'Total Products:', 0, 0);
    $pdf->Cell(0, 10, $total_product, 0, 1);

    $pdf->Cell(50, 10, 'Total Price:', 0, 0);
    $pdf->Cell(0, 10, 'P' . number_format($total_price, 2), 0, 1);

    // Footer Section
    $pdf->SetY(-30); // Position at 3 cm from the bottom
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Thank you for shopping with ShopCart!', 0, 1, 'C');

    // Output the PDF to the browser
    $pdf->Output('I', 'receipt.pdf'); // 'I' to display in the browser, 'D' for download
    ob_end_flush(); // End output buffering
} else {
    // Error message if required parameters are missing
    echo "Invalid order details!";
    exit;
}
?>
