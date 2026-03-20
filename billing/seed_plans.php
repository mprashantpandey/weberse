<?php
/**
 * Seed WHMCS with product groups, all product types, addons, config options,
 * domain TLD pricing, announcements, and knowledge base for testing.
 *
 * Run from project root: php billing/seed_plans.php
 *
 * Creates: Hosting, VPS, Dedicated Servers, WordPress Hosting, Cloud Hosting,
 * Domains (group), Other Services, Addons, Config options, Domain TLDs, KB, Announcements.
 */

if (php_sapi_name() !== 'cli') {
    die('Run from command line: php billing/seed_plans.php' . "\n");
}

require __DIR__ . '/configuration.php';

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

$empty = '';
$now = date('Y-m-d H:i:s');
$currencyId = 1;

// ----- Helpers -----
function getOrCreateProductGroup(PDO $pdo, string $name, string $slug, string $headline, string $tagline, string &$now): int {
    $stmt = $pdo->prepare("SELECT id FROM tblproductgroups WHERE name = ? LIMIT 1");
    $stmt->execute([$name]);
    $id = $stmt->fetchColumn();
    if ($id) {
        return (int) $id;
    }
    $pdo->prepare("
        INSERT INTO tblproductgroups (name, slug, headline, tagline, orderfrmtpl, disabledgateways, hidden, `order`, icon, created_at, updated_at)
        VALUES (?, ?, ?, ?, 'standard_cart', '', 0, 0, '', ?, ?)
    ")->execute([$name, $slug, $headline, $tagline, $now, $now]);
    return (int) $pdo->lastInsertId();
}

function productDefaults(): array {
    $e = '';
    $def = [
        'type' => 'other', 'gid' => 1, 'hidden' => 0, 'showdomainoptions' => 0, 'welcomeemail' => 0,
        'stockcontrol' => 0, 'qty' => 0, 'proratabilling' => 0, 'proratadate' => 1, 'proratachargenextmonth' => 1,
        'paytype' => 'recurring', 'allowqty' => 0, 'subdomain' => $e, 'autosetup' => $e, 'servertype' => 'none',
        'servergroup' => 0, 'freedomain' => $e, 'freedomainpaymentterms' => $e, 'freedomaintlds' => $e,
        'recurringcycles' => 0, 'autoterminatedays' => 0, 'autoterminateemail' => 0, 'configoptionsupgrade' => 0,
        'billingcycleupgrade' => $e, 'upgradeemail' => 0, 'overagesenabled' => $e, 'overagesdisklimit' => 0,
        'overagesbwlimit' => 0, 'overagesdiskprice' => 0.0000, 'overagesbwprice' => 0.0000, 'tax' => 1,
        'affiliateonetime' => 0, 'affiliatepaytype' => $e, 'affiliatepayamount' => 0.00, 'order' => 0,
        'retired' => 0, 'is_featured' => 0, 'color' => $e, 'tagline' => $e, 'short_description' => $e,
    ];
    for ($i = 1; $i <= 24; $i++) {
        $def["configoption{$i}"] = $e;
    }
    return $def;
}

function insertProduct(PDO $pdo, int $gid, array $plan, array $prices, int $currencyId, string $now): int {
    $product = productDefaults();
    $product['name'] = $plan['name'];
    $product['slug'] = $plan['slug'];
    $product['description'] = $plan['description'];
    $product['short_description'] = $plan['short_description'] ?? $plan['name'];
    $product['tagline'] = $plan['tagline'] ?? '';
    $product['gid'] = $gid;
    $product['order'] = $plan['order'] ?? 0;
    if (isset($plan['paytype'])) {
        $product['paytype'] = $plan['paytype'];
    }

    $cols = array_keys($product);
    $cols[] = 'created_at';
    $cols[] = 'updated_at';
    $colsQuoted = array_map(fn($c) => '`' . $c . '`', $cols);
    $values = array_values($product);
    $values[] = $now;
    $values[] = $now;

    $sql = 'INSERT INTO tblproducts (' . implode(', ', $colsQuoted) . ') VALUES (' . implode(', ', array_fill(0, count($cols), '?')) . ')';
    $pdo->prepare($sql)->execute($values);
    $productId = (int) $pdo->lastInsertId();

    $pr = $prices;
    $pdo->prepare("
        INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially)
        VALUES ('product', ?, ?, 0, 0, 0, 0, 0, 0, ?, ?, ?, ?, ?, ?)
    ")->execute([$currencyId, $productId, $pr[0], $pr[1], $pr[2], $pr[3], $pr[4], $pr[5]]);

    return $productId;
}

// ========== 1. HOSTING GROUP + PRODUCTS ==========
$gidHosting = getOrCreateProductGroup($pdo, 'Hosting', 'hosting', 'Web Hosting Plans', 'Reliable hosting for your sites', $now);
echo "Product group: Hosting (id={$gidHosting})\n";

$stmt = $pdo->prepare("SELECT id FROM tblproducts WHERE gid = ? ORDER BY id");
$stmt->execute([$gidHosting]);
$hostingProductIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (count($hostingProductIds) === 0) {
    $hostingPlans = [
        ['name' => 'Starter', 'slug' => 'starter', 'order' => 1, 'tagline' => 'For small sites',
         'description' => '<p>Ideal for personal sites.</p><ul><li>5 GB SSD</li><li>1 website</li><li>Free SSL</li></ul>', 'short_description' => '5 GB SSD, 1 website'],
        ['name' => 'Business', 'slug' => 'business', 'order' => 2, 'tagline' => 'Most popular',
         'description' => '<p>For growing businesses.</p><ul><li>25 GB SSD</li><li>5 websites</li><li>Free SSL & backup</li></ul>', 'short_description' => '25 GB SSD, 5 websites'],
        ['name' => 'Pro', 'slug' => 'pro', 'order' => 3, 'tagline' => 'High performance',
         'description' => '<p>High performance.</p><ul><li>50 GB SSD</li><li>Unlimited sites</li><li>CDN</li></ul>', 'short_description' => '50 GB SSD, unlimited sites'],
        ['name' => 'Enterprise', 'slug' => 'enterprise', 'order' => 4, 'tagline' => 'For large projects',
         'description' => '<p>Maximum resources.</p><ul><li>100 GB SSD</li><li>Unlimited sites</li><li>Dedicated IP</li></ul>', 'short_description' => '100 GB SSD, dedicated IP'],
    ];
    $hostingPrices = [
        [9.99, 26.97, 53.94, 99.00, 178.00, 259.00],
        [19.99, 53.97, 107.94, 199.00, 358.00, 499.00],
        [39.99, 107.97, 215.94, 399.00, 718.00, 999.00],
        [79.99, 215.97, 431.94, 799.00, 1438.00, 1999.00],
    ];
    foreach ($hostingPlans as $i => $plan) {
        $pid = insertProduct($pdo, $gidHosting, $plan, $hostingPrices[$i], $currencyId, $now);
        $hostingProductIds[] = $pid;
        echo "  Product: {$plan['name']} (id={$pid})\n";
    }
} else {
    echo "  Hosting products already exist (ids: " . implode(',', $hostingProductIds) . ")\n";
}

// ========== 2. OTHER SERVICES GROUP + PRODUCTS ==========
$gidOther = getOrCreateProductGroup($pdo, 'Other Services', 'other-services', 'Add-on Services', 'SSL, Backup & Support', $now);
echo "Product group: Other Services (id={$gidOther})\n";

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tblproducts WHERE gid = ?");
$stmt->execute([$gidOther]);
if ($stmt->fetchColumn() == 0) {
    $sslId = insertProduct($pdo, $gidOther, [
        'name' => 'SSL Certificate (DV)',
        'slug' => 'ssl-certificate',
        'description' => '<p>Domain Validation SSL for one domain. Trust seal and encryption.</p>',
        'short_description' => 'Single domain DV SSL',
        'tagline' => '1 year',
        'order' => 1,
        'paytype' => 'onetime',
    ], [29.99, 29.99, 29.99, 29.99, 29.99, 29.99], $currencyId, $now);
    echo "  Product: SSL Certificate (id={$sslId})\n";

    insertProduct($pdo, $gidOther, [
        'name' => 'Daily Backup',
        'slug' => 'daily-backup',
        'description' => '<p>Automated daily backups with 7-day retention. One-click restore.</p>',
        'short_description' => 'Daily backups, 7-day retention',
        'tagline' => 'Per month',
        'order' => 2,
    ], [4.99, 14.97, 29.94, 49.00, 88.00, 127.00], $currencyId, $now);
    echo "  Product: Daily Backup\n";

    insertProduct($pdo, $gidOther, [
        'name' => 'Priority Support',
        'slug' => 'priority-support',
        'description' => '<p>Faster response times and dedicated support channel.</p>',
        'short_description' => 'Priority ticket response',
        'tagline' => 'Per month',
        'order' => 3,
    ], [14.99, 44.97, 89.94, 149.00, 268.00, 387.00], $currencyId, $now);
    echo "  Product: Priority Support\n";
}

// ========== 2a. VPS GROUP + PRODUCTS ==========
$gidVps = getOrCreateProductGroup($pdo, 'VPS', 'vps', 'VPS Hosting', 'Root access, scalable virtual servers', $now);
echo "Product group: VPS (id={$gidVps})\n";

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tblproducts WHERE gid = ?");
$stmt->execute([$gidVps]);
if ($stmt->fetchColumn() == 0) {
    $vpsPlans = [
        ['name' => 'VPS Starter', 'slug' => 'vps-starter', 'order' => 1, 'tagline' => '1 vCPU, 2 GB RAM',
         'description' => '<p>Entry-level VPS.</p><ul><li>1 vCPU</li><li>2 GB RAM</li><li>40 GB SSD</li><li>2 TB bandwidth</li><li>Root access</li></ul>', 'short_description' => '1 vCPU, 2 GB RAM, 40 GB SSD'],
        ['name' => 'VPS Growth', 'slug' => 'vps-growth', 'order' => 2, 'tagline' => '2 vCPU, 4 GB RAM',
         'description' => '<p>For growing apps.</p><ul><li>2 vCPU</li><li>4 GB RAM</li><li>80 GB SSD</li><li>4 TB bandwidth</li><li>Root access</li></ul>', 'short_description' => '2 vCPU, 4 GB RAM, 80 GB SSD'],
        ['name' => 'VPS Pro', 'slug' => 'vps-pro', 'order' => 3, 'tagline' => '4 vCPU, 8 GB RAM',
         'description' => '<p>High performance.</p><ul><li>4 vCPU</li><li>8 GB RAM</li><li>160 GB SSD</li><li>6 TB bandwidth</li><li>Root access</li></ul>', 'short_description' => '4 vCPU, 8 GB RAM, 160 GB SSD'],
        ['name' => 'VPS Enterprise', 'slug' => 'vps-enterprise', 'order' => 4, 'tagline' => '8 vCPU, 16 GB RAM',
         'description' => '<p>Maximum resources.</p><ul><li>8 vCPU</li><li>16 GB RAM</li><li>320 GB SSD</li><li>10 TB bandwidth</li><li>Root access</li></ul>', 'short_description' => '8 vCPU, 16 GB RAM, 320 GB SSD'],
    ];
    $vpsPrices = [
        [14.99, 40.47, 80.94, 149.00, 268.00, 387.00],
        [29.99, 80.97, 161.94, 299.00, 538.00, 777.00],
        [59.99, 161.97, 323.94, 599.00, 1078.00, 1557.00],
        [119.99, 323.97, 647.94, 1199.00, 2158.00, 3117.00],
    ];
    foreach ($vpsPlans as $i => $plan) {
        insertProduct($pdo, $gidVps, $plan, $vpsPrices[$i], $currencyId, $now);
        echo "  Product: {$plan['name']}\n";
    }
}

// ========== 2b. DEDICATED SERVERS GROUP + PRODUCTS ==========
$gidDedicated = getOrCreateProductGroup($pdo, 'Dedicated Servers', 'dedicated-servers', 'Dedicated Servers', 'Full root access, bare metal', $now);
echo "Product group: Dedicated Servers (id={$gidDedicated})\n";

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tblproducts WHERE gid = ?");
$stmt->execute([$gidDedicated]);
if ($stmt->fetchColumn() == 0) {
    $dedPlans = [
        ['name' => 'Dedicated Standard', 'slug' => 'dedicated-standard', 'order' => 1, 'tagline' => '4 cores, 16 GB RAM',
         'description' => '<p>Single processor dedicated.</p><ul><li>4 CPU cores</li><li>16 GB RAM</li><li>500 GB SSD</li><li>10 TB bandwidth</li><li>Full root</li></ul>', 'short_description' => '4 cores, 16 GB RAM, 500 GB SSD'],
        ['name' => 'Dedicated Performance', 'slug' => 'dedicated-performance', 'order' => 2, 'tagline' => '8 cores, 32 GB RAM',
         'description' => '<p>High-performance dedicated.</p><ul><li>8 CPU cores</li><li>32 GB RAM</li><li>1 TB SSD</li><li>15 TB bandwidth</li><li>Full root</li></ul>', 'short_description' => '8 cores, 32 GB RAM, 1 TB SSD'],
        ['name' => 'Dedicated Premium', 'slug' => 'dedicated-premium', 'order' => 3, 'tagline' => '16 cores, 64 GB RAM',
         'description' => '<p>Maximum dedicated.</p><ul><li>16 CPU cores</li><li>64 GB RAM</li><li>2 TB SSD NVMe</li><li>20 TB bandwidth</li><li>Full root</li></ul>', 'short_description' => '16 cores, 64 GB RAM, 2 TB NVMe'],
    ];
    $dedPrices = [
        [99.99, 269.97, 539.94, 999.00, 1798.00, 2597.00],
        [199.99, 539.97, 1079.94, 1999.00, 3598.00, 5197.00],
        [399.99, 1079.97, 2159.94, 3999.00, 7198.00, 10397.00],
    ];
    foreach ($dedPlans as $i => $plan) {
        insertProduct($pdo, $gidDedicated, $plan, $dedPrices[$i], $currencyId, $now);
        echo "  Product: {$plan['name']}\n";
    }
}

// ========== 2c. WORDPRESS HOSTING GROUP + PRODUCTS ==========
$gidWp = getOrCreateProductGroup($pdo, 'WordPress Hosting', 'wordpress-hosting', 'WordPress Hosting', 'Optimized for WordPress', $now);
echo "Product group: WordPress Hosting (id={$gidWp})\n";

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tblproducts WHERE gid = ?");
$stmt->execute([$gidWp]);
if ($stmt->fetchColumn() == 0) {
    $wpPlans = [
        ['name' => 'WP Starter', 'slug' => 'wp-starter', 'order' => 1, 'tagline' => '1 site',
         'description' => '<p>One WordPress site.</p><ul><li>1 WordPress install</li><li>10 GB SSD</li><li>Free SSL</li><li>Auto updates</li><li>Staging</li></ul>', 'short_description' => '1 site, 10 GB, staging'],
        ['name' => 'WP Business', 'slug' => 'wp-business', 'order' => 2, 'tagline' => '3 sites',
         'description' => '<p>Multiple WordPress sites.</p><ul><li>3 WordPress installs</li><li>30 GB SSD</li><li>Free SSL & backup</li><li>Auto updates</li><li>Staging + clone</li></ul>', 'short_description' => '3 sites, 30 GB, backup'],
        ['name' => 'WP Pro', 'slug' => 'wp-pro', 'order' => 3, 'tagline' => '10 sites',
         'description' => '<p>For agencies.</p><ul><li>10 WordPress installs</li><li>60 GB SSD</li><li>Free SSL, backup, CDN</li><li>Priority support</li><li>White-label</li></ul>', 'short_description' => '10 sites, 60 GB, CDN'],
    ];
    $wpPrices = [
        [12.99, 35.07, 70.14, 129.00, 232.00, 335.00],
        [24.99, 67.47, 134.94, 249.00, 448.00, 647.00],
        [49.99, 134.97, 269.94, 499.00, 898.00, 1297.00],
    ];
    foreach ($wpPlans as $i => $plan) {
        insertProduct($pdo, $gidWp, $plan, $wpPrices[$i], $currencyId, $now);
        echo "  Product: {$plan['name']}\n";
    }
}

// ========== 2d. CLOUD HOSTING GROUP + PRODUCTS ==========
$gidCloud = getOrCreateProductGroup($pdo, 'Cloud Hosting', 'cloud-hosting', 'Cloud Hosting', 'Scalable, high-availability cloud', $now);
echo "Product group: Cloud Hosting (id={$gidCloud})\n";

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tblproducts WHERE gid = ?");
$stmt->execute([$gidCloud]);
if ($stmt->fetchColumn() == 0) {
    $cloudPlans = [
        ['name' => 'Cloud Starter', 'slug' => 'cloud-starter', 'order' => 1, 'tagline' => '2 vCPU, 4 GB',
         'description' => '<p>Cloud entry tier.</p><ul><li>2 vCPU</li><li>4 GB RAM</li><li>50 GB SSD</li><li>Auto-scaling</li><li>99.9% SLA</li></ul>', 'short_description' => '2 vCPU, 4 GB, 50 GB SSD'],
        ['name' => 'Cloud Growth', 'slug' => 'cloud-growth', 'order' => 2, 'tagline' => '4 vCPU, 8 GB',
         'description' => '<p>Scalable cloud.</p><ul><li>4 vCPU</li><li>8 GB RAM</li><li>100 GB SSD</li><li>Auto-scaling</li><li>99.95% SLA</li></ul>', 'short_description' => '4 vCPU, 8 GB, 100 GB SSD'],
        ['name' => 'Cloud Enterprise', 'slug' => 'cloud-enterprise', 'order' => 3, 'tagline' => '8 vCPU, 16 GB',
         'description' => '<p>High-availability cloud.</p><ul><li>8 vCPU</li><li>16 GB RAM</li><li>200 GB SSD</li><li>Load balancer</li><li>99.99% SLA</li></ul>', 'short_description' => '8 vCPU, 16 GB, 200 GB SSD'],
    ];
    $cloudPrices = [
        [34.99, 94.47, 188.94, 349.00, 628.00, 907.00],
        [69.99, 188.97, 377.94, 699.00, 1258.00, 1817.00],
        [139.99, 377.97, 755.94, 1399.00, 2518.00, 3637.00],
    ];
    foreach ($cloudPlans as $i => $plan) {
        insertProduct($pdo, $gidCloud, $plan, $cloudPrices[$i], $currencyId, $now);
        echo "  Product: {$plan['name']}\n";
    }
}

// ========== 2e. DOMAINS GROUP (display only; TLD pricing in section 5) ==========
$gidDomains = getOrCreateProductGroup($pdo, 'Domains', 'domains', 'Domain Names', 'Register or transfer your domain', $now);
echo "Product group: Domains (id={$gidDomains})\n";
// Domains are ordered via domain search; TLD pricing is seeded below. No products in this group.

// ========== 3. ADDONS (for hosting products) ==========
$stmt = $pdo->query("SELECT COUNT(*) FROM tbladdons WHERE name = 'Extra 5 GB Storage'");
if ($stmt->fetchColumn() == 0 && count($hostingProductIds) > 0) {
    $packages = implode(',', $hostingProductIds);
    $pdo->prepare("
        INSERT INTO tbladdons (packages, name, description, billingcycle, allowqty, tax, showorder, hidden, retired, downloads, autoactivate, suspendproduct, welcomeemail, type, module, server_group_id, prorate, weight, autolinkby, created_at, updated_at)
        VALUES (?, 'Extra 5 GB Storage', 'Add 5 GB disk space to your hosting', 'monthly', 0, 1, 1, 0, 0, '', '', 0, 0, '', '', 0, 0, 0, '', ?, ?)
    ")->execute([$packages, $now, $now]);
    $addonId = (int) $pdo->lastInsertId();
    $pdo->prepare("
        INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially)
        VALUES ('addon', ?, ?, 0, 0, 0, 0, 0, 0, 2.99, 8.97, 17.94, 29.00, 52.00, 75.00)
    ")->execute([$currencyId, $addonId]);
    echo "Addon: Extra 5 GB Storage (\$2.99/mo)\n";

    $pdo->prepare("
        INSERT INTO tbladdons (packages, name, description, billingcycle, allowqty, tax, showorder, hidden, retired, downloads, autoactivate, suspendproduct, welcomeemail, type, module, server_group_id, prorate, weight, autolinkby, created_at, updated_at)
        VALUES (?, 'Dedicated IP', 'Your own dedicated IP address', 'monthly', 0, 1, 2, 0, 0, '', '', 0, 0, '', '', 0, 0, 0, '', ?, ?)
    ")->execute([$packages, $now, $now]);
    $addonId2 = (int) $pdo->lastInsertId();
    $pdo->prepare("
        INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially)
        VALUES ('addon', ?, ?, 0, 0, 0, 0, 0, 0, 5.99, 17.97, 35.94, 59.00, 106.00, 153.00)
    ")->execute([$currencyId, $addonId2]);
    echo "Addon: Dedicated IP (\$5.99/mo)\n";
}

// ========== 4. CONFIGURABLE OPTIONS (Backup frequency for hosting) ==========
$stmt = $pdo->query("SELECT id FROM tblproductconfiggroups WHERE name = 'Hosting Options' LIMIT 1");
$configGroupId = $stmt->fetchColumn();
if (!$configGroupId && count($hostingProductIds) > 0) {
    $pdo->prepare("INSERT INTO tblproductconfiggroups (name, description) VALUES ('Hosting Options', 'Optional upgrades')")->execute();
    $configGroupId = (int) $pdo->lastInsertId();

    $pdo->prepare("
        INSERT INTO tblproductconfigoptions (gid, optionname, optiontype, qtyminimum, qtymaximum, `order`, hidden)
        VALUES (?, 'Backup Frequency', '1', 0, 0, 0, 0)
    ")->execute([$configGroupId]);
    $optId = (int) $pdo->lastInsertId();

    $pdo->prepare("INSERT INTO tblproductconfigoptionssub (configid, optionname, sortorder, hidden) VALUES (?, 'Weekly (included)', 0, 0)")->execute([$optId]);
    $subId1 = (int) $pdo->lastInsertId();
    $pdo->prepare("INSERT INTO tblproductconfigoptionssub (configid, optionname, sortorder, hidden) VALUES (?, 'Daily (+$2/mo)', 1, 0)")->execute([$optId]);
    $subId2 = (int) $pdo->lastInsertId();

    $pdo->prepare("INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially) VALUES ('configoptions', ?, ?, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->execute([$currencyId, $subId1]);
    $pdo->prepare("INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially) VALUES ('configoptions', ?, ?, 0, 0, 0, 0, 0, 0, 2.00, 6.00, 12.00, 20.00, 36.00, 52.00)")->execute([$currencyId, $subId2]);

    foreach ($hostingProductIds as $pid) {
        $pdo->prepare("INSERT INTO tblproductconfiglinks (gid, pid) VALUES (?, ?)")->execute([$configGroupId, $pid]);
    }
    echo "Config option: Backup Frequency (Weekly / Daily +\$2)\n";
}

// ========== 5. DOMAIN TLD PRICING ==========
$tlds = [
    ['extension' => 'com', 'register' => 12.99, 'transfer' => 12.99, 'renew' => 12.99],
    ['extension' => 'net', 'register' => 13.99, 'transfer' => 13.99, 'renew' => 13.99],
    ['extension' => 'org', 'register' => 11.99, 'transfer' => 11.99, 'renew' => 11.99],
    ['extension' => 'in', 'register' => 8.99, 'transfer' => 8.99, 'renew' => 8.99],
    ['extension' => 'io', 'register' => 39.99, 'transfer' => 39.99, 'renew' => 39.99],
    ['extension' => 'co', 'register' => 29.99, 'transfer' => 29.99, 'renew' => 29.99],
    ['extension' => 'info', 'register' => 9.99, 'transfer' => 9.99, 'renew' => 9.99],
    ['extension' => 'biz', 'register' => 14.99, 'transfer' => 14.99, 'renew' => 14.99],
    ['extension' => 'co.in', 'register' => 7.99, 'transfer' => 7.99, 'renew' => 7.99],
    ['extension' => 'eu', 'register' => 10.99, 'transfer' => 10.99, 'renew' => 10.99],
];
foreach ($tlds as $t) {
    $stmt = $pdo->prepare("SELECT id FROM tbldomainpricing WHERE extension = ? LIMIT 1");
    $stmt->execute([$t['extension']]);
    if ($stmt->fetchColumn()) {
        continue;
    }
    $pdo->prepare("
        INSERT INTO tbldomainpricing (extension, dnsmanagement, emailforwarding, idprotection, eppcode, autoreg, `order`, `group`, grace_period, grace_period_fee, redemption_grace_period, redemption_grace_period_fee, created_at, updated_at)
        VALUES (?, 1, 1, 1, 1, '', 0, 'none', -1, 0.00, -1, -1.00, ?, ?)
    ")->execute([$t['extension'], $now, $now]);
    $tid = (int) $pdo->lastInsertId();
    $pdo->prepare("
        INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially)
        VALUES ('domainregister', ?, ?, 0, 0, 0, 0, 0, 0, ?, ?, ?, ?, ?, ?)
    ")->execute([$currencyId, $tid, $t['register'], $t['register']*2, $t['register']*2, $t['register'], $t['register']*2, $t['register']*3]);
    $pdo->prepare("
        INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially)
        VALUES ('domaintransfer', ?, ?, 0, 0, 0, 0, 0, 0, ?, ?, ?, ?, ?, ?)
    ")->execute([$currencyId, $tid, $t['transfer'], $t['transfer']*2, $t['transfer']*2, $t['transfer'], $t['transfer']*2, $t['transfer']*3]);
    $pdo->prepare("
        INSERT INTO tblpricing (type, currency, relid, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially)
        VALUES ('domainrenew', ?, ?, 0, 0, 0, 0, 0, 0, ?, ?, ?, ?, ?, ?)
    ")->execute([$currencyId, $tid, $t['renew'], $t['renew']*2, $t['renew']*2, $t['renew'], $t['renew']*2, $t['renew']*3]);
    echo "Domain TLD: .{$t['extension']} (reg \${$t['register']})\n";
}

// ========== 6. ANNOUNCEMENTS ==========
$announcements = [
    ['Welcome to Weberse Hosting', '<p>Thank you for choosing us. Order hosting, VPS, dedicated servers, WordPress, cloud, domains, SSL, and add-ons from the cart.</p><p>Need help? Open a support ticket or browse the knowledge base.</p>'],
    ['New: Daily Backup & Priority Support', '<p>We now offer Daily Backup and Priority Support as add-on services. Find them under Other Services or when ordering hosting.</p>'],
    ['Full range: VPS, Dedicated, WordPress & Cloud', '<p>We now offer VPS Hosting, Dedicated Servers, WordPress Hosting, and Cloud Hosting alongside shared hosting. Compare plans in the cart.</p>'],
];
foreach ($announcements as $a) {
    $stmt = $pdo->prepare("SELECT id FROM tblannouncements WHERE title = ? LIMIT 1");
    $stmt->execute([$a[0]]);
    if (!$stmt->fetchColumn()) {
        $pdo->prepare("
            INSERT INTO tblannouncements (date, title, announcement, published, parentid, language, created_at, updated_at)
            VALUES (?, ?, ?, 1, 0, '', ?, ?)
        ")->execute([$now, $a[0], $a[1], $now, $now]);
        echo "Announcement: {$a[0]}\n";
    }
}

// ========== 7. KNOWLEDGE BASE ==========
$kbCategories = [
    'Getting Started' => ['How to order hosting', 'How to order hosting', '<p>Go to the cart and select a product group (Hosting, Other Services) or search for a domain. Complete the order and follow the email instructions.</p>'],
    'Billing' => ['How to pay an invoice', 'How to pay an invoice', '<p>In the client area go to Billing > Invoices. Open an invoice and choose Pay Now to use your saved method or add a new one.</p>'],
    'Domains' => ['Domain registration and transfer', 'Domain registration and transfer', '<p>Use the domain search on the cart to register a new domain or transfer an existing one. We support .com, .net, .org, .in, .io and more.</p>'],
];
foreach ($kbCategories as $catName => $article) {
    $stmt = $pdo->prepare("SELECT id FROM tblknowledgebasecats WHERE name = ? LIMIT 1");
    $stmt->execute([$catName]);
    $catId = $stmt->fetchColumn();
    if (!$catId) {
        $pdo->prepare("INSERT INTO tblknowledgebasecats (parentid, name, description, hidden, catid, language) VALUES (0, ?, ?, '', 0, '')")->execute([$catName, "Articles about {$catName}"]);
        $catId = (int) $pdo->lastInsertId();
        $pdo->prepare("
            INSERT INTO tblknowledgebase (title, article, views, useful, votes, private, `order`, parentid, language)
            VALUES (?, ?, 0, 0, 0, '', 0, ?, '')
        ")->execute([$article[0], $article[2], $catId]);
        echo "KB: category '{$catName}' + article '{$article[0]}'\n";
    }
}

echo "\nDone. Seeded:\n";
echo "  Hosting (4), VPS (4), Dedicated (3), WordPress (3), Cloud (3), Domains (group), Other Services (3).\n";
echo "  Addons, Config options, Domain TLDs (.com/.net/.org/.in/.io/.co/.info/.biz/.co.in/.eu), Announcements, KB.\n";
echo "  Test: Cart > choose product group, Client Area, Admin > Setup > Products/Services.\n";
