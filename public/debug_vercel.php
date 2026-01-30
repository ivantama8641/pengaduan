<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Vercel Environment Debugger</h1>";

echo "<h2>1. Write Permissions Check (/tmp)</h2>";
$testFile = '/tmp/test_write_' . uniqid() . '.txt';
try {
    file_put_contents($testFile, 'Hello Vercel');
    echo "<p style='color:green'>✅ Write success: $testFile</p>";
    if (file_exists($testFile)) {
        echo "<p style='color:green'>✅ File created successfully</p>";
        unlink($testFile);
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Write failed: " . $e->getMessage() . "</p>";
}

echo "<h2>2. Environment Variables</h2>";
$keys_to_check = ['APP_ENV', 'APP_DEBUG', 'APP_KEY', 'DB_CONNECTION', 'DB_HOST', 'VERCEL'];
echo "<ul>";
foreach ($keys_to_check as $key) {
    $val = getenv($key);
    $display = $val ? "IS SET (Length: " . strlen($val) . ")" : "<span style='color:red'>MISSING / EMPTY</span>";
    if ($key === 'APP_DEBUG') $display .= " (Value: $val)";
    echo "<li><strong>$key</strong>: $display</li>";
}
echo "</ul>";

echo "<h2>3. PHP Extensions</h2>";
$extensions = get_loaded_extensions();
echo "<p>Loaded: " . implode(', ', $extensions) . "</p>";

echo "<h2>4. File Structure (Root)</h2>";
$root = __DIR__ . '/..';
if (is_dir($root)) {
    $files = scandir($root);
    echo "<ul>";
    foreach ($files as $file) {
        echo "<li>$file</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:red'>Cannot scan root directory</p>";
}
