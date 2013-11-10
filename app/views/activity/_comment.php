<?php if($activity->canEdit): ?>
    <span class="options">
        <?= TbHtml::link(TbHtml::icon('pencil'), '#', array(
            'title' => 'Update', 
            'class' => 'update',
            'rel' => 'tooltip'
        )); ?>
        <?= TbHtml::link(TbHtml::icon('trash'), array('/activity/delete', 'id'=>$activity->activityId), array(
            'title' => 'Delete', 
            'class' => 'delete',
            'rel' => 'tooltip',
        )); ?>
    </span>
<?php endif; ?>

User <strong><?= $activity->user->username; ?></strong> wrote a new comment on issue
<?= TbHtml::link("#{$activity->issueId}: {$activity->issue->title}", array('/issue/view', 'id' => $activity->issueId)); ?>:

<?php if($activity->canEdit) {
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type' => TbHtml::FORM_LAYOUT_VERTICAL,
        'action' => array('/activity/update', 'id'=>$activity->activityId),
        'htmlOptions' => array('class' => 'comment-update'),
    ));
    echo $form->textArea($activity, 'activityData', array('id' => null)); 
} ?>

<blockquote><?= $activity->activityData; ?></blockquote>

<?php if($activity->canEdit): ?>
    <div class="edit-actions">
        <?= TbHtml::submitButton('Save', array('color'=>'primary', 'size'=>'mini')); ?>
        <?= TbHtml::button('Cancel', array('size'=>'mini', 'class'=>'cancel')); ?>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>
