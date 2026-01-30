<?php

// Direct Debug Route
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/test') !== false) {
    header('Content-Type: text/html');
    echo "<h1>Vercel PHP Status: ALIVE</h1>";
    echo "<p>PHP Version: " . phpversion() . "</p>";
    echo "<p>Storage Path: " . ($_ENV['VERCEL'] ?? 'Not Set') . "</p>";
    exit;
}

require __DIR__ . '/../public/index.php';
