<?php
/**
 * One-time script to set WHMCS System URL to the current site URL.
 * Uses APP_URL from project .env and appends /billing/ (trailing slash required by WHMCS).
 *
 * Run from project root: php billing/set_system_url.php
 * Or with custom URL: php billing/set_system_url.php "https://example.com/billing/"
 */

// CLI only (do not run from web)
if (php_sapi_name() !== 'cli') {
    die('Run from command line: php set_system_url.php');
}

$customUrl = $argv[1] ?? null;

if ($customUrl) {
    $systemUrl = rtrim($customUrl, '/') . '/';
} else {
    // Load .env from project root (parent of billing)
    $envPath = dirname(__DIR__) . '/.env';
    if (!is_readable($envPath)) {
        fwrite(STDERR, "No .env found at {$envPath}. Pass URL as argument: php set_system_url.php \"http://localhost/billing/\"\n");
        exit(1);
    }
    $env = file_get_contents($envPath);
    if (!preg_match('/^\s*APP_URL\s*=\s*(\S+)/m', $env, $m)) {
        fwrite(STDERR, "APP_URL not found in .env. Set APP_URL or pass URL as argument.\n");
        exit(1);
    }
    $appUrl = trim($m[1], '"\'');
    $systemUrl = rtrim($appUrl, '/') . '/billing/';
}

require __DIR__ . '/configuration.php';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset={$mysql_charset}";
if ($db_port) {
    $dsn .= ";port={$db_port}";
}

try {
    $pdo = new PDO($dsn, $db_username, $db_password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    fwrite(STDERR, "Database connection failed: " . $e->getMessage() . "\n");
    exit(1);
}

$stmt = $pdo->prepare("UPDATE tblconfiguration SET value = ? WHERE setting = ?");
$stmt->execute([$systemUrl, 'SystemURL']);
$updated = $stmt->rowCount();

$stmt->execute([$systemUrl, 'SystemSSLURL']);
$updated += $stmt->rowCount();

echo "WHMCS System URL set to: {$systemUrl}\n";
echo "Updated {$updated} configuration row(s).\n";

if (php_sapi_name() === 'cli') {
    echo "Done. You can delete this file (billing/set_system_url.php) after use.\n";
}
