<?php
// Gunakan getenv agar aman dan otomatis
$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
$sql_count = "SELECT COUNT(*) as total FROM ide_konten";
$result_count = mysqli_query($conn, $sql_count);
$data_count = mysqli_fetch_assoc($result_count);
$total_konten = $data_count['total'];

// --- LOGIKA TAMBAH DATA ---
if (isset($_POST['submit'])) {
    $judul  = $_POST['judul']; // Tangkap data judul
    $visual = $_POST['scene_visual'];
    $vo     = $_POST['voice_over'];
    $ref    = $_POST['referensi'];
    
    // Escape string untuk keamanan
    $judul  = mysqli_real_escape_string($conn, $judul);
    $visual = mysqli_real_escape_string($conn, $visual);
    $vo     = mysqli_real_escape_string($conn, $vo);
    $ref    = mysqli_real_escape_string($conn, $ref);
    
    mysqli_query($conn, "INSERT INTO ide_konten (judul, scene_visual, voice_over, referensi) VALUES ('$judul', '$visual', '$vo', '$ref')");
    header("Location: index.php");
}

// ... koneksi database tetap ...

// --- LOGIKA HAPUS DATA ---
if (isset($_POST['hapus_id'])) {
    $id = intval($_POST['hapus_id']);

    mysqli_query($conn, "DELETE FROM ide_konten WHERE id = $id");

    header("Location: index.php");
    exit();
}


// HITUNG TOTAL (Pindahkan ke sini agar angka selalu terbaru)
$sql_count = "SELECT COUNT(*) as total FROM ide_konten";
$result_count = mysqli_query($conn, $sql_count);
$data_count = mysqli_fetch_assoc($result_count);
$total_konten = $data_count['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ide Konten Manager</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://www.tiktok.com">
<link rel="preconnect" href="https://p16-sign-va.tiktokcdn.com">
<link rel="dns-prefetch" href="//www.instagram.com">
<link rel="preconnect" href="https://www.instagram.com">
    <style>
        /* --- GLOBAL STYLES --- */
        body {
            font-family: 'Poppins', sans-serif;
            background: url('bg.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            padding: 30px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        h2 { color: #2e7d32; font-weight: 700; }

        /* --- BUTTON STYLES --- */
        .btn-custom-add {
            background: linear-gradient(135deg, #66bb6a, #43a047);
            border: none; color: white; padding: 10px 25px; border-radius: 50px;
            font-weight: 500; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            transition: all 0.3s;
        }
        .btn-custom-add:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(76, 175, 80, 0.5); color: white; }

        /* --- TABLE ACCORDION STYLES --- */
        .table-custom { border-collapse: separate; border-spacing: 0 8px; }
        
        .table-custom thead th {
            border: none; background-color: #e8f5e9; color: #2e7d32;
            padding: 15px; font-weight: 600;
        }
        .table-custom thead th:first-child { border-radius: 10px 0 0 10px; }
        .table-custom thead th:last-child { border-radius: 0 10px 10px 0; }

        /* Baris Judul (Utama) */
        .row-main {
            background-color: white;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .row-main td { border: none; padding: 15px; vertical-align: middle; }
        .row-main td:first-child { border-radius: 10px 0 0 10px; }
        .row-main td:last-child { border-radius: 0 10px 10px 0; }
        
        .row-main:hover { background-color: #f1f8e9; transform: scale(1.005); box-shadow: 0 2px 8px rgba(0,0,0,0.05); }

        /* Indikator Panah */
        .chevron-icon { transition: transform 0.3s ease; color: #aaa; }
        .row-main[aria-expanded="true"] .chevron-icon { transform: rotate(180deg); color: #43a047; }
        .row-main[aria-expanded="true"] { font-weight: 600; color: #2e7d32; }

        /* Baris Detail (Tersembunyi) */
        .row-detail td { padding: 0; border: none; }
        .detail-content {
            background-color: #fafafa;
            border-left: 4px solid #43a047;
            margin: 0 10px 10px 10px;
            padding: 20px;
            border-radius: 0 0 10px 10px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.03);
        }

        /* --- MODAL STYLES --- */
        .modal-header-green { background-color: #43a047; color: white; }
        .embed-container iframe { width: 100%; height: 100%; border:none; }
        /* --- PERBAIKAN TAMPILAN MODAL PREVIEW --- */
#modalTonton .modal-content {
    background: #000; /* Latar hitam pekat seperti aplikasi video */
    border-radius: 25px;
    border: 1px solid rgba(255,255,255,0.2);
    overflow: hidden;
}

#modalTonton .modal-header {
    position: absolute; /* Header melayang di atas video */
    width: 100%;
    z-index: 10;
    background: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);
    border: none;
}

#modalTonton .modal-body {
    padding: 0; /* Menghilangkan padding agar video full ke tepi */
    display: flex;
    justify-content: center;
    align-items: center;
    background: #000;
}

#wrapperEmbed {
    width: 100%;
    height: 80vh; /* Tinggi video 80% dari layar */
    display: flex;
    justify-content: center;
}

#wrapperEmbed iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Tombol Tutup Custom */
.btn-close-custom {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: 0.3s;
}

.btn-close-custom:hover {
    background: rgba(255, 255, 255, 0.4);
    transform: rotate(90deg);
}

/* Responsif Mobile */
@media (max-width: 576px) {
    #wrapperEmbed {
        height: 85vh; /* Lebih tinggi sedikit di HP */
    }
}
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 glass-panel">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-layer-group me-2"></i>Konten Manager</h2>
                <button type="button" class="btn btn-custom-add" data-bs-toggle="modal" data-bs-target="#modalInput">
                    <i class="fas fa-plus me-2"></i>Ide Baru
                </button>
            </div>
<div class="mb-3 d-flex align-items-center gap-2 flex-wrap">
    
    <a href="index.php" 
       class="btn btn-sm <?= !isset($_GET['sort']) ? 'btn-success' : 'btn-outline-success' ?> rounded-pill px-3">
       Terbaru
    </a>
    
    <a href="index.php?sort=tinggi" 
       class="btn btn-sm <?= (isset($_GET['sort']) && $_GET['sort'] == 'tinggi') ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill px-3">
       Level Tinggi
    </a>
    
    <a href="index.php?sort=rendah" 
       class="btn btn-sm <?= (isset($_GET['sort']) && $_GET['sort'] == 'rendah') ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-3">
       Level Rendah
    </a>
</div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th width="85%">Jumlah Konten Belum Dibuat :<span class="badge bg-success ms-2"><?= $total_konten; ?></span></th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
// --- LOGIKA SORTING LEVEL ---
$sort_level = isset($_GET['sort']) ? $_GET['sort'] : '';

// Query dasar
$query_str = "SELECT * FROM ide_konten";

if ($sort_level == 'tinggi') {
    // Sortir: Menghitung kemunculan kata 'scene' di kolom scene_visual
    $query_str .= " ORDER BY (LENGTH(scene_visual) - LENGTH(REPLACE(LOWER(scene_visual), 'scene', ''))) DESC";
} elseif ($sort_level == 'rendah') {
    $query_str .= " ORDER BY (LENGTH(scene_visual) - LENGTH(REPLACE(LOWER(scene_visual), 'scene', ''))) ASC";
} else {
    // Default: Terbaru
    $query_str .= " ORDER BY id DESC";
}

$query = mysqli_query($conn, $query_str);
while ($row = mysqli_fetch_assoc($query)) :
    $collapseID = "detail-" . $row['id'];

    // --- LOGIKA HITUNG LEVEL ---
    // substr_count menghitung berapa kali kata "Scene" muncul (case-insensitive gunakan mb_stripos jika perlu)
    $text_visual = $row['scene_visual'];
    $jumlah_scene = substr_count(strtolower($text_visual), 'scene');

    if ($jumlah_scene >= 5) {
        $level_label = "Level : 3";
        $level_color = "bg-danger"; // Merah
    } elseif ($jumlah_scene >= 2) {
        $level_label = "Level : 2";
        $level_color = "bg-warning text-dark"; // Kuning
    } else {
        $level_label = "Level : 1";
        $level_color = "bg-primary"; // Biru
    }
    
?>
                  
                  
                        <tr class="row-main" data-bs-toggle="collapse" data-bs-target="#<?= $collapseID; ?>" aria-expanded="false">
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chevron-down me-3 chevron-icon"></i>
                                    <span class="badge rounded-pill <?= $level_color; ?> px-3 py-2 shadow-sm mx-2" style="font-size: 0.7rem;">
                <i class="fas fa-bolt me-1"></i> <?= $level_label; ?>
            </span>
                                    <span><?= htmlspecialchars($row['judul']); ?></span>
                                    
                                </div>
                            </td>
                            <td class="text-center">
<form method="POST" style="display:inline;" 
      onsubmit="event.stopPropagation(); return confirm('Yakin hapus ide ini? Data tidak bisa dikembalikan!');">
    
    <input type="hidden" name="hapus_id" value="<?= $row['id']; ?>">

    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

                    </td>

                        </tr>

                       <tr class="row-detail">
    <td colspan="2">
        <div id="<?= $collapseID; ?>" class="collapse">
<div class="detail-content mb-3">
    <div id="content-container-<?= $row['id']; ?>">
        
<div class="mt-2 mb-3 pt-3 d-flex justify-content-between align-items-center">
    <?php if (!empty($row['referensi'])): ?>
        <button class="btn btn-sm btn-info text-white rounded-pill px-3" 
                onclick="tontonRef('<?= $row['referensi']; ?>')">
            <i class="fas fa-play-circle me-1"></i> Tonton Referensi
        </button>
    <?php else: ?>
        <span class="small text-muted italic">Tidak ada referensi</span>
    <?php endif; ?>
</div>

        <div class="raw-visual d-none"><?= htmlspecialchars($row['scene_visual']); ?></div>
        <div class="raw-vo d-none"><?= htmlspecialchars($row['voice_over']); ?></div>
    </div>
    

</div>
        </div>
    </td>
</tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(mysqli_num_rows($query) == 0): ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                    <p>Belum ada ide konten. Yuk catat sekarang!</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="modal fade" id="modalInput" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content border-0 shadow-lg">
            <form method="POST">
                <div class="modal-header modal-header-green">
                    <h5 class="modal-title"><i class="fas fa-pen-fancy me-2"></i>Catat Ide Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="fw-bold text-success mb-1">Judul Konten (Headline)</label>
                        <input type="text" name="judul" class="form-control border-0 shadow-sm p-3" placeholder="Cth: Review Camping No Track..." required style="font-weight:600;">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-success mb-1">Scene Visual</label>
                            <textarea name="scene_visual" class="form-control border-0 shadow-sm" rows="5" placeholder="Deskripsikan urutan visual..." required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-success mb-1">Voice Over</label>
                            <textarea name="voice_over" class="form-control border-0 shadow-sm" rows="5" placeholder="Tulis naskah yang akan diucapkan..." required></textarea>
                        </div>
                    </div>
                    
                    <div class="mb-3">  
                        <label class="fw-bold text-success mb-1">Link Referensi</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-0"><i class="fab fa-tiktok"></i></span>
                            <input type="url" name="referensi" class="form-control border-0" placeholder="https://www.tiktok.com/...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-custom-add rounded-pill px-4">Simpan Ide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTonton" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;"> <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white fs-6"><i class="fab fa-tiktok me-2"></i>Preview Referensi</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div id="wrapperEmbed">
                    </div>
            </div>

            <div class="modal-footer border-0 p-2 justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-4 opacity-75" data-bs-dismiss="modal">Selesai Nonton</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// 1. FUNGSI UNTUK MENAMPILKAN MODAL & VIDEO
function tontonRef(url) {
    let embedUrl = "";
    const wrapper = document.getElementById('wrapperEmbed');

    // Logika mengubah link ke embed
    if(url.includes('tiktok.com')) {
        let videoId = url.split("/video/")[1]?.split("?")[0];
        embedUrl = `https://www.tiktok.com/embed/v2/${videoId}`;
    } else if(url.includes('instagram.com')) {
    // Menghapus query string dan memastikan berakhir dengan /reels/ID/embed
    let cleanUrl = url.split("?")[0]; 
    if (!cleanUrl.endsWith('/')) cleanUrl += '/';
    embedUrl = cleanUrl + "embed";
}

    // Masukkan iframe ke dalam wrapper
    wrapper.innerHTML = `<iframe src="${embedUrl}" frameborder="0" allowfullscreen style="width:100%; height:100%;"></iframe>`;

    // Tampilkan Modal
    var myModal = new bootstrap.Modal(document.getElementById('modalTonton'));
    myModal.show();
}

// 2. SOLUSI AUDIO: Hapus isi Iframe saat modal ditutup
// Kita menggunakan event listener 'hide.bs.modal' (saat mulai ditutup)
document.addEventListener('DOMContentLoaded', function() {
    var modalVideo = document.getElementById('modalTonton');
    modalVideo.addEventListener('hide.bs.modal', function () {
        // Mengosongkan innerHTML akan seketika menghentikan proses loading dan audio video
        document.getElementById('wrapperEmbed').innerHTML = '';
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cari semua kontainer konten
    const containers = document.querySelectorAll('[id^="content-container-"]');

    containers.forEach(container => {
        const visualText = container.querySelector('.raw-visual').innerText;
        const voText = container.querySelector('.raw-vo').innerText;

        // Fungsi untuk memecah teks berdasarkan pola "Scene X:"
        const splitByScene = (text) => {
            // regex untuk memecah berdasarkan "Scene" diikuti angka dan titik/titik dua
            const parts = text.split(/(?=Scene\s*\d+[:\s])/i);
            return parts.filter(p => p.trim() !== "");
        };

        const visualScenes = splitByScene(visualText);
        const voScenes = splitByScene(voText);

        // Cari jumlah scene terbanyak
        const maxScenes = Math.max(visualScenes.length, voScenes.length);
        let htmlOutput = "";

        for (let i = 0; i < maxScenes; i++) {
            const vContent = visualScenes[i] ? visualScenes[i].replace(/\n/g, '<br>') : "-";
            const voContent = voScenes[i] ? voScenes[i].replace(/\n/g, '<br>') : "-";

            // Buat baris baru untuk setiap nomor scene agar selalu sejajar
            htmlOutput += `
                <div class="row mb-2 pb-2 ${i < maxScenes - 1 ? 'border-bottom border-light' : ''}">
                    <div class="col-6 border-end">
                        <label class="small text-muted fw-bold d-block" style="font-size:0.65rem;">VISUAL</label>
                        <div class="small text-dark">${vContent}</div>
                    </div>
                    <div class="col-6">
                        <label class="small text-muted fw-bold d-block" style="font-size:0.65rem;">VOICE OVER</label>
                        <div class="small text-dark fst-italic"><i class="fas fa-quote-left text-success me-1" style="font-size:0.6rem;"></i>${voContent}</div>
                    </div>
                </div>
            `;
        }

        container.innerHTML += htmlOutput;
    });
});
</script>
</body>

</html>
