                    </div>

                    </div>
                    {if !$inShoppingCart && $secondarySidebar->hasChildren()}
                        <div class="d-lg-none sidebar sidebar-secondary">
                            {include file="$template/includes/sidebar.tpl" sidebar=$secondarySidebar}
                        </div>
                    {/if}
                <div class="clearfix"></div>
            </div>
        </div>
    </section>

    <footer id="footer" class="footer weberse-footer">
        <div class="weberse-footer-accent"></div>
        <div class="container weberse-footer-container">
            <ul class="list-inline mb-7 text-center float-lg-right">
                {include file="$template/includes/social-accounts.tpl"}

                {if $languagechangeenabled && count($locales) > 1 || $currencies}
                    <li class="list-inline-item">
                        <button type="button" class="btn" data-toggle="modal" data-target="#modalChooseLanguage">
                            <div class="d-inline-block align-middle">
                                <div class="iti-flag {if $activeLocale.countryCode === '001'}us{else}{$activeLocale.countryCode|lower}{/if}"></div>
                            </div>
                            {$activeLocale.localisedName}
                            /
                            {$activeCurrency.prefix}
                            {$activeCurrency.code}
                        </button>
                    </li>
                {/if}
            </ul>

            <ul class="nav justify-content-center justify-content-lg-start mb-7">
                <li class="nav-item">
                    <a class="nav-link" href="{$WEB_ROOT}/contact.php">
                        {lang key='contactus'}
                    </a>
                </li>
                {if $acceptTOS}
                    <li class="nav-item">
                        <a class="nav-link" href="{$tosURL}" target="_blank">{lang key='ordertos'}</a>
                    </li>
                {/if}
            </ul>

            <p class="copyright mb-0">
                {lang key="copyrightFooterNotice" year=$date_year company=$companyname}
            </p>
        </div>
    </footer>

    {* Weberse lead intake modal (posts to main site CRM) *}
    <div class="modal fade weberse-lead-modal" id="weberseLeadModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Start Your Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{lang key='close'}">
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
                <img src="{$WEB_ROOT}/assets/img/overlay-spinner.svg" alt="">
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
                        <span class="sr-only">{lang key='close'}</span>
                    </button>
                </div>
                <div class="modal-body">
                    {lang key='loading'}
                </div>
                <div class="modal-footer">
                    <div class="float-left loader">
                        <i class="fas fa-circle-notch fa-spin"></i>
                        {lang key='loading'}
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {lang key='close'}
                    </button>
                    <button type="button" class="btn btn-primary modal-submit">
                        {lang key='submit'}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form method="get" action="{$currentpagelinkback}">
        <div class="modal modal-localisation" id="modalChooseLanguage" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        {if $languagechangeenabled && count($locales) > 1}
                            <h5 class="h5 pt-5 pb-3">{lang key='chooselanguage'}</h5>
                            <div class="row item-selector">
                                <input type="hidden" name="language" data-current="{$language}" value="{$language}" />
                                {foreach $locales as $locale}
                                    <div class="col-4">
                                        <a href="#" class="item{if $language == $locale.language} active{/if}" data-value="{$locale.language}">
                                            {$locale.localisedName}
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                        {/if}
                        {if !$loggedin && $currencies}
                            <p class="h5 pt-5 pb-3">{lang key='choosecurrency'}</p>
                            <div class="row item-selector">
                                <input type="hidden" name="currency" data-current="{$activeCurrency.id}" value="">
                                {foreach $currencies as $selectCurrency}
                                    <div class="col-4">
                                        <a href="#" class="item{if $activeCurrency.id == $selectCurrency.id} active{/if}" data-value="{$selectCurrency.id}">
                                            {$selectCurrency.prefix} {$selectCurrency.code}
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                        {/if}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">{lang key='apply'}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {if !$loggedin && $adminLoggedIn}
        <a href="{$WEB_ROOT}/logout.php?returntoadmin=1" class="btn btn-return-to-admin" data-toggle="tooltip" data-placement="bottom" title="{if $adminMasqueradingAsClient}{lang key='adminmasqueradingasclient'} {lang key='logoutandreturntoadminarea'}{else}{lang key='adminloggedin'} {lang key='returntoadminarea'}{/if}">
            <i class="fas fa-redo-alt"></i>
            <span class="d-none d-md-inline-block">{lang key="admin.returnToAdmin"}</span>
        </a>
    {/if}

    {include file="$template/includes/generate-password.tpl"}

    {$footeroutput}

    <script>
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
    </script>

</body>
</html>

