<?php
session_start();

//Znovu výpočet ceny pro produkty v košíku při přidání nebo odebrání kusů
if (isset($_POST['product_id'], $_POST['action'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    if ($action === 'remove') {
        unset($_SESSION['cart'][$product_id]);
    } elseif (isset($_SESSION['cart'][$product_id])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } elseif ($action === 'decrease' && $_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity'] -= 1;
        }
    }

    //Spočítaní ceny 
    $total_items = 0;
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
        $total_price += $item['price'] * $item['quantity'];
    }

    //Vrátí nové výpočty
    echo json_encode([
        'total_items' => $total_items,
        'total_price' => number_format($total_price, 2),
        'product_quantity' => $_SESSION['cart'][$product_id]['quantity'] ?? 0,
        'product_total_price' => isset($_SESSION['cart'][$product_id]) ? number_format($_SESSION['cart'][$product_id]['price'] * $_SESSION['cart'][$product_id]['quantity'], 2) : 0,
        'cart_empty' => empty($_SESSION['cart'])
    ]);
    // Error
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
