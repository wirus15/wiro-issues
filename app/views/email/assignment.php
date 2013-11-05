<?php $this->emailSubject = 'User '.$user.' assigned you to an issue'; ?>

<p>User <strong><?= $user; ?></strong> assigned you to the issue 
    <strong>#<?= $issue->issueId; ?>: <?= $issue->title; ?></strong></p>

<p>
    Use this link to view the details:<br/>
    <?= CHtml::link($link, $link); ?>
</p>
