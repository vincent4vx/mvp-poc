<?php
/**
 * @var Quatrevieux\Mvp\App\MenuBar $this
 * @var \Quatrevieux\Mvp\App\MenuBarRenderer $renderer
 */

use Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest;

?>

<nav>
    <ul>
        <?php if (!$this->user): ?>
            <li><a href="<?= $renderer->url(new AuthenticationFormRequest()) ?>">Login</a></li>
        <?php else: ?>
            <li><?= htmlentities($this->user->pseudo) ?></li>
        <?php endif; ?>
    </ul>
</nav>
