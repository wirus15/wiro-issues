<?php $dataProvider = $model->search(); ?>

<div id="activity-list">
    
    <?php $options = $this->renderPartial('/activity/_options', array(
        'model' => $model,
        'dataProvider' => $dataProvider,
    ), true); ?>
    
    <div class="activity-list-inner">
        <?php 
        $this->widget('bootstrap.widgets.TbListView', array(
            'id' => 'activity-list-view',
            'itemView' => '/activity/_view',
            'template' => "{$options}\n{items}\n{pager}",
            'summaryText' => false,
            'pagerCssClass' => 'pagination pagination-small',
            'dataProvider' => $dataProvider,
        ));
        ?>
    </div>

    <div class="well well-small add-comment">
        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'type' => TbHtml::FORM_LAYOUT_VERTICAL,
            'action' => array('comment', 'id'=>$model->issueId),
        )); ?>
        
        <p>
            <?php $this->widget('bootstrap.widgets.TbRedactorJs', array(
                'model' => $model,
                'attribute' => 'activityData',
                'id' => 'new-comment',
            )); ?>
        </p>
        
        <?= TbHtml::submitButton('Comment', array('color'=>'primary')); ?>
        
        <?php $this->endWidget(); ?>
    </div>
</div>