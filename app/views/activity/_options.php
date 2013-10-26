<div id="activity-list-options">
    <div class="pull-left">
        <div class="btn-group">
            <?php $filter = $this->widget('application.widgets.ActivityFilter', array(
                'dataProvider' => $dataProvider,
                'model' => $model,
                'buttons' => array(
                    array(
                        'label' => 'All',
                        'activityType' => null,
                    ),
                    array(
                        'label' => 'Comments', 
                        'activityType' => Activity::TYPE_COMMENT,
                        'icon' => 'comments-alt',
                    ),
                    array(
                        'label' => 'Activities', 
                        'activityType' => '<>'.Activity::TYPE_COMMENT,
                        'icon' => 'exclamation-sign',
                    ),
                ),
                'htmlOptions' => array(
                    'size' => 'mini',
                    'toggle' => 'radio',
                ),
            )); ?>
        </div>
    </div>

    <div class="pull-right">
        <div class="btn-group">
            <?php $isDesc = $dataProvider->sort->getDirection('activityId') === CSort::SORT_DESC; ?>
            <?= TbHtml::linkButton('Newest first', array(
                'url' => $dataProvider->sort->createUrl($this, array('activityId' => true)),
                'class' => $isDesc ? 'btn-mini active' : 'btn-mini', 
                'icon' => 'arrow-up',
            )); ?>
            <?= TbHtml::linkButton('Oldest first', array(
                'url' => $dataProvider->sort->createUrl($this, array('activityId' => false)),
                'class' => !$isDesc ? 'btn-mini active' : 'btn-mini',
                'icon' => 'arrow-down'
            )); ?>
        </div>
    </div>
</div>
