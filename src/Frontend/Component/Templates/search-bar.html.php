<?php

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchRequest;

/**
 * @var \Quatrevieux\Mvp\Core\View\Renderer $renderer
 */
?>

<form action="<?= $renderer->url(new SearchRequest()); ?>" method="get">
    <input type="text" name="query" placeholder="Search..." value="" autocomplete="off" />
    <button type="submit">🔍</button>

    <div class="autocomplete-results" data-autocomplete-src="<?= $renderer->url(SearchRequest::autocomplete()); ?>"></div>
</form>
