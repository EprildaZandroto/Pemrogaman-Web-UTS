<?php
include 'config/database.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM `products` WHERE `id` = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result  = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name'] ?? '');
    $brand        = trim($_POST['brand'] ?? '');
    $category     = trim($_POST['category'] ?? '');
    $price        = (int)($_POST['price'] ?? 0);
    $size         = trim($_POST['size'] ?? '');
    $color        = trim($_POST['color'] ?? '');
    $stock        = (int)($_POST['stock'] ?? 0);

    $updateStmt = mysqli_prepare(
        $conn,
        "UPDATE `products` SET `product_name` = ?, `brand` = ?, `category` = ?, `price` = ?, `size` = ?, `color` = ?, `stock` = ? WHERE `id` = ?"
    );
    mysqli_stmt_bind_param($updateStmt, "sssissii", $product_name, $brand, $category, $price, $size, $color, $stock, $id);
    mysqli_stmt_execute($updateStmt);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KEEPly | Edit Product</title>
    <link rel="stylesheet" href="Assets/css/style.css?v=1">
</head>
<body>

<header class="store-header">
    <h1>KEEPly.</h1>
    <a href="index.php">Back to Collection</a>
</header>

<main class="store-container">
    <section class="collection-heading">
        <h2>Edit Product</h2>
        <p>Update product details in the KEEPly catalog.</p>
    </section>

    <form method="POST" class="form-card">
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name"
                   value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" id="brand" name="brand"
                   value="<?php echo htmlspecialchars($product['brand']); ?>" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category"
                   value="<?php echo htmlspecialchars($product['category']); ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Price (Rp)</label>
            <input type="number" id="price" name="price" min="0"
                   value="<?php echo (int)$product['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" id="size" name="size"
                   value="<?php echo htmlspecialchars($product['size']); ?>" required>
        </div>

        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" id="color" name="color"
                   value="<?php echo htmlspecialchars($product['color']); ?>" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" min="0"
                   value="<?php echo (int)$product['stock']; ?>" required>
        </div>

        <button type="submit" class="btn-primary">Update Product</button>
    </form>
</main>

<footer class="store-footer">
    <p>KEEPly Fashion Collection &copy; 2026</p>
</footer>

</body>
</html>