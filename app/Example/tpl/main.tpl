<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>{$meta.title|htmlspecialchars} - EDF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{$meta.description|htmlspecialchars}">
    <meta name="author" content="gdievart">

    <script src="http://code.jquery.com/jquery-latest.js"></script>

    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/css/example.css" rel="stylesheet">

    <link rel="shortcut icon" href="/img/favicon.ico" />
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">

    <div id="fb-root"></div>
    {include file="nav.tpl"}
    {include file="header.tpl"}

    <div class="container">
        <div class="row">
            <div class="span3 bs-docs-sidebar">
                {include file="column_right.tpl"}
            </div>
            <div class="span9">
                {include file="{$page}"}
            </div>
        </div>
     </div>
    {include file="footer.tpl"}

    <script src="http://platform.twitter.com/widgets.js"></script>
    <script src="/js/bootstrap.js"></script>
  </body>
</html>
