<?php $this->emailSubject = 'User '.$user.' created new issue'; ?>

<p>User <strong><?= $user; ?></strong> created issue
    <strong>#<?= $issue->issueId; ?>: <?= $issue->title; ?></strong></p>

<p>
    Use this link to view the details:<br/>
    <?= CHtml::link($link, $link); ?>
</p>
