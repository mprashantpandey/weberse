<?php
/* Smarty version 4.5.3, created on 2026-03-17 16:26:05
  from '/Users/prashant/Desktop/Weberse/billing/templates/orderforms/weberse_cart/includes/stepper.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.3',
  'unifunc' => 'content_69b9809d18d368_37346339',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bb318485b07be087d1ff48f644128ece7ccd0bf9' => 
    array (
      0 => '/Users/prashant/Desktop/Weberse/billing/templates/orderforms/weberse_cart/includes/stepper.tpl',
      1 => 1773763313,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69b9809d18d368_37346339 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('_step', (($tmp = $_smarty_tpl->tpl_vars['step']->value ?? null)===null||$tmp==='' ? 'products' ?? null : $tmp));?>

<div class="weberse-stepper" aria-label="Checkout progress">
    <div class="weberse-step <?php if ($_smarty_tpl->tpl_vars['_step']->value == 'products') {?>is-active<?php } elseif (in_array($_smarty_tpl->tpl_vars['_step']->value,array('configure','review','checkout','complete'))) {?>is-done<?php }?>">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Choose</div>
            <div class="weberse-step-sub">Plan</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step <?php if ($_smarty_tpl->tpl_vars['_step']->value == 'configure') {?>is-active<?php } elseif (in_array($_smarty_tpl->tpl_vars['_step']->value,array('review','checkout','complete'))) {?>is-done<?php }?>">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Configure</div>
            <div class="weberse-step-sub">Options</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step <?php if ($_smarty_tpl->tpl_vars['_step']->value == 'review') {?>is-active<?php } elseif (in_array($_smarty_tpl->tpl_vars['_step']->value,array('checkout','complete'))) {?>is-done<?php }?>">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Review</div>
            <div class="weberse-step-sub">Cart</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step <?php if ($_smarty_tpl->tpl_vars['_step']->value == 'checkout') {?>is-active<?php } elseif (in_array($_smarty_tpl->tpl_vars['_step']->value,array('complete'))) {?>is-done<?php }?>">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Checkout</div>
            <div class="weberse-step-sub">Details</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step <?php if ($_smarty_tpl->tpl_vars['_step']->value == 'complete') {?>is-active<?php }?>">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Done</div>
            <div class="weberse-step-sub">Finish</div>
        </div>
    </div>
</div>

<?php }
}
