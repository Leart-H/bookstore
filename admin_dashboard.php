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
    <title>Admin Dashboard</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .book-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        .book-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .btn-custom {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<a href="admin_orders.php" class="btn btn-info">📦 View Orders</a>

    <div class="container mt-5">
        <h1 class="text-center">📚 Admin Dashboard</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <a href="add_book.php" class="btn btn-success">➕ Add New Book</a>
        
        <div class="row mt-4">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="book-card">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="book-image" alt="Book Image">
                        <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                        
                        <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-custom">✏ Edit</a>
                        <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-custom" onclick="return confirm('Are you sure?');">🗑 Delete</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
