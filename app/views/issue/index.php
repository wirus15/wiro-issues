<?php
/* @var $this IssueController */
/* @var $model Issue */

use wiro\modules\users\models\User;
$this->breadcrumbs = array('Issues');
?>

<fieldset>
    <legend>Issues</legend>
    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'id' => 'issue-tabs',
        'type' => 'tabs',
        'htmlOptions' => array(
            'data-filter' => CHtml::activeId($model, 'type'),
        ),
        'tabs' => array(
            array(
                'label' => 'Issues',
                'active' => true,
            ),
            array(
                'label' => 'Features',
                'linkOptions' => array('data-value' => Issue::TYPE_FEATURE),
            ),
            array(
                'label' => 'Bugs',
                'linkOptions' => array('data-value' => Issue::TYPE_BUG),
            ),
            array(
                'label' => 'Enhancements',
                'linkOptions' => array('data-value' => Issue::TYPE_ENHANCEMENT),
            ),
        ),
    )); ?>
    
    <div style="overflow: auto">
        <div class="pull-left">
            <?= TbHtml::linkButton('Create new issue', array(
                'url' => array('create'), 
                'color'=>'primary', 
                'icon'=>'plus',
            )); ?>
        </div>
        
        <?php $this->renderPartial('_filters', array('model' => $model)); ?>
    </div>
   
    <?= CHtml::activeHiddenField($model, 'statusScope'); ?>
    
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'issue-grid',
        'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_CONDENSED),
        'dataProvider' => $model->search(),
        'filter' => $model,
        'filterSelector' => '{filter},#Issue_statusScope',
        'template' => "<div class=\"pull-right\">{summary}</div>{items}\n{pager}",
        'columns' => array(
            array(
                'name' => 'issueId',
                'headerHtmlOptions' => array('width'=>40),
                'type' => 'html',
                'value' => 'CHtml::link("#{$data->issueId}", array("view", "id"=>$data->issueId))',
            ),
            'title',
            array(
                'name' => 'type',
                'filter' => $model->typeList,
                'value' => '$data->typeLabel',
                'type' => 'html',
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
                'filter' => CMap::mergeArray(
                        array('unassigned' => 'Unassigned'), 
                        User::model()->listModels('username')
                ),
                'value' => '$data->assignee ? $data->assignee->username : null',
            ),
            array(
                'name' => 'status',
                'filter' => $model->statusList,
                'value' => '$data->statusLabel',
                'type' => 'html',
            ),
            array(
                'name' => 'priority',
                'filter' => $model->priorityList,
                'value' => '$data->priorityLabel',
                'type' => 'html',
            ),
            'dateCreated',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{view} {update} {delete}',
            ),
        ),
    ));
    ?>
</fieldset>
