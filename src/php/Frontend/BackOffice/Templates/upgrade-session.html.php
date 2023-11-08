<?php

/**
 * @var Quatrevieux\Mvp\Frontend\BackOffice\UpgradeSessionRenderer $renderer
 * @var \Quatrevieux\Mvp\Backend\BackOffice\Security\UpgradeSessionResponse $this
 */

use Quatrevieux\Mvp\Backend\BackOffice\Security\UpgradeSessionRequest;

?>

<div id="upgrade-session">
    <h1>Admin Access</h1>

    <?php if ($this->error): ?>
        <p class="error"><?= $this->error ?></p>
    <?php endif; ?>

    <form action="<?= htmlentities($renderer->url(new UpgradeSessionRequest())) ?>" method="post" id="upgrade-session-form">
        <input type="hidden" name="target" value="<?= htmlentities($this->target) ?>" />
        <!--<input type="text" name="username" placeholder="Username" />-->
        <div class="signed-as">Signed as <span class="username"><?= $this->user->username->html() ?></span></div>
        <input type="password" name="password" placeholder="Password" />
        <input type="submit" value="Access" />
    </form>
</div>
