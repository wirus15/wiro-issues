<?php $dataProvider = $model->search(); ?>

<div class="activity-list">
    <div id="activity-list-options">
        <div class="pull-left">
            <?php $this->widget('application.widgets.ActivityFilter', array(
                'dataProvider' => $dataProvider,
                'model' => $model,
                'url' => array('/activity/index'),
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
                    'toggle' => 'radio',
                    'size' => 'mini',
                ),
            )); ?>
        </div>

        <div class="pull-right">
            <?php $isDesc = $dataProvider->sort->getDirection('activityId') === CSort::SORT_DESC; ?>
            <?= TbHtml::buttonGroup(array(
                array(
                    'label' => 'Newest first', 
                    'url' => $dataProvider->sort->createUrl($this, array('activityId' => true)),
                    'class' => $isDesc ? 'active' : '', 
                    'icon' => 'arrow-up'),
                array(
                    'label' => 'Oldest first', 
                    'url' => $dataProvider->sort->createUrl($this, array('activityId' => false)),
                    'class' => !$isDesc ? 'active' : '',
                    'icon' => 'arrow-down'
                ),
            ), array(
                'toggle' => 'radio',
                'size' => 'mini',
            )); ?>
        </div>
    </div>

    <div class="activity-list-inner">
        <?php 
        $this->widget('bootstrap.widgets.TbListView', array(
            'id' => 'activity-list-view',
            'itemView' => '/activity/_view',
            'summaryText' => false,
            'pagerCssClass' => 'pagination pagination-small',
            'ajaxUrl' => array('/activity/index'),
            'dataProvider' => $dataProvider,
        ));
        ?>
    </div>

    <div class="well well-small add-comment">
        <p><?php $this->widget('bootstrap.widgets.TbRedactorJs', array(
            'name' => 'lol',
        )); ?></p>
        <?= TbHtml::button('Comment', array('color' => 'primary')); ?>
    </div>
</div>