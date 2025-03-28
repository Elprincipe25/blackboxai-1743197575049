<?php require_once __DIR__.'/../../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden | <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center">
    <div class="max-w-md w-full mx-auto p-8 bg-white rounded-lg shadow-lg text-center">
        <i class="fas fa-ban text-red-500 text-6xl mb-4"></i>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">403 Forbidden</h1>
        <p class="text-gray-600 mb-6">You don't have permission to access this resource.</p>
        <a href="/" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            <i class="fas fa-home mr-2"></i>Return Home
        </a>
    </div>
</body>
</html>