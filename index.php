<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    $code = $_GET['hapus'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE productCode = ?");
    $stmt->execute([$code]);
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Produk Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Produk Mobil Classic</h4>
                <a href="tambah.php" class="btn btn-light btn-sm fw-bold">+ Tambah Produk</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $row): ?>
                                <tr>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['productCode']) ?></span></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($row['productName']) ?></td>
                                    <td><?= htmlspecialchars($row['productLine']) ?></td>
                                    <td><?= $row['quantityInStock'] ?></td>
                                    <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?code=<?= $row['productCode'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                                        <a href="index.php?hapus=<?= $row['productCode'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data produk.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>