<?php
include 'koneksi.php';

$code = $_GET['code'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM products WHERE productCode = ?");
$stmt->execute([$code]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Produk tidak ditemukan!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['productName'];
    $line  = $_POST['productLine'];
    $stock = $_POST['quantityInStock'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("UPDATE products SET productName = ?, productLine = ?, quantityInStock = ?, price = ? WHERE productCode = ?");
    $stmt->execute([$name, $line, $stock, $price, $code]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Edit Produk</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Produk (Tidak bisa diubah)</label>
                                <input type="text" class="form-control bg-body-secondary" value="<?= htmlspecialchars($product['productCode']) ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Produk</label>
                                <input type="text" name="productName" class="form-control" value="<?= htmlspecialchars($product['productName']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="productLine" class="form-select">
                                    <option value="Classic" <?= $product['productLine'] == 'Classic' ? 'selected' : '' ?>>Classic</option>
                                    <option value="Vintage" <?= $product['productLine'] == 'Vintage' ? 'selected' : '' ?>>Vintage</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Stok</label>
                                <input type="number" name="quantityInStock" class="form-control" value="<?= $product['quantityInStock'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="price" step="0.01" class="form-control" value="<?= $product['price'] ?>" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-warning">Update Produk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>