<?php 
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/middleware.php';
require_once __DIR__.'/../includes/flash.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"></link>
</head>
<body class="bg-gray-100 min-h-screen flex items-center">
    <?php displayFlashMessages(); ?>

    <div class="max-w-md w-full mx-auto p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center mb-8">Welcome Back</h1>
        
        <form action="/auth/login" method="POST" class="space-y-6">
            <?php require_once __DIR__.'/../includes/csrf.php'; ?>
            <?= CSRF::getTokenField() ?>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>
            
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign in
                </button>
            </div>
        </form>
        
        <div class="mt-6">
            <a href="/forgot-password" class="text-sm text-blue-600 hover:text-blue-500">Forgot your password?</a>
        </div>
        
        <p class="mt-8 text-center text-sm text-gray-600">
            Don't have an account? <a href="/register" class="font-medium text-blue-600 hover:text-blue-500">Sign up</a>
        </p>
    </div>
</body>
</html>