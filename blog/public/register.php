<?php require_once __DIR__.'/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | <?= APP_NAME ?></title>
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
        <h1 class="text-3xl font-bold text-center mb-8">Create Account</h1>
        
        <form action="/auth/register" method="POST" onsubmit="return validateForm()" class="space-y-6">
            <?php require_once __DIR__.'/../includes/csrf.php'; ?>
            <?= CSRF::getTokenField() ?>
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
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
                Create Account
            </button>
        </form>
        
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or sign up with</span>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-2 gap-3">
                <a href="/auth/google" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fab fa-google text-red-500 mr-2"></i> Google
                </a>
                <a href="/auth/github" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fab fa-github text-gray-800 mr-2"></i> GitHub
                </a>
            </div>
        </div>
        
        <p class="mt-8 text-center text-sm text-gray-600">
            Already have an account? <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">Sign in</a>
        </p>
    </div>
</body>
</html>