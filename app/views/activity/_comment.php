<?php if ($user->userId === Yii::app()->user->id): ?>
    <span class="options">
        <?= TbHtml::link(TbHtml::icon('pencil'), '#', array('title' => 'Update', 'rel' => 'tooltip')); ?>
        <?= TbHtml::link(TbHtml::icon('trash'), '#', array('title' => 'Delete', 'rel' => 'tooltip')); ?>
    </span>
<?php endif; ?>
User <strong><?= $user->username; ?></strong> wrote a new comment on issue
<?= TbHtml::link("#{$issue->issueId}: {$issue->title}", array('/issue/view', 'id' => $issue->issueId)); ?>:
<blockquote><?= $activity->activityData; ?></blockquote>
