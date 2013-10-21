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
        'tabs' => array(
            array(
                'label' => 'Issues',
                'active' => true,
                'url' => array('index'),
            ),
            array(
                'label' => 'Features',
                'url' => array('index', 'Issue[type]' => Issue::TYPE_FEATURE),
            ),
            array(
                'label' => 'Bugs',
                'url' => array('index', 'Issue[type]' => Issue::TYPE_BUG),
            ),
            array(
                'label' => 'Enhancements',
                'url' => array('index', 'Issue[type]' => Issue::TYPE_ENHANCEMENT),
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
        <div class="pull-right">
            <?= TbHtml::buttonGroup(array(
                array('label' => 'All', 'class'=>'active'),
                array('label' => 'Assigned to me', 'htmlOptions' => array('data-filter' => 'assignedtome')),
                array('label' => 'Created by me', 'htmlOptions' => array('data-filter' => 'createdbyme')),
                array('label' => 'Unassigned', 'htmlOptions' => array('data-filter' => 'unassigned')),
            ), array('toggle' => 'radio', 'class'=>'additional-filters')); ?>

            <?= TbHtml::buttonGroup(array(
                array('label' => 'Active', 'class'=>'active', 'htmlOptions' => array('data-filter'=>'active')),
                array('label' => 'Inactive', 'htmlOptions' => array('data-filter'=>'inactive')),
            ), array('toggle' => 'checkbox', 'class'=>'additional-filters')); ?>
        </div>
    </div>
    
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'issue-grid',
        'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_CONDENSED),
        'dataProvider' => $model->search(),
        'filter' => $model,
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
                'filter' => User::model()->listModels('username'),
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
    $('#issue-tabs a').on('click', function(e) {
        var url = $(this).attr('href');
        var filters = [];
        $('.additional-filters a.btn.active').each(function(index, item) {
            filters.push($(item).attr('data-filter'));
        });

        jQuery('#issue-grid').yiiGridView('update', { 
            url: url, 
            data: {
                additionalFilters: filters
            }
        });
        $('#issue-tabs li').removeClass('active');
        $(this).parents('li').addClass('active');
        return false;
    });
    
    $('.additional-filters a').on('click', function(e) {
        $(this).parents('div[data-toggle="buttons-radio"]').find('a.active').removeClass('active');
        $(this).toggleClass('active');
        $('#issue-tabs li.active a').click();
        return false;
    });
});
</script>
