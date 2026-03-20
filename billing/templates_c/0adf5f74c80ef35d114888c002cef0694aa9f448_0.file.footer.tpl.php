<?php
/* Smarty version 4.5.3, created on 2026-03-17 14:14:36
  from '/Users/prashant/Desktop/Weberse/billing/templates/weberse/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.3',
  'unifunc' => 'content_69b961cce61fd9_05389986',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0adf5f74c80ef35d114888c002cef0694aa9f448' => 
    array (
      0 => '/Users/prashant/Desktop/Weberse/billing/templates/weberse/footer.tpl',
      1 => 1773756871,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69b961cce61fd9_05389986 (Smarty_Internal_Template $_smarty_tpl) {
?>                    </div>

                    </div>
                    <?php if (!$_smarty_tpl->tpl_vars['inShoppingCart']->value && $_smarty_tpl->tpl_vars['secondarySidebar']->value->hasChildren()) {?>
                        <div class="d-lg-none sidebar sidebar-secondary">
                            <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['template']->value)."/includes/sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('sidebar'=>$_smarty_tpl->tpl_vars['secondarySidebar']->value), 0, true);
?>
                        </div>
                    <?php }?>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>

    <footer id="footer" class="footer weberse-footer">
        <div class="weberse-footer-accent"></div>
        <div class="container weberse-footer-container">
            <ul class="list-inline mb-7 text-center float-lg-right">
                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['template']->value)."/includes/social-accounts.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                <?php if ($_smarty_tpl->tpl_vars['languagechangeenabled']->value && count($_smarty_tpl->tpl_vars['locales']->value) > 1 || $_smarty_tpl->tpl_vars['currencies']->value) {?>
                    <li class="list-inline-item">
                        <button type="button" class="btn" data-toggle="modal" data-target="#modalChooseLanguage">
                            <div class="d-inline-block align-middle">
                                <div class="iti-flag <?php if ($_smarty_tpl->tpl_vars['activeLocale']->value['countryCode'] === '001') {?>us<?php } else {
echo mb_strtolower((string) $_smarty_tpl->tpl_vars['activeLocale']->value['countryCode'], 'UTF-8');
}?>"></div>
                            </div>
                            <?php echo $_smarty_tpl->tpl_vars['activeLocale']->value['localisedName'];?>

                            /
                            <?php echo $_smarty_tpl->tpl_vars['activeCurrency']->value['prefix'];?>

                            <?php echo $_smarty_tpl->tpl_vars['activeCurrency']->value['code'];?>

                        </button>
                    </li>
                <?php }?>
            </ul>

            <ul class="nav justify-content-center justify-content-lg-start mb-7">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/contact.php">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'contactus'),$_smarty_tpl ) );?>

                    </a>
                </li>
                <?php if ($_smarty_tpl->tpl_vars['acceptTOS']->value) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['tosURL']->value;?>
" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'ordertos'),$_smarty_tpl ) );?>
</a>
                    </li>
                <?php }?>
            </ul>

            <p class="copyright mb-0">
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>"copyrightFooterNotice",'year'=>$_smarty_tpl->tpl_vars['date_year']->value,'company'=>$_smarty_tpl->tpl_vars['companyname']->value),$_smarty_tpl ) );?>

            </p>
        </div>
    </footer>

        <div class="modal fade weberse-lead-modal" id="weberseLeadModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Start Your Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'close'),$_smarty_tpl ) );?>
">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">Share a few details and we’ll get back with next steps.</p>

                    <div class="alert alert-success d-none" data-weberse-lead-success></div>
                    <div class="alert alert-danger d-none" data-weberse-lead-error></div>

                    <form class="row" data-weberse-lead-form>
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Company</label>
                            <input type="text" class="form-control" name="company">
                        </div>
                        <div class="form-group col-12">
                            <label>Topic</label>
                            <select class="form-control" name="title">
                                <option value="Hosting inquiry">Hosting inquiry</option>
                                <option value="Website / redesign">Website / redesign</option>
                                <option value="Custom software">Custom software</option>
                                <option value="AI automation">AI automation</option>
                                <option value="WhatsApp automation">WhatsApp automation</option>
                                <option value="Email automation">Email automation</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>Message</label>
                            <textarea class="form-control" name="message" rows="4" required placeholder="Tell us what you want to build, your timeline, and any links."></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" data-weberse-lead-submit>
                                Send Inquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="fullpage-overlay" class="w-hidden">
        <div class="outer-wrapper">
            <div class="inner-wrapper">
                <img src="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/assets/img/overlay-spinner.svg" alt="">
                <br>
                <span class="msg"></span>
            </div>
        </div>
    </div>

    <div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'close'),$_smarty_tpl ) );?>
</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'loading'),$_smarty_tpl ) );?>

                </div>
                <div class="modal-footer">
                    <div class="float-left loader">
                        <i class="fas fa-circle-notch fa-spin"></i>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'loading'),$_smarty_tpl ) );?>

                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'close'),$_smarty_tpl ) );?>

                    </button>
                    <button type="button" class="btn btn-primary modal-submit">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'submit'),$_smarty_tpl ) );?>

                    </button>
                </div>
            </div>
        </div>
    </div>

    <form method="get" action="<?php echo $_smarty_tpl->tpl_vars['currentpagelinkback']->value;?>
">
        <div class="modal modal-localisation" id="modalChooseLanguage" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <?php if ($_smarty_tpl->tpl_vars['languagechangeenabled']->value && count($_smarty_tpl->tpl_vars['locales']->value) > 1) {?>
                            <h5 class="h5 pt-5 pb-3"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'chooselanguage'),$_smarty_tpl ) );?>
</h5>
                            <div class="row item-selector">
                                <input type="hidden" name="language" data-current="<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
" />
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locales']->value, 'locale');
$_smarty_tpl->tpl_vars['locale']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['locale']->value) {
$_smarty_tpl->tpl_vars['locale']->do_else = false;
?>
                                    <div class="col-4">
                                        <a href="#" class="item<?php if ($_smarty_tpl->tpl_vars['language']->value == $_smarty_tpl->tpl_vars['locale']->value['language']) {?> active<?php }?>" data-value="<?php echo $_smarty_tpl->tpl_vars['locale']->value['language'];?>
">
                                            <?php echo $_smarty_tpl->tpl_vars['locale']->value['localisedName'];?>

                                        </a>
                                    </div>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </div>
                        <?php }?>
                        <?php if (!$_smarty_tpl->tpl_vars['loggedin']->value && $_smarty_tpl->tpl_vars['currencies']->value) {?>
                            <p class="h5 pt-5 pb-3"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'choosecurrency'),$_smarty_tpl ) );?>
</p>
                            <div class="row item-selector">
                                <input type="hidden" name="currency" data-current="<?php echo $_smarty_tpl->tpl_vars['activeCurrency']->value['id'];?>
" value="">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['currencies']->value, 'selectCurrency');
$_smarty_tpl->tpl_vars['selectCurrency']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['selectCurrency']->value) {
$_smarty_tpl->tpl_vars['selectCurrency']->do_else = false;
?>
                                    <div class="col-4">
                                        <a href="#" class="item<?php if ($_smarty_tpl->tpl_vars['activeCurrency']->value['id'] == $_smarty_tpl->tpl_vars['selectCurrency']->value['id']) {?> active<?php }?>" data-value="<?php echo $_smarty_tpl->tpl_vars['selectCurrency']->value['id'];?>
">
                                            <?php echo $_smarty_tpl->tpl_vars['selectCurrency']->value['prefix'];?>
 <?php echo $_smarty_tpl->tpl_vars['selectCurrency']->value['code'];?>

                                        </a>
                                    </div>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </div>
                        <?php }?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'apply'),$_smarty_tpl ) );?>
</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php if (!$_smarty_tpl->tpl_vars['loggedin']->value && $_smarty_tpl->tpl_vars['adminLoggedIn']->value) {?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/logout.php?returntoadmin=1" class="btn btn-return-to-admin" data-toggle="tooltip" data-placement="bottom" title="<?php if ($_smarty_tpl->tpl_vars['adminMasqueradingAsClient']->value) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'adminmasqueradingasclient'),$_smarty_tpl ) );?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'logoutandreturntoadminarea'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'adminloggedin'),$_smarty_tpl ) );?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'returntoadminarea'),$_smarty_tpl ) );
}?>">
            <i class="fas fa-redo-alt"></i>
            <span class="d-none d-md-inline-block"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>"admin.returnToAdmin"),$_smarty_tpl ) );?>
</span>
        </a>
    <?php }?>

    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['template']->value)."/includes/generate-password.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

    <?php echo $_smarty_tpl->tpl_vars['footeroutput']->value;?>


    <?php echo '<script'; ?>
>
        (function () {
            var openButtons = document.querySelectorAll('[data-weberse-lead-open]');
            if (!openButtons.length) return;

            var modalId = '#weberseLeadModal';
            var form = document.querySelector('[data-weberse-lead-form]');
            var successEl = document.querySelector('[data-weberse-lead-success]');
            var errorEl = document.querySelector('[data-weberse-lead-error]');
            var submitBtn = document.querySelector('[data-weberse-lead-submit]');

            openButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    if (successEl) { successEl.classList.add('d-none'); successEl.textContent = ''; }
                    if (errorEl) { errorEl.classList.add('d-none'); errorEl.textContent = ''; }
                    if (window.jQuery && jQuery(modalId).modal) {
                        jQuery(modalId).modal('show');
                    }
                });
            });

            if (!form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (successEl) { successEl.classList.add('d-none'); successEl.textContent = ''; }
                if (errorEl) { errorEl.classList.add('d-none'); errorEl.textContent = ''; }

                var fd = new FormData(form);
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Sending...';
                }

                fetch('/lead-intake/whmcs', {
                    method: 'POST',
                    body: fd,
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin'
                }).then(function (res) {
                    return res.json().catch(function () { return null; }).then(function (json) {
                        return { ok: res.ok, status: res.status, json: json };
                    });
                }).then(function (result) {
                    if (result.ok && result.json && result.json.ok) {
                        if (successEl) {
                            successEl.textContent = result.json.message || 'Submitted.';
                            successEl.classList.remove('d-none');
                        }
                        form.reset();
                        return;
                    }

                    var msg = (result.json && (result.json.message || result.json.error)) || 'Could not submit. Please try again.';
                    if (result.json && result.json.errors) {
                        var firstKey = Object.keys(result.json.errors)[0];
                        if (firstKey && result.json.errors[firstKey] && result.json.errors[firstKey][0]) {
                            msg = result.json.errors[firstKey][0];
                        }
                    }
                    if (errorEl) {
                        errorEl.textContent = msg;
                        errorEl.classList.remove('d-none');
                    }
                }).catch(function () {
                    if (errorEl) {
                        errorEl.textContent = 'Network error. Please try again.';
                        errorEl.classList.remove('d-none');
                    }
                }).finally(function () {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Send Inquiry';
                    }
                });
            });
        })();
    <?php echo '</script'; ?>
>

</body>
</html>

<?php }
}
