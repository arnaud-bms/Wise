<h1>Main template</h1>

{$page}

{foreach from=$rows item=row}
    {$row.name}
{/foreach}