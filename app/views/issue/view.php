<?php
/* @var $this IssueController */
/* @var $model Issue */
$this->breadcrumbs=array(
    'Issues'=>array('index'),
    "#{$model->issueId}: {$model->title}",
);
?>

<fieldset id="issue-view">
    <legend>
        Issue #<i><?= $model->issueId; ?>: <?= $model->title; ?></i>
        <?php 
            if(!$model->isBeingWatched)
                echo TbHtml::linkButton('Watch', array(
                    'url' => array('watch', 'id'=>$model->issueId, 'watch'=>1),
                    'class' => 'pull-right', 
                    'color' => 'primary', 
                    'icon' => 'eye-open'));
            else
                echo TbHtml::linkButton('Unwatch', array(
                    'url' => array('watch', 'id'=>$model->issueId, 'watch'=>0),
                    'class' => 'pull-right', 
                    'color' => 'danger', 
                    'icon' => 'eye-close',
                ));
        ?>
    </legend>
    
    <p>
    <?= TbHtml::buttonDropdown(
        $model->statusName, 
        array_map(function($status) use ($model) {
            return array(
                'label' => $model->getStatusName($status),
                'url' => array('status', 'id' => $model->issueId, 'status' => $status),
            );
        }, array_keys($model->statusList)),
        array('icon' => 'flag')); ?>
        
    <?php if($model->canEdit): 
        echo TbHtml::buttonGroup(array(
            array('label' => 'Update', 'url' => array('update', 'id'=>$model->issueId), 'icon' => 'pencil'),
            array('label' => 'Delete', 'confirm' => 'Are you sure you want to delete this issue?', 'submit' => array('delete', 'id'=>$model->issueId), 'color' => TbHtml::BUTTON_COLOR_DANGER, 'icon' => 'trash'),
        ));
        endif; 
    ?>
        
    &nbsp;

    <?= TbHtml::linkButton('Issue list', array('url' => array('index'), 'icon' => 'tasks')); ?>
    </p>
    
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
        'id' => 'issue-details',
	'attributes'=>array(
		'issueId',
		'author.username:text:Author',
		'category.categoryName:text:Category',
		'typeLabel:html:Type',
		'title',
		array(
                    'name' => 'description',
                    'type' => 'html',
                    'cssClass' => 'description',
                ),
		'assignee.username:text:Assigned to',
		'statusLabel:html:Status',
                'priorityLabel:html:Priority',
		'dateCreated',
		'dateModified',
	),
    )); ?>
    
    
    <?php 
    $activity = new Activity('search');
    $activity->issueId = $model->issueId;
    $this->renderPartial('/activity/index', array(
        'model' => $activity,
    )); ?>
</fieldset>


