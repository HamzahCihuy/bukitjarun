<?php
session_start();

// Jika sudah login, lempar langsung ke Dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// Koneksi Database
if (file_exists('../db/koneksi.php')) { include '../db/koneksi.php'; }
else { die("Koneksi database tidak ditemukan."); }

$error = "";

// --- FITUR AUTO-CREATE ADMIN (KHUSUS UNTUK KAMU) ---
// Logika: Jika tabel kosong, buatkan akun 'jarun'
try {
    $check = $pdo->query("SELECT count(*) FROM admins")->fetchColumn();
    
    if ($check == 0) {
        // Password yang diminta: jatijaya
        $passDefault = password_hash('jatijaya', PASSWORD_DEFAULT);
        
        // Masukkan ke database
        $pdo->query("INSERT INTO admins (username, password) VALUES ('jarun', '$passDefault')");
    }
} catch (Exception $e) {
    // Silent error agar tidak mengganggu tampilan
}
// ---------------------------------------------------------

// PROSES LOGIN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Username dan Password wajib diisi!";
    } else {
        try {
            // Cari user berdasarkan username
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifikasi Password
            if ($user && password_verify($password, $user['password'])) {
                // Login Sukses
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                header("Location: index.php");
                exit;
            } else {
                $error = "Username atau Password salah!";
            }
        } catch (PDOException $e) {
            $error = "Database Error.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Bukit Jar'un</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Quicksand', sans-serif; }</style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border border-slate-200">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-[#0E5941] mb-2">LOGIN ADMIN</h1>
            <p class="text-slate-400 text-sm">Masuk untuk mengelola website Bukit Jar'un</p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm font-bold text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-slate-600 font-bold mb-2 text-sm uppercase">Username</label>
                <input type="text" name="username" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:outline-none focus:border-[#17FFB2] focus:ring-2 focus:ring-[#17FFB2]/20 transition font-bold" placeholder="jarun">
            </div>

            <div class="mb-6">
                <label class="block text-slate-600 font-bold mb-2 text-sm uppercase">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:outline-none focus:border-[#17FFB2] focus:ring-2 focus:ring-[#17FFB2]/20 transition font-bold" placeholder="••••••">
            </div>

            <button type="submit" class="w-full bg-[#0E5941] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-[#093d2c] active:scale-95 transition">
                MASUK DASHBOARD 🔐
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="../index.php" class="text-sm text-slate-400 hover:text-[#0E5941] transition">← Kembali ke Website</a>
        </div>
    </div>

</body>
</html>
