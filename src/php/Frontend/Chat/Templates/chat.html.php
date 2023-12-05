<?php

use Quatrevieux\Mvp\Backend\Chat\Application\Event\SubscribeEventRequest;
use Quatrevieux\Mvp\Backend\Chat\Application\Send\SendMessageRequest;
use Quatrevieux\Mvp\Backend\Chat\Application\Show\ShowChatRequest;

/**
 * @var \Quatrevieux\Mvp\Backend\Chat\Application\Show\ShowChatResponse $this
 * @var \Quatrevieux\Mvp\Frontend\ApplicationRenderer $renderer
 * @var \Quatrevieux\Mvp\Frontend\ApplicationViewContext $context
 */

$context->title = 'My Blog - Chat';

// @todo prefer custom renderer or response object
if ($this->ajax) {
    $context->ajax = true;
}

?>

<?php if (!$this->ajax): ?>
<div id="chat">
    <h1>Chat</h1>

    <section
        class="messages"
        data-source="<?= $renderer->url(ShowChatRequest::ajax()) ?>"
        data-events="<?= $renderer->url(new SubscribeEventRequest()) ?>"
        data-pulling-delay="60000"
    >
        <?php foreach($this->messages as $message): ?>
            <div class="message <?= $message->isMine ? 'from-me' : 'from-other' ?>">
                <span class="author"><?= $message->pseudo?->html() ?? 'Deleted' ?></span>
                <span class="date"><?= $message->createdAt->format('d/m/Y H:i:s') ?></span>
                <span class="content"><?= $message->message->html() ?></span>
            </div>
        <?php endforeach; ?>
    </section>

    <?php if ($renderer->hasAccess($sendMessage = new SendMessageRequest())): ?>
        <section class="input">
            <form action="<?= $renderer->url($sendMessage) ?>" method="post">
                <input type="text" name="message" placeholder="Message" />
                <input type="submit" value="Envoyer" />
            </form>
        </section>
    <?php endif ?>
</div>
<?php else: ?>
    <?php foreach($this->messages as $message): ?>
        <div class="message <?= $message->isMine ? 'from-me' : 'from-other' ?>">
            <span class="author"><?= $message->pseudo?->html() ?? 'Deleted' ?></span>
            <span class="date"><?= $message->createdAt->format('d/m/Y H:i:s') ?></span>
            <span class="content"><?= $message->message->html() ?></span>
        </div>
    <?php endforeach; ?>
<?php endif ?>
