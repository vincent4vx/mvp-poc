<?php
/**
 * @var Quatrevieux\Mvp\App\User\Profile\ProfileResponse $this
 */
?>

<h1>Profile</h1>

<table>
    <tr>
        <th>Name</th>
        <td><?= htmlentities($this->name) ?></td>
    </tr>
    <tr>
        <th>Pseudo</th>
        <td><?= htmlentities($this->pseudo) ?></td>
    </tr>
</table>
