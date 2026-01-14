<?php
include '/db/koneksi.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bukit Jar'un</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Permanent+Marker&family=Kalam:wght@700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/animation.css">
    <link rel="stylesheet" href="assets/css/album.css">
    <link rel="stylesheet" href="assets/css/ticket.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- FLOATING CHAT CSS --- */
        .floating-chat-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            width: 65px;
            height: 65px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Gradient Biru-Ungu Modern */
            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
            color: white;
            text-decoration: none;
            /* Efek Glass & Shadow */
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.5), 
                        0 5px 10px -5px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            animation: popIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
            opacity: 0; 
        }

        .chat-icon-svg {
            width: 32px;
            height: 32px;
            transform: rotate(-5deg);
            transition: transform 0.3s ease;
        }

        /* Hover Effect */
        .floating-chat-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 35px -10px rgba(99, 102, 241, 0.6), 
                        0 10px 20px -5px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #7174ff 0%, #9d74ff 100%);
        }

        .floating-chat-btn:hover .chat-icon-svg {
            transform: rotate(0deg) scale(1.1);
        }

        /* Active Effect */
        .floating-chat-btn:active {
            transform: translateY(-2px) scale(0.98);
        }

        /* Titik Notifikasi (Hiasan) */
        .notif-dot {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 12px;
            height: 12px;
            background-color: #EF4444;
            border: 2px solid #fff;
            border-radius: 50%;
            animation: pulse-red 2s infinite;
        }

        /* Animasi */
        @keyframes popIn {
            0% { opacity: 0; transform: scale(0) translateY(50px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .floating-chat-btn {
                width: 55px;
                height: 55px;
                bottom: 20px;
                right: 20px;
            }
            .chat-icon-svg { width: 26px; height: 26px; }
            .notif-dot { top: 12px; right: 12px; width: 10px; height: 10px; }
        }
    </style>
</head>

<body class="bg-white overflow-x-hidden relative">

    <?php include __DIR__ . '/components/navbar.php'; ?>
    <?php include __DIR__ . '/components/hero.php'; ?>
    <?php include __DIR__ . '/components/event.php'; ?>
    <?php include __DIR__ . '/components/leaderboard.php'; ?>
    <?php include __DIR__ . '/components/pengenalan1.php'; ?>
    <?php include __DIR__ . '/components/pengenalan2.php'; ?>
    <?php include __DIR__ . '/components/lokasi.php'; ?>

    <a href="https://wa.me/6282321181499" target="_blank" class="floating-chat-btn" aria-label="Hubungi Admin">
        <svg xmlns="http://www.w3.org/2000/svg" class="chat-icon-svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1"></path>
            <line x1="12" y1="12" x2="12" y2="12.01"></line>
            <line x1="8" y1="12" x2="8" y2="12.01"></line>
            <line x1="16" y1="12" x2="16" y2="12.01"></line>
        </svg>
        
        <span class="notif-dot"></span>
    </a>
    <script src="assets/js/carousel.js"></script>
    <script src="assets/js/navbar.js"></script>

</body>

</html>


