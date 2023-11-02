<?php
/**
 * @var \Quatrevieux\Mvp\Frontend\Component\MenuBar $this
 * @var \Quatrevieux\Mvp\Frontend\ApplicationRenderer $renderer
 */

use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Backend\Chat\Show\ShowChatRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Profile\ProfileRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormRequest;

?>

<nav>
    <ul>
        <?php if (!$this->user): ?>
            <li><a href="<?= $renderer->url(new AuthenticationFormRequest()) ?>">Login</a></li>
            <li><a href="<?= $renderer->url(new RegistrationFormRequest()) ?>">Register</a></li>
        <?php else: ?>
            <li><a href="<?= $renderer->url(new ShowChatRequest()) ?>">Chat</a></li>
            <li><a href="<?= $renderer->url(new ProfileRequest()) ?>"><?= $this->user->pseudo->html() ?></a></li>
            <?php if ($renderer->hasAccess(new HomeRequest())): ?>
                <li><a href="<?= $renderer->url(new HomeRequest()) ?>" class="no-pjax">BackOffice</a></li>
            <?php endif; ?>
            <li><a href="<?= $renderer->url(new LogoutRequest()) ?>">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
