<?php
//Inicializace session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Sphere Base</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <nav>
        <div class="text-xl font-semibold">Sphere Base</div>
        <div class="flex space-x-4">
            <a href="index.php#about">About Us</a>
            <a href="index.php#assortment">Assortment</a>
            <a href="index.php#future">Future</a>
            <a href="index.php#contacts">Contacts</a>
        </div>
        <div class="ml-4">
            <a href="cart.php">🛒</a>
        </div>
    </nav>
</header>

<div class="container">
    <div class="grid-container">
        <?php
        //Zobrazení položek ze session "cart" v košíku
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $item) {
                echo '<div class="grid-cell cart-item" data-product-id="' . htmlspecialchars($product_id) . '">';
                echo '<img src="' . htmlspecialchars($item["image_url"]) . '" alt="Product Image" class="product-image">';
                echo '<div class="product-info">';
                echo '<h3 class="product-title">' . htmlspecialchars($item["name"]) . '</h3>';
                echo '<p class="product-description">' . htmlspecialchars($item["description"]) . '</p>';
                echo '</div>';
                echo '<div class="quantity-selector">';
                echo '<button class="quantity-decrease">-</button>';
                echo '<input title="quantity" type="number" value="' . htmlspecialchars($item["quantity"]) . '" min="1" class="quantity-input">';
                echo '<button class="quantity-increase">+</button>';
                echo '</div>';
                echo '<div class="item-price-per-unit">$' . htmlspecialchars($item["price"]) . '</div>';
                echo '<div class="item-total-price">$' . number_format($item["price"] * $item["quantity"], 2) . '</div>';
                echo '<button class="remove-item">Remove</button>';
                echo '</div>';
            }
        } else {
            // V košíku není nic
            echo "Your cart is empty.";
        }
        ?>
    </div>

    <div class="cart-summary">
        <h3>Celkový souhrn</h3>
        <!-- Výpočet ceny a počtu kusů v košíku-->
        <p class="total-items">Počet položek: <span class="total-items-count"><?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?></span></p>
        <p class="total-price">Celkem: <span class="total-price-value">$<?php echo number_format(array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $_SESSION['cart'])), 2); ?></span></p>
        <button onclick="window.location.href='checkout.php';" class="checkout-button"> Pokračovat k platbě </button>
    </div>
</div>

<script>
    // Skript pro výpočet ceny a počtu celkových kusů po navýšení počtu kusů v košíku - proklik do PHP funkce
document.addEventListener('DOMContentLoaded', function () {
    const cartItems = document.querySelectorAll('.cart-item');

    function updateCartDisplay(data, item) {
        if (data.product_quantity === 0) {
            item.remove();
        } else {
            item.querySelector('.quantity-input').value = data.product_quantity;
            item.querySelector('.item-total-price').textContent = '$' + data.product_total_price;
        }
        document.querySelector('.total-items-count').textContent = data.total_items;
        document.querySelector('.total-price-value').textContent = '$' + data.total_price;

        if (data.cart_empty) {
            document.querySelector('.grid-container').innerHTML = 'Your cart is empty.';
        }
    }

    function sendUpdateRequest(productId, action, item) {
        fetch('update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'product_id': productId,
                'action': action
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                updateCartDisplay(data, item);
            } else {
                console.error('Error updating cart:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    cartItems.forEach((item) => {
        let productId = item.getAttribute('data-product-id');
        let decreaseButton = item.querySelector('.quantity-decrease');
        let increaseButton = item.querySelector('.quantity-increase');
        let removeButton = item.querySelector('.remove-item');

        decreaseButton.addEventListener('click', function () {
            sendUpdateRequest(productId, 'decrease', item);
        });

        increaseButton.addEventListener('click', function () {
            sendUpdateRequest(productId, 'increase', item);
        });

        removeButton.addEventListener('click', function () {
            sendUpdateRequest(productId, 'remove', item);
        });
    });
});
</script>

</body>
</html>
