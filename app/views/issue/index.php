<?php

use wiro\modules\users\models\User;
/* @var $this CategoryController */
/* @var $model Category */
$this->breadcrumbs = array('Issues');
?>

<fieldset>
    <legend>Issues</legend>
    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'id' => 'issue-tabs',
        'type' => 'tabs',
        'tabs' => array(
            array(
                'label' => 'Issues',
                'active' => true,
                'items' => array(
                    array('label' => 'All', 'url' => array('index'), 'active'=>true),
                    array('label' => 'Opened', 'url' => array('index', 'Issue[status]' => Issue::STATUS_OPENED)),
                    array('label' => 'Created by me', 'url' => array('index', 'Issue[authorId]' => Yii::app()->user->id)),
                    array('label' => 'Assigned to me', 'url' => array('index', 'Issue[assignedTo]' => Yii::app()->user->id)),
                    array('label' => 'Opened, assigned to me', 'url' => array('index', 'Issue[assignedTo]' => Yii::app()->user->id, 'Issue[status]' => Issue::STATUS_OPENED)),
                ),
            ),
            array(
                'label' => 'Features',
                'items' => array(
                    array('label' => 'All', 'url' => array('index', 'Issue[type]' => Issue::TYPE_FEATURE)),
                    array('label' => 'Opened', 'url' => array('index', 'Issue[type]' => Issue::TYPE_FEATURE, 'Issue[status]' => Issue::STATUS_OPENED)),
                    array('label' => 'Created by me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_FEATURE, 'Issue[authorId]' => Yii::app()->user->id)),
                    array('label' => 'Assigned to me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_FEATURE, 'Issue[assignedTo]' => Yii::app()->user->id)),
                    array('label' => 'Opened, assigned to me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_FEATURE, 'Issue[assignedTo]' => Yii::app()->user->id, 'Issue[status]' => Issue::STATUS_OPENED)),
                ),
            ),
            array(
                'label' => 'Bugs',
                'items' => array(
                    array('label' => 'All', 'url' => array('index', 'Issue[type]' => Issue::TYPE_BUG)),
                    array('label' => 'Opened', 'url' => array('index', 'Issue[type]' => Issue::TYPE_BUG, 'Issue[status]' => Issue::STATUS_OPENED)),
                    array('label' => 'Created by me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_BUG, 'Issue[authorId]' => Yii::app()->user->id)),
                    array('label' => 'Assigned to me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_BUG, 'Issue[assignedTo]' => Yii::app()->user->id)),
                    array('label' => 'Opened, assigned to me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_BUG, 'Issue[assignedTo]' => Yii::app()->user->id, 'Issue[status]' => Issue::STATUS_OPENED)),
                ),
            ),
            array(
                'label' => 'Enhancements',
                'items' => array(
                    array('label' => 'All', 'url' => array('index', 'Issue[type]' => Issue::TYPE_ENHANCEMENT)),
                    array('label' => 'Opened', 'url' => array('index', 'Issue[type]' => Issue::TYPE_ENHANCEMENT, 'Issue[status]' => Issue::STATUS_OPENED)),
                    array('label' => 'Created by me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_ENHANCEMENT, 'Issue[authorId]' => Yii::app()->user->id)),
                    array('label' => 'Assigned to me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_ENHANCEMENT, 'Issue[assignedTo]' => Yii::app()->user->id)),
                    array('label' => 'Opened, assigned to me', 'url' => array('index', 'Issue[type]' => Issue::TYPE_ENHANCEMENT, 'Issue[assignedTo]' => Yii::app()->user->id, 'Issue[status]' => Issue::STATUS_OPENED)),
                ),
            ),
        ),
    )); ?>
    
    <p>
        <?= TbHtml::linkButton('Create issue', array('url' => array('create'), 'color' => TbHtml::BUTTON_COLOR_PRIMARY, 'icon' => 'icon-plus icon-white')); ?>
    </p>
    
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'issue-grid',
        'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_CONDENSED),
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => "<div class=\"pull-right\">{summary}</div>{items}\n{pager}",
        'columns' => array(
            array(
                'name' => 'issueId',
                'headerHtmlOptions' => array('width'=>50),
            ),
            'title',
            array(
                'name' => 'type',
                'filter' => $model->typeList,
                'value' => '$data->typeLabel',
                'type' => 'raw',
            ),
            array(
                'name' => 'authorId',
                'filter' => User::model()->listModels('username'),
                'value' => '$data->author->username',
            ),
            array(
                'name' => 'categoryId',
                'filter' => Category::model()->listModels('categoryName'),
                'value' => '$data->category->categoryName',
            ),
            array(
                'name' => 'assignedTo',
                'filter' => User::model()->listModels('username'),
                'value' => '$data->assignee ? $data->assignee->username : null',
            ),
            array(
                'name' => 'status',
                'filter' => $model->statusList,
                'value' => '$data->statusLabel',
                'type' => 'raw',
            ),
            array(
                'name' => 'priority',
                'filter' => $model->priorityList,
                'value' => '$data->priorityLabel',
                'type' => 'raw',
            ),
            array(
                'name' => 'dateCreated',
                'filter' => false,
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{view} {update} {delete}',
            ),
        ),
    ));
    ?>
</fieldset>

<script type="text/javascript">
$('#issue-tabs ul.dropdown-menu a').on('click', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $('#issue-grid').yiiGridView('update', { url: url });
    $('#issue-tabs li').removeClass('active');
    $(this).parentsUntil('#issue-tabs', 'li').addClass('active');
});  
</script>
