<?php
/* @var $this CategoryController */
/* @var $model Category */

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
        
        <div id="filters" class="pull-right">
            <?= TbHtml::buttonGroup(array(
                array('label' => 'All', 'class'=>'active', 'htmlOptions' => array(
                    'data-filter' => 'Issue_assignedTo',
                )),
                array('label' => 'Assigned to me', 'htmlOptions' => array(
                    'data-filter' => 'Issue_assignedTo',
                    'data-value' => Yii::app()->user->id,
                )),
                array('label' => 'Created by me', 'htmlOptions' => array(
                    'data-filter' => 'Issue_authorId',
                    'data-value' => Yii::app()->user->id,
                )),
                array('label' => 'Unassigned', 'htmlOptions' => array(
                    'data-filter' => 'Issue_assignedTo',
                    'data-value' => 'unassigned',
                )),
            ), array(
                'toggle' => 'radio', 
                'data-clear' => 'Issue_assignedTo,Issue_authorId',
            )); ?>

            <?= TbHtml::buttonGroup(array(
                array('label' => 'All'),
                array('label' => 'Active', 'class'=>'active', 'htmlOptions' => array(
                    'data-value'=>Issue::STATUS_SCOPE_ACTIVE,
                )),
                array('label' => 'Inactive', 'htmlOptions' => array(
                    'data-value'=>Issue::STATUS_SCOPE_INACTIVE,
                )),
            ), array(
                'toggle' => 'radio', 
                'data-filter' => CHtml::activeId($model, 'statusScope'),
            )); ?>
        </div>
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
        'selectionChanged' => 'function(gridId) {
            var selectedId = $.fn.yiiGridView.getSelection(gridId); 
            if(selectedId) {
                var url = "'.$this->createUrl('view', array('id'=>'__id__')).'";
                location.href = url.replace("__id__", selectedId);
            }
        }',
        'columns' => array(
            array(
                'name' => 'issueId',
                'headerHtmlOptions' => array('width'=>30),
                'value' => '"#{$data->issueId}"',
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
$(document).ready(function() {
    $('#issue-tabs a, #filters a').on('click', function(e) {
        var filter = $(this).attr('data-filter') !== undefined
             ? $(this).attr('data-filter')
             : $(this).parents('[data-filter]').attr('data-filter');
        var clear = $(this).attr('data-clear') !== undefined
             ? $(this).attr('data-clear')
             : $(this).parents('[data-clear]').attr('data-clear');
        var value = $(this).attr('data-value');
       
        if(clear !== undefined) {
            $.each(clear.split(','), function(i, c) {
                $('#' + c).val('').prop('selected', false);
            });
        }
        
        if(filter !== undefined) {
            $.each(filter.split(','), function(i, f) {
               $('#' + f).val(value).prop('selected', true).change();
            }); 
        }
    });
});
</script>
