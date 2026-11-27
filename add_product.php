<?php
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name'] ?? '');
    $brand        = trim($_POST['brand'] ?? '');
    $category     = trim($_POST['category'] ?? '');
    $price        = (int)($_POST['price'] ?? 0);
    $size         = trim($_POST['size'] ?? '');
    $color        = trim($_POST['color'] ?? '');
    $stock        = (int)($_POST['stock'] ?? 0);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO `products` (`product_name`, `brand`, `category`, `price`, `size`, `color`, `stock`) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "sssissi", $product_name, $brand, $category, $price, $size, $color, $stock);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KEEPly | Add Product</title>
    <link rel="stylesheet" href="Assets/css/style.css?v=1">
</head>
<body>

<header class="store-header">
    <h1>KEEPly.</h1>
    <a href="index.php">Back to Collection</a>
</header>

<main class="store-container">
    <section class="collection-heading">
        <h2>Add New Product</h2>
        <p>Add a new fashion piece to the KEEPly catalog.</p>
    </section>

    <form method="POST" class="form-card">
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" required>
        </div>

        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" id="brand" name="brand" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category" placeholder="e.g. Outerwear, Top, Bottom" required>
        </div>

        <div class="form-group">
            <label for="price">Price (Rp)</label>
            <input type="number" id="price" name="price" min="0" required>
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" id="size" name="size" placeholder="e.g. S, M, L, XL, All Size" required>
        </div>

        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" id="color" name="color" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" min="0" required>
        </div>

        <button type="submit" class="btn-primary">Save Product</button>
    </form>
</main>

<footer class="store-footer">
    <p>KEEPly Fashion Collection &copy; 2026</p>
</footer>

</body>
</html>