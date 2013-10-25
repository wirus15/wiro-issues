<div id="issue-filters" class="pull-right">
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