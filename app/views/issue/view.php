<?php
/* @var $this IssueController */
/* @var $model Issue */
$this->breadcrumbs=array(
    'Issues'=>array('index'),
    "#{$model->issueId}: {$model->title}",
);
?>

<fieldset id="issue-view">
    <legend>Issue #<i><?= $model->issueId; ?>: <?= $model->title; ?></i></legend>
    <p>
    <?= TbHtml::buttonGroup(array(
	array('label' => 'Update', 'url' => array('update', 'id'=>$model->issueId), 'icon' => 'pencil'),
        array('label' => $model->statusName, 'url' => '#', 'icon' => 'flag', 'items' => array(
            array('label' => 'New', 'url' => array('status','id'=>$model->issueId,'status'=>Issue::STATUS_NEW)),
            array('label' => 'Confirmed', 'url' => array('status','id'=>$model->issueId,'status'=>Issue::STATUS_CONFIRMED)),
            array('label' => 'Opened', 'url' => array('status','id'=>$model->issueId,'status'=>Issue::STATUS_OPENED)),
            array('label' => 'Halted', 'url' => array('status','id'=>$model->issueId,'status'=>Issue::STATUS_HALTED)),
            array('label' => 'Resolved', 'url' => array('status','id'=>$model->issueId,'status'=>Issue::STATUS_RESOLVED)),
            array('label' => 'Resolved & Confirmed', 'url' => array('status','id'=>$model->issueId,'status'=>Issue::STATUS_RESOLVED_CONFIRMED)),
            array('label' => 'Rejected', 'url' => array('status','id'=>$model->issueId,'status'=>Issue::STATUS_REJECTED)),
        )),
        array('label' => 'Delete', 'confirm' => 'Are you sure you want to delete this issue?', 'submit' => array('delete', 'id'=>$model->issueId), 'color' => TbHtml::BUTTON_COLOR_DANGER, 'icon' => 'trash'),
    )); ?>
        &nbsp;&nbsp;
    <?= TbHtml::linkButton('Issue list', array('url' => array('index'), 'icon' => 'tasks')); ?>
    </p>
    
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'issueId',
		'author.username:text:Author',
		'category.categoryName:text:Category',
		'typeLabel:html:Type',
		'title',
		'description:html',
		'assignee.username:text:Assigned to',
		'statusLabel:html:Status',
                'priorityLabel:html:Priority',
		'dateCreated',
		'dateModified',
	),
    )); ?>
    
    <div class="activity-list">
    <?php $this->renderPartial('/activity/list', array(
        'activities' => $model->activities,
    )); ?>
        <div class="well well-small">
            <p><?php $this->widget('bootstrap.widgets.TbRedactorJs', array(
                'name' => 'lol',
                )); ?></p>
            <?= TbHtml::button('Comment', array('color'=>'primary')); ?>
        </div>
    </div>
</fieldset>


