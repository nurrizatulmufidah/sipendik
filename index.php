<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Pendataan Pengurus Sub Pendidikan</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      height: 100vh;
      background-color: #2c3e50;
      padding-top: 30px;
      color: white;
    }
    .sidebar h4 {
      color: #ecf0f1;
      text-align: center;
    }
    .sidebar a {
      display: block;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
    }
    .sidebar a.active, .sidebar a:hover {
      background-color: #34495e;
    }
    .main {
      padding: 30px;
    }
    .table thead {
      background-color: #2c3e50;
      color: white;
    }
    .custom-card {
      border-radius: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .navbar {
      background-color: #2c3e50;
    }
    .navbar-brand, .nav-link, .navbar-text {
      color: #ecf0f1 !important;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <h4>Dashboard</h4>
        <a href="?page=home" class="<?= $page == 'home' ? 'active' : '' ?>">Home</a>
        <a href="?page=data" class="<?= $page == 'data' ? 'active' : '' ?>">Data Pengurus</a>
        <a href="?page=laporan" class="<?= $page == 'laporan' ? 'active' : '' ?>">Laporan</a>
        <a href="#">Logout</a>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 main">
        <nav class="navbar navbar-light mb-4">
          <span class="navbar-text">Selamat datang di Sistem Pendataan Pengurus Sub Pendidikan</span>
        </nav>

        <?php if ($page == 'home') { ?>
          <div class="jumbotron bg-white shadow">
            <h1 class="display-4">Halo!</h1>
            <p class="lead">Selamat datang di dashboard sistem pendataan pengurus sub pendidikan.</p>
            <hr class="my-4">
            <p>Silakan gunakan menu di sebelah kiri untuk mengelola data.</p>
          </div>

        <?php } elseif ($page == 'data') { ?>

        <!-- Data Pengurus -->
        <div class="card custom-card">
          <div class="card-body">
            <h4 class="card-title mb-4">Data Pengurus Sub Pendidikan</h4>

            <!-- Form Tambah Data -->
            <form action="" method="post" class="mb-4">
              <div class="form-row">
                <div class="col">
                  <input type="text" name="nama_pengurus" class="form-control" placeholder="Nama Pengurus" required>
                </div>
                <div class="col">
                  <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" required>
                </div>
                <div class="col">
                  <input type="text" name="unit" class="form-control" placeholder="Unit" required>
                </div>
                <div class="col">
                  <button type="submit" name="simpan" class="btn btn-primary">Tambah</button>
                </div>
              </div>
            </form>

            <?php
            include 'koneksi.php';
            if (isset($_GET['hapus'])) {
              $id = $_GET['hapus'];
              mysqli_query($koneksi, "DELETE FROM pengurus WHERE id='$id'");
              echo "<script>window.location='?page=data';</script>";
            }

            if (isset($_POST['update'])) {
              $id = $_POST['id'];
              $nama = $_POST['nama_pengurus'];
              $jabatan = $_POST['jabatan'];
              $unit = $_POST['unit'];
              mysqli_query($koneksi, "UPDATE pengurus SET nama_pengurus='$nama', jabatan='$jabatan', unit='$unit' WHERE id='$id'");
              echo "<script>window.location='?page=data';</script>";
            }

            if (isset($_POST['simpan'])) {
              $nama = $_POST['nama_pengurus'];
              $jabatan = $_POST['jabatan'];
              $unit = $_POST['unit'];
              mysqli_query($koneksi, "INSERT INTO pengurus (nama_pengurus, jabatan, unit) VALUES ('$nama', '$jabatan', '$unit')");
            }

            if (isset($_GET['edit'])) {
              $id = $_GET['edit'];
              $query = mysqli_query($koneksi, "SELECT * FROM pengurus WHERE id='$id'");
              $edit = mysqli_fetch_array($query);
            ?>
              <form action="" method="post" class="mb-4">
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <div class="form-row">
                  <div class="col">
                    <input type="text" name="nama_pengurus" class="form-control" value="<?= $edit['nama_pengurus'] ?>" required>
                  </div>
                  <div class="col">
                    <input type="text" name="jabatan" class="form-control" value="<?= $edit['jabatan'] ?>" required>
                  </div>
                  <div class="col">
                    <input type="text" name="unit" class="form-control" value="<?= $edit['unit'] ?>" required>
                  </div>
                  <div class="col">
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                    <a href="?page=data" class="btn btn-secondary">Batal</a>
                  </div>
                </div>
              </form>
            <?php } ?>

            <!-- Tabel Data Pengurus -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pengurus</th>
                  <th>Jabatan</th>
                  <th>Unit</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM pengurus");
                while($d = mysqli_fetch_array($data)){
                  echo "<tr>
                          <td>$no</td>
                          <td>{$d['nama_pengurus']}</td>
                          <td>{$d['jabatan']}</td>
                          <td>{$d['unit']}</td>
                          <td>
                            <a href='?page=data&edit={$d['id']}' class='btn btn-sm btn-info'>Edit</a>
                            <a href='?page=data&hapus={$d['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
                          </td>
                        </tr>";
                  $no++;
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

        <?php } elseif ($page == 'laporan') { ?>
          <div class="card custom-card">
            <div class="card-body">
              <h4 class="card-title">Laporan Pengurus</h4>
              <p>Halaman laporan masih dalam pengembangan.</p>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>
</body>
</html>
