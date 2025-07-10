<?php
require 'dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_nim'])) {
        $delete_nim = $_POST['delete_nim'];
        $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE nim = ?");
        $stmt->bind_param("s", $delete_nim);
        $stmt->execute();
    } else {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nim, $nama, $email);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT * FROM mahasiswa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f5f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrapper {
            max-width: 800px;
            margin: auto;
        }

        .form-card, .table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
            padding: 30px;
            margin-top: 20px;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-primary {
            background-color:rgb(105, 191, 44);
            border: none;
        }

        .btn-primary:hover {
            background-color:rgb(30, 38, 127);
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        h2 {
            color:rgb(24, 10, 2);
            text-align: center;
            font-weight: 700;
            margin-top: 30px;
        }

        .table thead {
            background-color: rgb(24, 10, 2);
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="wrapper">
            <h2>Form Input Mahasiswa</h2>
            <form method="POST" class="form-card">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </form>

            <h2>Daftar Mahasiswa</h2>
            <div class="table-card table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nim']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_nim" value="<?= htmlspecialchars($row['nim']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
