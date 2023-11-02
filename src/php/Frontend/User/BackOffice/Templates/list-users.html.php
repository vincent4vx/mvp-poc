<?php

/**
 * @var \Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersResponse $this
 * @var \Quatrevieux\Mvp\Frontend\User\BackOffice\ListUsersRenderer $renderer
 */

use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete\DeleteUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;

?>

<h1>Users list</h1>

<form
    action="<?= $renderer->url(ListUsersRequest::class) ?>"
    method="get"
    id="list-users-form"
    data-autosearch-source="<?= $renderer->url(ListUsersRequest::ajax()) ?>"
    data-autosearch-target="#users-list tbody"
>
    <input type="text" name="search" placeholder="Search..." value="<?= htmlentities($this->request->search) ?>" />
    <div class="dropdown" tabindex="1">
        <span class="legend icon-options"></span>

        <div class="dropdown-content">
            <fieldset>
                <legend>Search on</legend>
                <ul>
                    <li>
                        <label>
                            <input type="checkbox" name="fields[]" value="username" <?php if (in_array('username', $this->request->fields)) echo 'checked'; ?> />
                            Username
                        </label>
                    </li>
                    <li>
                    <label>
                        <input type="checkbox" name="fields[]" value="pseudo" <?php if (in_array('pseudo', $this->request->fields)) echo 'checked'; ?> />
                        Pseudo
                    </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" name="fields[]" value="id" <?php if (in_array('id', $this->request->fields)) echo 'checked'; ?> />
                            Id
                        </label>
                    </li>
                </ul>
            </fieldset>
        </div>
    </div>
    <button type="submit"><span class="icon-search"></span></button>
</form>

<table id="users-list">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Pseudo</th>
            <th>Roles</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="users-list-results">
        <?php require __DIR__ . '/list-users-results.html.php' ?>
    </tbody>
</table>

<div id="users-list-pagination">
    <?= $renderer->pagination($this) ?>
</div>
