<div id="issue-filters" class="pull-right">
    <?php $this->widget('application.widgets.IssueFilter', array(
        'dataClear' => 'assignedTo,authorId,watchedScope',
        'model' => $model,
        'items' => array(
            array('label' => 'All', 'default'=>true),
            array('label' => 'Watched', 'filter' => 'watchedScope', 'value' => 1),
            array('label' => 'Assigned to me', 'filter' => 'assignedTo', 'value' => Yii::app()->user->id),
            array('label' => 'Created by me', 'filter' => 'authorId', 'value' => Yii::app()->user->id),
            array('label' => 'Unassigned', 'filter' => 'assignedTo', 'value' => 'unassigned'),
        ),
     )); ?>
    
     <?php $this->widget('application.widgets.IssueFilter', array(
        'dataFilter' => 'statusScope',
        'model' => $model,
        'items' => array(
            array('label' => 'Active', 'value' => Issue::STATUS_SCOPE_ACTIVE),
            array('label' => 'Inactive', 'value' => Issue::STATUS_SCOPE_INACTIVE),
        ),
     )); ?>
</div>