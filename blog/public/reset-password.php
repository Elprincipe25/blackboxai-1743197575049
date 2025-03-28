<?php 
require_once __DIR__.'/../includes/config.php';

// In a real app, we would validate the token here
$token = $_GET['token'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
    function validateForm() {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;
        
        if (password !== confirm) {
            alert('Passwords do not match!');
            return false;
        }
        return true;
    }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center">
    <div class="max-w-md w-full mx-auto p-8 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-6">
            <i class="fas fa-lock text-blue-500 text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">Reset Your Password</h1>
            <p class="text-gray-600 mt-2">Create a new secure password</p>
        </div>
        
        <form action="/auth/reset-password" method="POST" onsubmit="return validateForm()" class="space-y-6">
            <?php require_once __DIR__.'/../includes/csrf.php'; ?>
            <?= CSRF::getTokenField() ?>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" id="password" name="password" required minlength="8"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">At least 8 characters</p>
            </div>
            
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Password
            </button>
        </form>
    </div>
</body>
</html>