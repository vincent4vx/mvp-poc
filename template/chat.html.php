<?php

use Quatrevieux\Mvp\App\Chat\Event\SubscribeEventRequest;
use Quatrevieux\Mvp\App\Chat\Send\SendMessageRequest;
use Quatrevieux\Mvp\App\Chat\Show\ShowChatRequest;

/**
 * @var \Quatrevieux\Mvp\App\Chat\Show\ShowChatResponse $this
 * @var \Quatrevieux\Mvp\Core\Renderer $renderer
 * @var \Quatrevieux\Mvp\App\CustomViewContext $context
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
            <div class="message <?= $message->user?->id == $this->user?->id ? 'from-me' : 'from-other' ?>">
                <span class="author"><?= htmlentities($message->user?->pseudo ?? 'Deleted') ?></span>
                <span class="date"><?= $message->createdAt->format('d/m/Y H:i:s') ?></span>
                <span class="content"><?= htmlentities($message->message) ?></span>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="input">
        <form action="<?= $renderer->url(new SendMessageRequest()) ?>" method="post">
            <input type="text" name="message" placeholder="Message" />
            <input type="submit" value="Envoyer" />
        </form>
    </section>
</div>
<?php else: ?>
    <?php foreach($this->messages as $message): ?>
        <div class="message <?= $message->user?->id == $this->user?->id ? 'from-me' : 'from-other' ?>">
            <span class="author"><?= htmlentities($message->user?->pseudo ?? 'Deleted') ?></span>
            <span class="date"><?= $message->createdAt->format('d/m/Y H:i:s') ?></span>
            <span class="content"><?= htmlentities($message->message) ?></span>
        </div>
    <?php endforeach; ?>
<?php endif ?>
