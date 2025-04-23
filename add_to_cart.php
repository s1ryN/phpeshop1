<?php
session_start();

// Přidání do košíku využitím session - kontrola jestli jsou data zadané
if (isset($_POST['product_id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['image_url'])) {
    // Převzetí HTML proměnných do PHP
    $product_id = $_POST['product_id'];
    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    $product_image_url = $_POST['image_url'];
    $product_quantity = 1; //Základní počet

    // Pokud již není vytvořena session proměnná "cart", vytvoří ji
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    //Podívá se jestli produkt už není v košíku
    if (isset($_SESSION['cart'][$product_id])) {
        // Pokud je znovu položka přidána do košíku, tak jí připočte počet kusů
        $_SESSION['cart'][$product_id]['quantity'] += $product_quantity;
    } else {
        // Uložení produktu do session proměnné košík
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'description' => $product_description,
            'price' => $product_price,
            'image_url' => $product_image_url,
            'quantity' => $product_quantity
        ];
    }

    // Odeslání uživatele do košíku po přidání produktu
    header("Location: cart.php");
    exit();
} else {
    echo "Required data is missing.";
}
?>
