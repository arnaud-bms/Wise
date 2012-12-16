<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>{$meta.title} - Telelab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            <div class="span12">
                {include file="{$page}"}
            </div>
        </div>
     </div>
    {include file="footer.tpl"}

    <script src="http://platform.twitter.com/widgets.js"></script>
    <script src="/js/bootstrap.js"></script>
  </body>
</html>
