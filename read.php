<?php
include 'koneksi.php';

// Ambil kode produk dari URL, jika tidak ada arahkan kembali ke index
$code = $_GET['code'] ?? '';
if (empty($code)) {
    header("Location: index.php");
    exit;
}

// Ambil data produk spesifik berdasarkan kode
$stmt = $pdo->prepare("SELECT p.*, pl.description FROM products p LEFT JOIN productlines pl ON p.productLine = pl.productLine WHERE p.productCode = ?");
$stmt->execute([$code]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan di database
if (!$product) {
    die("<div class='container mt-5'><div class='alert alert-danger'>Produk tidak ditemukan!</div></div>");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?= htmlspecialchars($product['productName']) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Detail Informasi Produk</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered bg-white">
                            <tr>
                                <th class="bg-light" style="width: 30%;">Kode Produk</th>
                                <td><span class="badge bg-secondary fs-6"><?= htmlspecialchars($product['productCode']) ?></span></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Nama Produk</th>
                                <td class="fw-bold text-primary"><?= htmlspecialchars($product['productName']) ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Kategori</th>
                                <td><?= htmlspecialchars($product['productLine']) ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Stok Tersedia</th>
                                <td>
                                    <span class="badge <?= $product['quantityInStock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $product['quantityInStock'] ?> Unit
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Harga Resmi</th>
                                <td class="text-success fw-semibold">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Deskripsi Kategori</th>
                                <td class="text-muted italic">
                                    <?= htmlspecialchars($product['description'] ?? 'Tidak ada deskripsi.') ?>
                                </td>
                            </tr>
                        </table>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-secondary">Kembali ke Daftar</a>
                            <a href="edit.php?code=<?= $product['productCode'] ?>" class="btn btn-warning">Edit Data Ini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Watermark Footer -->
    <footer class="footer mt-auto py-3 bg-white border-top">
        <div class="container text-center">
            <span class="text-muted small opacity-75">
                © 2026 <strong>PT CAR SEJAHTERA PUTERA PRIMA DONA</strong>. All Rights Reserved.
                <br>
                <span class="text-secondary" style="font-size: 0.8rem;">Sistem Database Perusahaan Mobil Classic v1.0</span>
            </span>
        </div>
    </footer>

    <style>
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; }
        .container.mt-5 { flex: 1 0 auto; }
        .footer { flex-shrink: 0; }
    </style>
</body>
</html>