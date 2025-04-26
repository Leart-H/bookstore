<?php
session_start();
include 'db.php';




$sql = "SELECT orders.id, users.username, books.title, orders.quantity, orders.order_date 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        JOIN books ON orders.book_id = books.id 
        ORDER BY orders.order_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">📦 Orders Management</h1>

        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Book Title</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo htmlspecialchars($order['title']); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="admin_dashboard.php" class="btn btn-primary mt-3">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
