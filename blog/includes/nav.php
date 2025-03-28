<?php
$currentRoute = $_SERVER['REQUEST_URI'] ?? '/';
$isLoggedIn = isset($_SESSION['user']);
?>
<nav class="bg-white shadow-md">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-gray-800">
                    <?= APP_NAME ?>
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-4">
                <a href="/articles" class="<?= str_contains($currentRoute, '/articles') ? 'text-blue-600' : 'text-gray-600' ?> hover:text-blue-600 transition">
                    Articles
                </a>
                
                <?php if ($isLoggedIn): ?>
                    <a href="/articles/create" class="<?= $currentRoute === '/articles/create' ? 'text-blue-600' : 'text-gray-600' ?> hover:text-blue-600 transition">
                        New Article
                    </a>
                    <div class="relative group">
                        <button class="flex items-center space-x-1 text-gray-600 hover:text-blue-600 transition">
                            <span><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="/logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Sign Out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="<?= $currentRoute === '/login' ? 'text-blue-600' : 'text-gray-600' ?> hover:text-blue-600 transition">
                        Sign In
                    </a>
                    <a href="/register" class="<?= $currentRoute === '/register' ? 'text-blue-600' : 'text-gray-600' ?> hover:text-blue-600 transition">
                        Register
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button class="mobile-menu-button p-2 rounded-md text-gray-600 hover:text-blue-600 hover:bg-gray-100 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="mobile-menu hidden md:hidden bg-white shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/articles" class="block px-3 py-2 rounded-md text-base font-medium <?= str_contains($currentRoute, '/articles') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                Articles
            </a>
            
            <?php if ($isLoggedIn): ?>
                <a href="/articles/create" class="block px-3 py-2 rounded-md text-base font-medium <?= $currentRoute === '/articles/create' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    New Article
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100">
                    Profile
                </a>
                <a href="/logout" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100">
                    Sign Out
                </a>
            <?php else: ?>
                <a href="/login" class="block px-3 py-2 rounded-md text-base font-medium <?= $currentRoute === '/login' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    Sign In
                </a>
                <a href="/register" class="block px-3 py-2 rounded-md text-base font-medium <?= $currentRoute === '/register' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    Register
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
document.querySelector('.mobile-menu-button').addEventListener('click', function() {
    document.querySelector('.mobile-menu').classList.toggle('hidden');
});
</script>