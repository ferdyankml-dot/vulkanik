<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Proses tambah orang hilang
if ($_POST && isset($_POST['tambah_orang_hilang'])) {
    $nama = sanitize($_POST['nama']);
    $umur = sanitize($_POST['umur']);
    $alamat = sanitize($_POST['alamat']);
    $ciri_fisik = sanitize($_POST['ciri_fisik']);
    $tanggal_hilang = sanitize($_POST['tanggal_hilang']);
    $lokasi_hilang = sanitize($_POST['lokasi_hilang']);
    $status = sanitize($_POST['status']);
    
    $foto_path = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_path = uploadFoto($_FILES['foto']);
    }
    
    $sql = "INSERT INTO orang_hilang (nama, umur, alamat, ciri_fisik, tanggal_hilang, lokasi_hilang, foto, status) 
            VALUES ('$nama', '$umur', '$alamat', '$ciri_fisik', '$tanggal_hilang', '$lokasi_hilang', '$foto_path', '$status')";
    
    if ($conn->query($sql)) {
        $success_msg = "Data orang hilang berhasil ditambahkan!";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}

// Proses edit orang hilang
if ($_POST && isset($_POST['edit_orang_hilang'])) {
    $id = sanitize($_POST['id']);
    $nama = sanitize($_POST['nama']);
    $umur = sanitize($_POST['umur']);
    $alamat = sanitize($_POST['alamat']);
    $ciri_fisik = sanitize($_POST['ciri_fisik']);
    $tanggal_hilang = sanitize($_POST['tanggal_hilang']);
    $lokasi_hilang = sanitize($_POST['lokasi_hilang']);
    $status = sanitize($_POST['status']);
    
    $foto_path = sanitize($_POST['foto_lama']);
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_path = uploadFoto($_FILES['foto']);
    }
    
    $sql = "UPDATE orang_hilang SET 
            nama='$nama', umur='$umur', alamat='$alamat', ciri_fisik='$ciri_fisik', 
            tanggal_hilang='$tanggal_hilang', lokasi_hilang='$lokasi_hilang', 
            foto='$foto_path', status='$status' 
            WHERE id='$id'";
    
    if ($conn->query($sql)) {
        $success_msg = "Data orang hilang berhasil diupdate!";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}

// Proses hapus orang hilang
if (isset($_GET['hapus'])) {
    $id = sanitize($_GET['hapus']);
    $sql = "DELETE FROM orang_hilang WHERE id='$id'";
    
    if ($conn->query($sql)) {
        $success_msg = "Data orang hilang berhasil dihapus!";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}

// Ambil semua data orang hilang
$orang_hilang_query = "SELECT * FROM orang_hilang ORDER BY created_at DESC";
$orang_hilang_result = $conn->query($orang_hilang_query);

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = sanitize($_GET['edit']);
    $edit_query = "SELECT * FROM orang_hilang WHERE id='$id'";
    $edit_result = $conn->query($edit_query);
    if ($edit_result->num_rows > 0) {
        $edit_data = $edit_result->fetch_assoc();
    }
}

// Proses jawaban pertanyaan (kode sebelumnya)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['delete_question'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($csrf_token, $_POST['csrf_token'])) {
        $error_msg = "Permintaan hapus tidak valid. Muat ulang halaman lalu coba kembali.";
    } else {
        $question_id = filter_var($_POST['question_id'] ?? '', FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1]
        ]);

        if ($question_id === false || $question_id === null) {
            $error_msg = "Pertanyaan tidak dapat dihapus karena ID tidak valid.";
        } else {
            $delete_question = $conn->prepare("DELETE FROM questions WHERE id = ?");
            if ($delete_question) {
                $delete_question->bind_param('i', $question_id);
                if ($delete_question->execute()) {
                    if ($delete_question->affected_rows > 0) {
                        $success_msg = "Pertanyaan berhasil dihapus.";
                    } else {
                        $error_msg = "Pertanyaan tidak ditemukan atau sudah dihapus.";
                    }
                } else {
                    $error_msg = "Gagal menghapus pertanyaan: " . $delete_question->error;
                }
                $delete_question->close();
            } else {
                $error_msg = "Gagal menyiapkan penghapusan pertanyaan: " . $conn->error;
            }
        }
    }
}

if ($_POST && isset($_POST['answer'])) {
    $question_id = sanitize($_POST['question_id']);
    $answer = sanitize($_POST['answer']);
    $admin_id = 1;
    
    $sql = "INSERT INTO answers (question_id, admin_id, answer) VALUES ('$question_id', '$admin_id', '$answer')";
    if ($conn->query($sql)) {
        $success_msg = "Jawaban berhasil dikirim!";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}

$unanswered_query = "SELECT q.* FROM questions q LEFT JOIN answers a ON q.id = a.question_id WHERE a.id IS NULL ORDER BY q.created_at DESC";
$unanswered_result = $conn->query($unanswered_query);
$unanswered_count = $unanswered_result ? $unanswered_result->num_rows : 0;
$show_questions_tab = $unanswered_count > 0 || isset($_POST['answer']) || isset($_POST['delete_question']);

$answered_query = "SELECT q.*, a.answer, a.created_at as answered_at FROM questions q JOIN answers a ON q.id = a.question_id ORDER BY a.created_at DESC";
$answered_result = $conn->query($answered_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Vulkanik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Poppins font + admin styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body class="bg-light">
    <div class="container my-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <h2 class="mb-0">Dashboard Admin</h2>
            <a href="logout.php?redirect=public" class="btn btn-outline-success">Kembali ke Beranda</a>
        </div>
        
        <?php if (isset($success_msg)): ?>
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        <?php if (isset($error_msg)): ?>
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link<?php echo $show_questions_tab ? '' : ' active'; ?>" id="orang-tab" data-bs-toggle="tab" data-bs-target="#orang" type="button" role="tab" aria-controls="orang" aria-selected="<?php echo $show_questions_tab ? 'false' : 'true'; ?>">Orang Hilang</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link<?php echo $show_questions_tab ? ' active' : ''; ?>" id="pertanyaan-tab" data-bs-toggle="tab" data-bs-target="#pertanyaan" type="button" role="tab" aria-controls="pertanyaan" aria-selected="<?php echo $show_questions_tab ? 'true' : 'false'; ?>">
                    Pertanyaan
                    <?php if ($unanswered_count > 0): ?>
                        <span class="badge rounded-pill bg-danger ms-1"><?php echo $unanswered_count; ?></span>
                    <?php endif; ?>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">
            <!-- Tab Orang Hilang -->
            <div class="tab-pane fade<?php echo $show_questions_tab ? '' : ' show active'; ?>" id="orang" role="tabpanel" aria-labelledby="orang-tab">
                <!-- Form Tambah/Edit Orang Hilang -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo $edit_data ? 'Edit' : 'Tambah'; ?> Data Orang Hilang</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <?php if ($edit_data): ?>
                                <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                                <input type="hidden" name="foto_lama" value="<?php echo $edit_data['foto']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" 
                                           value="<?php echo $edit_data ? $edit_data['nama'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Umur</label>
                                    <input type="number" class="form-control" name="umur" 
                                           value="<?php echo $edit_data ? $edit_data['umur'] : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2" required><?php echo $edit_data ? $edit_data['alamat'] : ''; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label>Ciri-ciri Fisik</label>
                                <textarea class="form-control" name="ciri_fisik" rows="3" required><?php echo $edit_data ? $edit_data['ciri_fisik'] : ''; ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Hilang</label>
                                    <input type="date" class="form-control" name="tanggal_hilang" 
                                           value="<?php echo $edit_data ? $edit_data['tanggal_hilang'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Lokasi Hilang</label>
                                    <input type="text" class="form-control" name="lokasi_hilang" 
                                           value="<?php echo $edit_data ? $edit_data['lokasi_hilang'] : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="hilang" <?php echo ($edit_data && $edit_data['status'] == 'hilang') ? 'selected' : ''; ?>>Hilang</option>
                                        <option value="ditemukan" <?php echo ($edit_data && $edit_data['status'] == 'ditemukan') ? 'selected' : ''; ?>>Ditemukan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Foto</label>
                                    <input type="file" class="form-control" name="foto" accept="image/*">
                                    <?php if ($edit_data && $edit_data['foto']): ?>
                                        <small class="text-muted">Foto saat ini: <?php echo basename($edit_data['foto']); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success" name="<?php echo $edit_data ? 'edit_orang_hilang' : 'tambah_orang_hilang'; ?>">
                                <?php echo $edit_data ? 'Update' : 'Tambah'; ?> Data
                            </button>
                            
                            <?php if ($edit_data): ?>
                                <a href="admin.php" class="btn btn-secondary">Batal</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Daftar Orang Hilang -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Daftar Orang Hilang</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($orang_hilang_result->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Tanggal Hilang</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($person = $orang_hilang_result->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <?php if ($person['foto']): ?>
                                                        <img src="<?php echo $person['foto']; ?>" width="50" height="50" class="rounded" alt="Foto">
                                                    <?php else: ?>
                                                        <i class="fas fa-user fa-2x text-muted"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($person['nama']); ?></td>
                                                <td><?php echo $person['umur']; ?> tahun</td>
                                                <td><?php echo date('d M Y', strtotime($person['tanggal_hilang'])); ?></td>
                                                <td>
                                                    <?php if ($person['status'] == 'hilang'): ?>
                                                        <span class="badge bg-warning">Hilang</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Ditemukan</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="admin.php?edit=<?php echo $person['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="admin.php?hapus=<?php echo $person['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Belum ada data orang hilang.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Tab Pertanyaan (kode sebelumnya) -->
            <div class="tab-pane fade<?php echo $show_questions_tab ? ' show active' : ''; ?>" id="pertanyaan" role="tabpanel" aria-labelledby="pertanyaan-tab">
                <!-- Pertanyaan Belum Dijawab -->
                <div class="card mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">Pertanyaan Belum Dijawab</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($unanswered_result->num_rows > 0): ?>
                            <?php while($question = $unanswered_result->fetch_assoc()): ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h6><?php echo htmlspecialchars($question['user_name']); ?></h6>
                                            <small class="text-muted"><?php echo date('d M Y H:i', strtotime($question['created_at'])); ?></small>
                                        </div>
                                        <p class="mb-3"><?php echo htmlspecialchars($question['question']); ?></p>
                                        <form method="POST">
                                            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                                            <div class="mb-2">
                                                <textarea class="form-control" name="answer" rows="3" placeholder="Tulis jawaban..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm">Kirim Jawaban</button>
                                        </form>
                                        <form method="POST" class="mt-2" onsubmit="return confirm('Hapus pertanyaan ini? Tindakan ini tidak dapat dibatalkan.')">
                                            <input type="hidden" name="question_id" value="<?php echo (int) $question['id']; ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" name="delete_question" value="1" class="btn btn-outline-danger btn-sm">Hapus Pertanyaan</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted">Tidak ada pertanyaan yang belum dijawab.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pertanyaan Sudah Dijawab -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Pertanyaan Sudah Dijawab</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($answered_result->num_rows > 0): ?>
                            <?php while($qa = $answered_result->fetch_assoc()): ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h6><?php echo htmlspecialchars($qa['user_name']); ?></h6>
                                            <small class="text-muted"><?php echo date('d M Y H:i', strtotime($qa['created_at'])); ?></small>
                                        </div>
                                        <p class="mb-2"><strong>Pertanyaan:</strong> <?php echo htmlspecialchars($qa['question']); ?></p>
                                        <p class="mb-0"><strong>Jawaban:</strong> <?php echo htmlspecialchars($qa['answer']); ?></p>
                                        <small class="text-muted">Dijawab: <?php echo date('d M Y H:i', strtotime($qa['answered_at'])); ?></small>
                                        <form method="POST" class="mt-3" onsubmit="return confirm('Hapus pertanyaan beserta jawabannya? Tindakan ini tidak dapat dibatalkan.')">
                                            <input type="hidden" name="question_id" value="<?php echo (int) $qa['id']; ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" name="delete_question" value="1" class="btn btn-outline-danger btn-sm">Hapus Pertanyaan</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted">Belum ada pertanyaan yang dijawab.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
