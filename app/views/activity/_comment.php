<?php if ($user->userId === Yii::app()->user->id): ?>
    <span class="options">
        <?= TbHtml::link(TbHtml::icon('pencil'), '#'); ?>
        <?= TbHtml::link(TbHtml::icon('trash'), '#'); ?>
    </span>
<?php endif; ?>
User <strong><?= $user->username; ?></strong> wrote a new comment on issue
<?= TbHtml::link("#{$issue->issueId}: {$issue->title}", array('/issue/view', 'id' => $issue->issueId)); ?>:
<blockquote><?= $activity->activityData; ?></blockquote>
