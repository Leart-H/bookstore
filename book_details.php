<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
    }
} else {
    echo "Invalid or missing book ID.";
    exit;
}

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $cart_item = [
        'id' => $book['id'],
        'title' => $book['title'],
        'price' => $book['price'],
        'quantity' => 1, 
    ];

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $book['id']) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = $cart_item;
    }

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .book-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }
        .book-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-custom {
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            transform: scale(1.05);
        }
        .book-image {
            max-height: 400px;
            width: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="book-card text-center">
                    <h1 class="mb-4"> <?php echo htmlspecialchars($book['title']); ?> </h1>
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <img src="<?php echo htmlspecialchars($book['image_url']); ?>" class="img-fluid book-image" alt="Book Image">
                        </div>
                        <div class="col-md-7 text-start">
                            <h4 class="mb-3">Author: <span class="text-primary"> <?php echo htmlspecialchars($book['author']); ?> </span></h4>
                            <p><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                            <h5 class="mt-3"><strong>Price: $<?php echo number_format($book['price'], 2); ?></strong></h5>
                            <form method="POST">
                                <button type="submit" name="add_to_cart" class="btn btn-success btn-lg btn-custom mt-3">🛒 Add to Cart</button>
                            </form>
                            <a href="dashboard.php" class="btn btn-outline-primary btn-lg btn-custom mt-3">⬅ Back to Books List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>