<?php /* Smarty version Smarty-3.1-DEV, created on 2012-12-16 22:18:27
         compiled from "/data/Projects/www/Telelab/app/Example/tpl/nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:135214103150ce3924c36c94-73916713%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e37d823b56cfd6ed7ffabc565ad15e16b3d2e077' => 
    array (
      0 => '/data/Projects/www/Telelab/app/Example/tpl/nav.tpl',
      1 => 1355692676,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135214103150ce3924c36c94-73916713',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_50ce3924c4fcb8_79282553',
  'variables' => 
  array (
    'nav' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50ce3924c4fcb8_79282553')) {function content_50ce3924c4fcb8_79282553($_smarty_tpl) {?><div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="<?php if ($_smarty_tpl->tpl_vars['nav']->value['active']=="home"){?>active<?php }?>">
                        <a href="/">Telelab</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div><?php }} ?>