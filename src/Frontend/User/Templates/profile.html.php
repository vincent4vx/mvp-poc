<?php
/**
 * @var \Quatrevieux\Mvp\Backend\User\Profile\ProfileResponse $this
 */
?>

<h1>Profile</h1>

<table>
    <tr>
        <th>Name</th>
        <td><?= $this->name->html() ?></td>
    </tr>
    <tr>
        <th>Pseudo</th>
        <td><?= $this->pseudo->html() ?></td>
    </tr>
</table>
