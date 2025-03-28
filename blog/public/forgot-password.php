<?php require_once __DIR__.'/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center">
    <div class="max-w-md w-full mx-auto p-8 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-6">
            <i class="fas fa-key text-blue-500 text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">Forgot Password?</h1>
            <p class="text-gray-600 mt-2">Enter your email to receive a reset link</p>
        </div>
        
        <form action="/auth/forgot-password" method="POST" class="space-y-6">
            <?php require_once __DIR__.'/../includes/csrf.php'; ?>
            <?= CSRF::getTokenField() ?>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Send Reset Link
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="/login" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                <i class="fas fa-arrow-left mr-1"></i> Back to login
            </a>
        </div>
    </div>
</body>
</html>