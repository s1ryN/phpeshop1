<?php
session_start();

// Logika pro objednání
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Spojení s connem
    require 'conn.php';

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $card = $_POST['cardd'];
    $cvv = $_POST['cvv'];
    $expire = $_POST['expire'];
    $shipping_id = $_POST['shipping_id'];
    $payment_id = $_POST['payment_id'];
    $total_price = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));
    $order_date = date('Y-m-d H:i:s');

    // Vložení objednávky do tabulky "orders"
    $stmt = $conn->prepare("INSERT INTO orders (name, surname, city, street, cardd, cvv, expiry, shipping_idshipping, payments_idpayments, order_date, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssisiisd", $name, $surname, $city, $street, $card, $cvv, $expire, $shipping_id, $payment_id, $order_date, $total_price);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Vložení předmětů z objednávky do tabulky "order_items"
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $stmt->bind_param("iii", $order_id, $product_id, $item['quantity']);
            $stmt->execute();
        }

        // Resetování session "cart"
        unset($_SESSION['cart']);

        // Odkázání na success page v případě úspěchu/pokud se nepovede odeslat stránka pošle error
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: checkout.php");
    exit();
}
?>
