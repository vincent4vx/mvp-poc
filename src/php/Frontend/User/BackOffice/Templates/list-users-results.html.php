<?php

/**
 * @var \Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersResponse $this
 * @var \Quatrevieux\Mvp\Core\View\Renderer $renderer
 */

use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete\DeleteUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;

?>

<?php foreach ($this->users as $user): ?>
    <tr>
        <td><?= $user->id->value() ?></td>
        <td><?= $user->username->html() ?></td>
        <td><?= $user->pseudo->html() ?></td>
        <td>
            <?= $renderer->button('Edit')->target(new EditUserRequest($user->id->value)) ?>
            <?= $renderer->button('Delete')->post(new DeleteUserRequest($user->id->value))->class('btn-link') ?>
        </td>
    </tr>
<?php endforeach; ?>
