<?php

// Připojení konektoru
require 'conn.php';

// Select věcí ohledně produktů z DB
$sql = "SELECT id, name, description, price, image_url FROM products";
$result = $conn->query($sql);

// Zobrazení výsledků
// Nastavení zobrazení přes HTML
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="grid-cell">';
        echo '<img src="' . htmlspecialchars($row["image_url"]) . '" alt="Product Image" class="product-image">';
        echo '<div class="product-info">';
        echo '<h3 class="product-title">' . htmlspecialchars($row["name"]) . '</h3>';
        echo '<p class="product-description">' . htmlspecialchars($row["description"]) . '</p>';
        echo '</div>';
        echo '<div class="product-additional-info">';
        echo '<div>';
        echo '<p>Price: $' . htmlspecialchars($row["price"]) . '</p>';
        echo '<p class="text-sm">Available for shipping in 4 days</p>';
        echo '</div>';
        echo '<form action="add_to_cart.php" method="post">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row["id"]) . '">';
        echo '<input type="hidden" name="name" value="' . htmlspecialchars($row["name"]) . '">';
        echo '<input type="hidden" name="description" value="' . htmlspecialchars($row["description"]) . '">';
        echo '<input type="hidden" name="price" value="' . htmlspecialchars($row["price"]) . '">';
        echo '<input type="hidden" name="image_url" value="' . htmlspecialchars($row["image_url"]) . '">';
        echo '<button type="submit">Přidat do košíku</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
// Pokud nenajde výsledky
} else {
    echo "0 results";
}
$conn->close();
?>
