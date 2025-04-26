<?php
session_start();
include 'db.php';

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .book-card {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .book-card:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .book-image {
            height: 200px;
            object-fit: cover;
        }
        .navbar {
            background: #343a40;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-white" href="#">📚 Online Bookstore</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">📖 Available Books</h1>
        <p class="text-center">Explore our collection and add books to your cart!</p>

        <div class="row">
            <?php while ($book = $result->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card book-card h-100">
                        <img src="<?php echo htmlspecialchars($book['image_url']); ?>" class="card-img-top book-image" alt="Book Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                            <p class="card-text"><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                            <p class="card-text"><strong>Price:</strong> $<?php echo number_format($book['price'], 2); ?></p>
                            <div class="d-flex justify-content-between">
                                <a href="book_details.php?id=<?php echo $book['id']; ?>" class="btn btn-outline-primary">View Details</a>
                                <form method="POST" action="book_details.php?id=<?php echo $book['id']; ?>">
                                    <button type="submit" name="add_to_cart" class="btn btn-success">🛒 Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
