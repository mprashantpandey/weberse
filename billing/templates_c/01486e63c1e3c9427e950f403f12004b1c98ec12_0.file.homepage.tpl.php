<?php
/* Smarty version 4.5.3, created on 2026-03-18 10:17:18
  from '/Users/prashant/Desktop/Weberse/billing/templates/weberse/homepage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.3',
  'unifunc' => 'content_69ba7baeef9508_63700893',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '01486e63c1e3c9427e950f403f12004b1c98ec12' => 
    array (
      0 => '/Users/prashant/Desktop/Weberse/billing/templates/weberse/homepage.tpl',
      1 => 1773829008,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69ba7baeef9508_63700893 (Smarty_Internal_Template $_smarty_tpl) {
?>
<section class="weberse-home-hero">
    <div class="weberse-home-hero-bg"></div>
    <div class="weberse-home-hero-inner">
        <div class="weberse-home-hero-copy">
            <p class="weberse-home-kicker">
                <span class="weberse-pill"><i class="far fa-shield-check"></i> Secure Hosting</span>
                <span class="weberse-pill"><i class="far fa-bolt"></i> Fast & Reliable</span>
                <span class="weberse-pill"><i class="far fa-headset"></i> Support-first</span>
            </p>

            <h1 class="weberse-home-title">Premium hosting for modern websites.</h1>
            <p class="weberse-home-subtitle">
                Launch on a stable, optimized stack with proactive security, backups, and performance tuning — built for businesses that don’t want surprises.
            </p>

            <div class="weberse-home-cta">
                <a class="btn btn-primary" href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/cart.php">Check Plans</a>
                <a class="btn btn-default" href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/clientarea.php<?php if (!$_smarty_tpl->tpl_vars['loggedin']->value) {?>?rp=/login<?php }?>">Client Area</a>
            </div>
        </div>

        <div class="weberse-home-hero-panel">
            <div class="weberse-home-hero-illustration" aria-hidden="true">
                <svg viewBox="0 0 520 360" width="520" height="360" xmlns="http://www.w3.org/2000/svg" role="img">
                    <defs>
                        <linearGradient id="wbg" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#0d2f50" stop-opacity="0.85"/>
                            <stop offset="1" stop-color="#071a2f" stop-opacity="0.95"/>
                        </linearGradient>
                        <linearGradient id="wacc" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0" stop-color="#73b655"/>
                            <stop offset="1" stop-color="#5a9a3d"/>
                        </linearGradient>
                        <filter id="wshadow" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="0" dy="16" stdDeviation="18" flood-color="#020c18" flood-opacity="0.35"/>
                        </filter>
                    </defs>

                    <rect x="14" y="18" width="492" height="320" rx="22" fill="url(#wbg)" filter="url(#wshadow)" opacity="0.92"/>
                    <rect x="40" y="46" width="440" height="66" rx="16" fill="#ffffff" opacity="0.06" stroke="#ffffff" stroke-opacity="0.12"/>
                    <rect x="62" y="67" width="220" height="10" rx="5" fill="#ffffff" opacity="0.55"/>
                    <rect x="62" y="86" width="160" height="10" rx="5" fill="#ffffff" opacity="0.30"/>
                    <rect x="360" y="64" width="98" height="30" rx="12" fill="url(#wacc)"/>
                    <path d="M390 80h38" stroke="#fff" stroke-opacity="0.85" stroke-width="3" stroke-linecap="round"/>
                    <path d="M408 70l10 10-10 10" fill="none" stroke="#fff" stroke-opacity="0.85" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>

                    <rect x="40" y="130" width="208" height="184" rx="18" fill="#ffffff" opacity="0.06" stroke="#ffffff" stroke-opacity="0.12"/>
                    <rect x="62" y="152" width="110" height="10" rx="5" fill="#ffffff" opacity="0.55"/>
                    <rect x="62" y="176" width="164" height="10" rx="5" fill="#ffffff" opacity="0.25"/>
                    <rect x="62" y="200" width="148" height="10" rx="5" fill="#ffffff" opacity="0.25"/>
                    <rect x="62" y="224" width="120" height="10" rx="5" fill="#ffffff" opacity="0.25"/>
                    <rect x="62" y="260" width="160" height="36" rx="14" fill="#73b655" opacity="0.22" stroke="#73b655" stroke-opacity="0.35"/>
                    <path d="M88 278h90" stroke="#73b655" stroke-opacity="0.95" stroke-width="4" stroke-linecap="round"/>

                    <rect x="272" y="130" width="208" height="86" rx="18" fill="#ffffff" opacity="0.06" stroke="#ffffff" stroke-opacity="0.12"/>
                    <rect x="294" y="152" width="110" height="10" rx="5" fill="#ffffff" opacity="0.55"/>
                    <rect x="294" y="174" width="154" height="10" rx="5" fill="#ffffff" opacity="0.25"/>

                    <rect x="272" y="228" width="98" height="86" rx="18" fill="#ffffff" opacity="0.06" stroke="#ffffff" stroke-opacity="0.12"/>
                    <rect x="382" y="228" width="98" height="86" rx="18" fill="#ffffff" opacity="0.06" stroke="#ffffff" stroke-opacity="0.12"/>
                    <circle cx="306" cy="262" r="14" fill="#73b655" opacity="0.26"/>
                    <path d="M300 262l4 4 10-12" fill="none" stroke="#73b655" stroke-opacity="0.95" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="416" cy="262" r="14" fill="#73b655" opacity="0.26"/>
                    <path d="M416 252v20" stroke="#73b655" stroke-opacity="0.95" stroke-width="3" stroke-linecap="round"/>
                    <path d="M408 262h16" stroke="#73b655" stroke-opacity="0.95" stroke-width="3" stroke-linecap="round"/>

                    <rect x="292" y="284" width="58" height="8" rx="4" fill="#ffffff" opacity="0.30"/>
                    <rect x="402" y="284" width="58" height="8" rx="4" fill="#ffffff" opacity="0.30"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<section class="weberse-home-section weberse-home-domain-band">
    <div class="weberse-home-section-head">
        <h2 class="weberse-home-h2">Domains</h2>
        <p class="weberse-home-muted">Search, register, and transfer domains the WHMCS way.</p>
    </div>

    <div class="weberse-home-split">
        <div class="weberse-home-split-card">
            <div class="weberse-home-split-title">Search your perfect domain</div>
            <div class="weberse-home-split-text">Checks availability via WHMCS `domainchecker.php` and takes you to results.</div>

            <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/domainchecker.php" class="weberse-domain-search" id="weberseDomainSearch">
                <input type="hidden" name="transfer" value="" id="weberseDomainTransferFlag" />
                <div class="input-group">
                    <input type="text" class="form-control" name="domain" placeholder="example.com" autocapitalize="none" autocomplete="off" required>
                    <div class="input-group-append">
                        <?php if ($_smarty_tpl->tpl_vars['registerdomainenabled']->value) {?>
                            <button type="submit" class="btn btn-primary" id="weberseDomainSearchBtn">
                                <i class="far fa-search"></i>
                                <span class="d-none d-sm-inline">Search</span>
                            </button>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['transferdomainenabled']->value) {?>
                            <button type="submit" class="btn btn-default" id="weberseDomainTransferBtn">
                                <i class="far fa-right-left"></i>
                                <span class="d-none d-sm-inline">Transfer</span>
                            </button>
                        <?php }?>
                    </div>
                </div>

                <div class="weberse-domain-chips" aria-label="Popular TLDs">
                    <button type="button" class="weberse-domain-chip" data-tld=".com">.com</button>
                    <button type="button" class="weberse-domain-chip" data-tld=".in">.in</button>
                    <button type="button" class="weberse-domain-chip" data-tld=".net">.net</button>
                    <button type="button" class="weberse-domain-chip" data-tld=".org">.org</button>
                </div>
            </form>
        </div>
        <div class="weberse-home-split-card">
            <div class="weberse-home-split-title">Built for domain management</div>
            <div class="weberse-home-split-text">A clean portal for renewals, DNS options, and support when you need it.</div>

            <div class="weberse-domain-feature-list">
                <div class="weberse-domain-feature"><i class="far fa-calendar-check"></i> Renewal reminders & easy renewals</div>
                <div class="weberse-domain-feature"><i class="far fa-gear"></i> DNS, ID protection & add-ons</div>
                <div class="weberse-domain-feature"><i class="far fa-life-ring"></i> Human support for DNS issues</div>
            </div>

            <div class="weberse-home-cta">
                <a class="btn btn-primary" href="<?php echo routePath('domain-pricing');?>
">Domain pricing</a>
                <a class="btn btn-default" href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/cart.php?a=add&domain=register">Register</a>
            </div>
        </div>
    </div>
</section>

<?php echo '<script'; ?>
>
    (function () {
        var form = document.getElementById('weberseDomainSearch');
        var searchBtn = document.getElementById('weberseDomainSearchBtn');
        var transferBtn = document.getElementById('weberseDomainTransferBtn');
        var transferFlag = document.getElementById('weberseDomainTransferFlag');

        // Mirror WHMCS behaviour: empty = register search, non-empty = transfer flow.
        if (searchBtn && transferFlag) {
            searchBtn.addEventListener('click', function () {
                transferFlag.value = '';
            });
        }

        if (transferBtn && transferFlag && form) {
            transferBtn.addEventListener('click', function (e) {
                transferFlag.value = '1';
                // Ensure the flag is set before the submit.
                if (e) {
                    e.preventDefault();
                }
                form.submit();
            });
        }

        var chips = document.querySelectorAll('#weberseDomainSearch .weberse-domain-chip');
        var input = document.querySelector('#weberseDomainSearch input[name="domain"]');
        if (chips && input) {
            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    var tld = chip.getAttribute('data-tld') || '';
                    var current = (input.value || '').trim();
                    if (!current) {
                        input.focus();
                        return;
                    }
                    if (current.indexOf('.') === -1) {
                        input.value = current + tld;
                        return;
                    }
                    input.value = current.replace(/\.[a-z0-9-]+$/i, tld);
                });
            });
        }
    })();
<?php echo '</script'; ?>
>

<section class="weberse-home-section weberse-home-section-alt">
    <div class="weberse-home-section-head">
        <h2 class="weberse-home-h2">Lowest prices. Best services.</h2>
        <p class="weberse-home-muted">Transparent plans and support that actually helps.</p>
    </div>

    <div class="weberse-feature-grid">
        <div class="weberse-feature-card">
            <div class="weberse-feature-ico"><i class="far fa-tags"></i></div>
            <div class="weberse-feature-title">Transparent pricing</div>
            <div class="weberse-feature-text">No hidden surprises. Clear renewals and clear upgrades.</div>
        </div>
        <div class="weberse-feature-card">
            <div class="weberse-feature-ico"><i class="far fa-rocket-launch"></i></div>
            <div class="weberse-feature-title">Performance-first</div>
            <div class="weberse-feature-text">Caching guidance, tuning, and a stable stack for real traffic.</div>
        </div>
        <div class="weberse-feature-card">
            <div class="weberse-feature-ico"><i class="far fa-headset"></i></div>
            <div class="weberse-feature-title">Support you can trust</div>
            <div class="weberse-feature-text">Fast replies, clear answers, and real fixes when you need them.</div>
        </div>
    </div>
</section>

<section class="weberse-home-section">
    <div class="weberse-home-section-head">
        <h2 class="weberse-home-h2">Uptime & security</h2>
        <p class="weberse-home-muted">Built for reliability with proactive protection.</p>
    </div>

    <div class="weberse-feature-grid">
        <div class="weberse-feature-card">
            <div class="weberse-feature-ico"><i class="far fa-shield-check"></i></div>
            <div class="weberse-feature-title">Hardening & monitoring</div>
            <div class="weberse-feature-text">Security best practices, monitoring, and rapid response workflows.</div>
        </div>
        <div class="weberse-feature-card">
            <div class="weberse-feature-ico"><i class="far fa-lock"></i></div>
            <div class="weberse-feature-title">SSL & safe defaults</div>
            <div class="weberse-feature-text">TLS-ready setup and guidance to keep deployments secure.</div>
        </div>
        <div class="weberse-feature-card">
            <div class="weberse-feature-ico"><i class="far fa-arrows-rotate"></i></div>
            <div class="weberse-feature-title">Backups & restore</div>
            <div class="weberse-feature-text">Recovery options designed to reduce risk and downtime.</div>
        </div>
    </div>
</section>

<?php if (!empty($_smarty_tpl->tpl_vars['productGroups']->value)) {?>
    <section class="weberse-home-section">
        <div class="weberse-home-section-head">
            <h2 class="weberse-home-h2">Choose a plan that fits.</h2>
            <p class="weberse-home-muted">Start small, scale anytime.</p>
        </div>

        <div class="weberse-plan-grid">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['productGroups']->value, 'productGroup');
$_smarty_tpl->tpl_vars['productGroup']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['productGroup']->value) {
$_smarty_tpl->tpl_vars['productGroup']->do_else = false;
?>
                <a class="weberse-plan-card" href="<?php echo $_smarty_tpl->tpl_vars['productGroup']->value->getRoutePath();?>
">
                    <div class="weberse-plan-top">
                        <div class="weberse-plan-name"><?php echo $_smarty_tpl->tpl_vars['productGroup']->value->name;?>
</div>
                        <?php if ($_smarty_tpl->tpl_vars['productGroup']->value->tagline) {?><div class="weberse-plan-tagline"><?php echo $_smarty_tpl->tpl_vars['productGroup']->value->tagline;?>
</div><?php }?>
                    </div>
                    <div class="weberse-plan-bottom">
                        <span class="weberse-plan-cta">View plans <i class="far fa-arrow-right"></i></span>
                    </div>
                </a>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
    </section>
<?php }?>

<?php }
}
