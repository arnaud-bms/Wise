<?php /* Smarty version Smarty-3.1-DEV, created on 2012-12-16 22:33:47
         compiled from "/data/Projects/www/Telelab/app/Example/tpl/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:44566008850ce38b67bca04-87680398%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53b512c56d0c5758344cc86a2fce8eac47fb0d38' => 
    array (
      0 => '/data/Projects/www/Telelab/app/Example/tpl/main.tpl',
      1 => 1355693625,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '44566008850ce38b67bca04-87680398',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_50ce38b67fd3d1_38288088',
  'variables' => 
  array (
    'meta' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50ce38b67fd3d1_38288088')) {function content_50ce38b67fd3d1_38288088($_smarty_tpl) {?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_smarty_tpl->tpl_vars['meta']->value['title'];?>
 - Telelab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="http://code.jquery.com/jquery-latest.js"></script>

    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/css/example.css" rel="stylesheet">

    <link rel="shortcut icon" href="/img/favicon.ico" />
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">

    <div id="fb-root"></div>
    <?php echo $_smarty_tpl->getSubTemplate ("nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


    <div class="container">
        <div class="row">
            <div class="span12">
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['page']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            </div>
        </div>
     </div>
    <?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


    <script src="http://platform.twitter.com/widgets.js"></script>
    <script src="/js/bootstrap.js"></script>
  </body>
</html>
<?php }} ?>