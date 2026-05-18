<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code  = $_POST['productCode'];
    $name  = $_POST['productName'];
    $line  = $_POST['productLine'];
    $stock = $_POST['quantityInStock'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("INSERT INTO products (productCode, productName, productLine, quantityInStock, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$code, $name, $line, $stock, $price]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Tambah Produk Baru</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Produk</label>
                                <input type="text" name="productCode" class="form-control" placeholder="Contoh: P04" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Produk</label>
                                <input type="text" name="productName" class="form-control" placeholder="Contoh: 1967 Chevrolet Impala" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="productLine" class="form-select">
                                    <option value="Classic">Classic</option>
                                    <option value="Vintage">Vintage</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Stok awal</label>
                                <input type="number" name="quantityInStock" class="form-control" value="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="price" step="0.01" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan Produk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>