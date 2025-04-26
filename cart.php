<?php
session_start();
include 'db.php'; 

if (empty($_SESSION['cart'])) {
    echo "<div class='container mt-5'><p class='alert alert-warning'>Your cart is empty.</p></div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<div class='container mt-5'><p class='alert alert-danger'>Please log in to place an order.</p></div>";
        exit;
    }
    
    $user_id = $_SESSION['user_id'];

    foreach ($_SESSION['cart'] as $item) {
        $book_id = $item['id'];
        $quantity = $item['quantity'];

        $stmt = $conn->prepare("INSERT INTO orders (user_id, book_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $book_id, $quantity);
        $stmt->execute();
    }

  
    $_SESSION['cart'] = [];

    echo "<div class='container mt-5'><p class='alert alert-success'>Order placed successfully!</p></div>";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
    $book_id = $_POST['book_id'];
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $book_id) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); 
            break;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $book_id = $_POST['book_id'];
    $new_quantity = max(1, intval($_POST['quantity']));

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $book_id) {
            $item['quantity'] = $new_quantity;
            break;
        }
    }
}

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">🛒 Your Shopping Cart</h1>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($_SESSION['cart'] as $item): 
                $total = $item['price'] * $item['quantity'];
                $total_price += $total;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="book_id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control d-inline w-50">
                            <button type="submit" name="update_quantity" class="btn btn-sm btn-warning">Update</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" name="remove" class="btn btn-sm btn-danger">❌ Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

        <h3 class="text-end">Total: $<?php echo number_format($total_price, 2); ?></h3>

        <div class="d-flex justify-content-between mt-4">
            <a href="dashboard.php" class="btn btn-outline-primary">⬅ Back to Shop</a>
            <form method="POST">
                <button type="submit" name="checkout" class="btn btn-success">✅ Checkout</button>
            </form>
        </div>
    </div>
</body>
</html>
