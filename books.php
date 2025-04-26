<?php

include 'db.php';

$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['title'] . "</h3>";
        
      
        echo "<a href='book_details.php?id=" . $row['id'] . "'>";
        echo "<img src='" . $row['image_url'] . "' alt='" . $row['title'] . "'>";
        echo "</a>";
        
        echo "</div>";
    }
}

?>

<style>
    img {
        width: 50%;
    }
</style>
