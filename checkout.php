<?php
// Spojení s connem
require 'conn.php';

// Pokus o připojení
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kontrola jestli je něco v košíku
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Select pro možnosti dole
$shipping_options = $conn->query("SELECT idshipping, name FROM shipping");
$payment_options = $conn->query("SELECT idpayments, name FROM payments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Sphere Base</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <nav>
        <div class="text-xl font-semibold">Sphere Base</div>
        <div class="flex space-x-4">
            <a href="index.php">Home</a>
            <a href="index.php#assortment">Assortment</a>
            <a href="index.php#about">About Us</a>
            <a href="index.php#contacts">Contacts</a>
        </div>
        <div class="ml-4">
            <a href="cart.php">🛒</a>
        </div>
    </nav>
</header>

<main>
    <div class="container">
        <h1 class="checkout-title">Checkout</h1>
        <form class="checkout-form" method="post" action="order.php">
            <!-- Fakturační údaje -->
            <section class="billing-info">
                <h2>Billing Information</h2>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="city">City</label>
                <input type="text" id="city" name="city" required>

                <label for="street">Street and number of descriptive</label>
                <input type="text" id="street" name="street" required>
            </section>

            <section class="payment-info">
                <h2>Payment Info</h2>
                <label for="cardd">Credit card number</label>
                <input type="text" id="cardd" name="cardd" required>

                <label for="cvv">CVV</label>
                <input type="number" id="cvv" name="cvv" required>

                <label for="expire">Expiry date</label>
                <input type="text" id="expire" name="expire" required>
            </section>

            <!-- Možnosti platby/načtení těchto možností z DB -->
            <section class="payment-options">
                <h2>Payment Options</h2>
                <?php while ($payment = $payment_options->fetch_assoc()): ?>
                    <div>
                        <input type="radio" id="payment-<?php echo $payment['idpayments']; ?>" name="payment_id" value="<?php echo $payment['idpayments']; ?>" required>
                        <label for="payment-<?php echo $payment['idpayments']; ?>"><?php echo htmlspecialchars($payment['name']); ?></label>
                    </div>
                <?php endwhile; ?>
            </section>

            <!-- Možnosti dopravy/načtení těchto možností z DB -->
            <section class="shipping-options">
                <h2>Shipping Options</h2>
                <?php while ($shipping = $shipping_options->fetch_assoc()): ?>
                    <div>
                        <input type="radio" id="shipping-<?php echo $shipping['idshipping']; ?>" name="shipping_id" value="<?php echo $shipping['idshipping']; ?>" required>
                        <label for="shipping-<?php echo $shipping['idshipping']; ?>"><?php echo htmlspecialchars($shipping['name']); ?></label>
                    </div>
                <?php endwhile; ?>
            </section>

            <button type="submit" class="submit-order">Submit Order</button>
        </form>
    </div>
</main>

</body>
</html>
<?php
$conn->close();
?>
