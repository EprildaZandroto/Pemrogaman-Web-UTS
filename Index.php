<?php
include 'config/database.php';

$search = $_GET['search'] ?? '';

$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE product_name LIKE ? OR brand LIKE ? OR category LIKE ? ORDER BY id DESC");
$keyword = "%" . $search . "%";

mysqli_stmt_bind_param($stmt, "sss", $keyword, $keyword, $keyword);
mysqli_stmt_execute($stmt);

$products = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KEEPly | Fashion Collection</title>
    <link rel="stylesheet" href="Assets/css/style.css?v=1">
</head>
<body>

<header class="store-header">
    <h1>KEEPly.</h1>
    <a href="add_product.php">+ Add Product</a>
</header>

<main class="store-container">

    <section class="collection-heading">
        <h2>Fashion Collection</h2>
        <p>Save the styles you love. Let us know what you want.</p>
    </section>

    <section class="customer-section">
        <label for="customer">Select Customer</label>
        <select id="customer">
            <option>CLIENT-001</option>
            <option>CLIENT-002</option>
            <option>CLIENT-003</option>
        </select>
    </section>

    <form method="GET" class="store-search">
        <input type="text" name="search"
               placeholder="Search your favorite style..."
               value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <section class="product-grid">
        <?php if (mysqli_num_rows($products) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($products)): ?>
                <article class="product-card">
                    <div class="product-info">
                        <div class="product-meta">
                            <span><?php echo htmlspecialchars($row['brand']); ?></span>
                            <span><?php echo htmlspecialchars($row['category']); ?></span>
                        </div>

                        <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>

                        <p class="product-price">
                            Rp <?php echo number_format((int)$row['price'], 0, ',', '.'); ?>
                        </p>

                        <label>Choose Size</label>
                        <select class="size-select">
                            <option>
                                <?php echo htmlspecialchars($row['size']); ?>
                                - <?php echo htmlspecialchars($row['color']); ?>
                                (<?php echo (int)$row['stock']; ?> stock)
                            </option>
                        </select>

                        <button class="restock-button" type="button"
                                onclick="requestRestock('<?php echo htmlspecialchars($row['product_name'], ENT_QUOTES); ?>')">
                            Request Restock
                        </button>

                        <button class="wishlist-button" type="button"
                                onclick="addWishlist('<?php echo htmlspecialchars($row['product_name'], ENT_QUOTES); ?>')">
                            Add to Wishlist
                        </button>

                        <div class="manage-links">
                            <a href="edit_product.php?id=<?php echo (int)$row['id']; ?>">Edit</a>
                            <a href="delete_product.php?id=<?php echo (int)$row['id']; ?>"
                               onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                Delete
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="empty-message">No products found.</p>
        <?php endif; ?>
    </section>

</main>

<footer class="store-footer">
    <p>KEEPly Fashion Collection &copy; 2026</p>
</footer>

<script>
function requestRestock(product) {
    alert("Restock request submitted for " + product);
}

function addWishlist(product) {
    alert(product + " added to your wishlist!");
}
</script>

</body>
</html>
