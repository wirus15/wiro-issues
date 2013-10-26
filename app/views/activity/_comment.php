<?php if ($activity->userId === Yii::app()->user->id): ?>
    <span class="options">
        <?= TbHtml::link(TbHtml::icon('pencil'), '#', array('title' => 'Update', 'rel' => 'tooltip')); ?>
        <?= TbHtml::link(TbHtml::icon('trash'), array('/activity/delete', 'id'=>$activity->activityId),
                array(
                    'title' => 'Delete', 
                    'class' => 'delete',
                    'rel' => 'tooltip',
                )); ?>
    </span>
<?php endif; ?>

User <strong><?= $activity->user->username; ?></strong> wrote a new comment on issue
<?= TbHtml::link("#{$activity->issueId}: {$activity->issue->title}", array('/issue/view', 'id' => $activity->issueId)); ?>:
<blockquote><?= $activity->activityData; ?></blockquote>
