<?php
include 'db.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    
    $sql = "DELETE FROM orders WHERE book_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    if ($stmt->execute()) {
        
        $stmt->free_result();
    } else {
        echo "Error deleting related orders.";
        exit;
    }

 
    $sql = "DELETE FROM books WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error deleting book.";
    }
}
$stmt->store_result(); 
$stmt->free_result();
?>

