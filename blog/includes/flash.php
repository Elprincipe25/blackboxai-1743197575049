<?php
function flash(string $key, string $message): void {
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    $_SESSION['flash'][$key] = $message;
}

function getFlash(string $key): ?string {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

function displayFlashMessages(): void {
    if (empty($_SESSION['flash'])) return;
    
    echo '<div class="fixed top-4 right-4 z-50 space-y-2">';
    foreach ($_SESSION['flash'] as $key => $message) {
        $type = strpos($key, 'error') !== false ? 'error' : 'success';
        $bgColor = $type === 'error' ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700';
        
        echo <<<HTML
        <div class="flash-message {$bgColor} border px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{$message}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 close-flash">
                <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </span>
        </div>
HTML;
    }
    echo '</div>';
    
    // Add JavaScript to handle closing messages
    echo <<<HTML
    <script>
    document.querySelectorAll('.close-flash').forEach(button => {
        button.addEventListener('click', (e) => {
            e.target.closest('.flash-message').remove();
        });
    });
    
    // Auto-remove flash messages after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.flash-message').forEach(msg => {
            msg.remove();
        });
    }, 5000);
    </script>
HTML;
    
    // Clear all flash messages after displaying
    $_SESSION['flash'] = [];
}