<?php /* Smarty version Smarty-3.1-DEV, created on 2012-12-01 21:51:30
         compiled from "/opt/hosting/Telelab/app/Example/tpl/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:96231223350ba67ebd47bb8-27159978%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7885da3dfad7783b0a090129bf00455f97e92889' => 
    array (
      0 => '/opt/hosting/Telelab/app/Example/tpl/main.tpl',
      1 => 1354395089,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96231223350ba67ebd47bb8-27159978',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_50ba67ebd772b0_71170209',
  'variables' => 
  array (
    'page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50ba67ebd772b0_71170209')) {function content_50ba67ebd772b0_71170209($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Telelab framework</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <?php echo $_smarty_tpl->getSubTemplate ("main/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['page']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate ("main/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html><?php }} ?>