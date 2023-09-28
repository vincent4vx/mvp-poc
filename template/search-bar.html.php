<?php
use Quatrevieux\Mvp\App\Search\SearchRequest;

/**
 * @var \Quatrevieux\Mvp\App\SearchBarRenderer $renderer
 */
?>

<form action="<?= $renderer->url(new SearchRequest()); ?>" method="get">
    <input type="text" name="query" placeholder="Search..." value="" />
    <button type="submit">🔍</button>
</form>
