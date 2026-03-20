<?php
/**
 * Seed WHMCS with Weberse company details and logo from the main website.
 *
 * Run from project root: php billing/seed_company.php
 *
 * - Copies public/assets/legacy/weberse-light.svg → billing/assets/img/weberse-logo.svg
 * - Updates tblconfiguration: CompanyName, Email, LogoURL, InvoicePayTo, Signature,
 *   SystemEmailsFromName, SystemEmailsFromEmail, DefaultCountry
 */

if (php_sapi_name() !== 'cli') {
    die('Run from command line: php billing/seed_company.php' . "\n");
}

$billingDir = __DIR__;
$projectRoot = dirname($billingDir);

// Weberse company details (keep in sync with config/platform.php)
$company = [
    'name' => 'Weberse Infotech Private Limited',
    'tagline' => 'Innovating Intelligence. Building the Future.',
    'email' => 'info@weberse.com',
    'phone' => '+91 81769 91383',
    'location' => 'Jaipur, Rajasthan, India',
    'socials' => [
        'linkedin' => 'https://linkedin.com/weweberse',
        'instagram' => 'https://instagram.com/weweberse',
    ],
];

require $billingDir . '/configuration.php';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=" . ($mysql_charset ?? 'utf8');
if (!empty($db_port)) {
    $dsn .= ";port={$db_port}";
}

try {
    $pdo = new PDO($dsn, $db_username, $db_password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    fwrite(STDERR, "Database connection failed: " . $e->getMessage() . "\n");
    exit(1);
}

$now = date('Y-m-d H:i:s');

// ----- Copy logo from main website -----
$logoSource = $projectRoot . '/public/assets/legacy/weberse-light.svg';
$logoDestDir = $billingDir . '/assets/img';
$logoDest = $logoDestDir . '/weberse-logo.svg';
$logoUrl = 'assets/img/weberse-logo.svg';

if (!is_readable($logoSource)) {
    fwrite(STDERR, "Logo not found: {$logoSource}\n");
    exit(1);
}

if (!is_dir($logoDestDir)) {
    mkdir($logoDestDir, 0755, true);
}
copy($logoSource, $logoDest);
echo "Logo copied: weberse-light.svg → billing/assets/img/weberse-logo.svg\n";

// ----- Update tblconfiguration -----
$updates = [
    'CompanyName' => $company['name'],
    'Email' => $company['email'],
    'LogoURL' => $logoUrl,
    'InvoicePayTo' => $company['name'] . "\n" . $company['location'] . "\n" . $company['phone'] . "\n" . $company['email'],
    'Signature' => $company['name'],
    'SystemEmailsFromName' => $company['name'],
    'SystemEmailsFromEmail' => $company['email'],
    'DefaultCountry' => 'IN',
];

$stmt = $pdo->prepare("UPDATE tblconfiguration SET value = ?, updated_at = ? WHERE setting = ?");
foreach ($updates as $setting => $value) {
    $stmt->execute([$value, $now, $setting]);
    if ($stmt->rowCount() > 0) {
        echo "  {$setting}: updated\n";
    }
}

echo "\nCompany seeded: {$company['name']}\n";
echo "  Email: {$company['email']}\n";
echo "  Logo: {$logoUrl}\n";
echo "  Address/Location: {$company['location']}\n";
echo "Done. Clear WHMCS cache or re-open client area to see the logo.\n";
