<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Status Server: AKTIF</h1>";
echo "<p>Jika Anda melihat ini, berarti Vercel & PHP berfungsi normal.</p>";

echo "<h2>Cek Koneksi Database:</h2>";

$host = getenv('DB_HOST');
$dbname = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

echo "<ul>";
echo "<li>Host: " . ($host ? $host : 'KOSONG') . "</li>";
echo "<li>Database: " . ($dbname ? $dbname : 'KOSONG') . "</li>";
echo "<li>User: " . ($user ? $user : 'KOSONG') . "</li>";
echo "<li>Password: " . ($pass ? 'TERISI (****)' : 'KOSONG') . "</li>";
echo "</ul>";

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass);
    echo "<h3 style='color: green'>Koneksi Database BERHASIL!</h3>";
} catch (PDOException $e) {
    echo "<h3 style='color: red'>Koneksi Database GAGAL: " . $e->getMessage() . "</h3>";
}
