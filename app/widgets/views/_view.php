<div class="notification">
    <?= TbHtml::link(
            TbHtml::icon('remove'), 
            array('/notification/delete', 'activityId'=>$data->activityId),
            array('class' => 'remove pull-right')
    ); ?>
    <span class="date"><?= $data->activity->dateCreated; ?></span>

    <?php
    $views = array(
        Activity::TYPE_UPDATE => '_update',
        Activity::TYPE_STATUS_CHANGE => '_status',
        Activity::TYPE_PRIORITY_CHANGE => '_priority',
        Activity::TYPE_COMMENT => '_comment',
        Activity::TYPE_ASSIGNMENT => '_assignment',
        Activity::TYPE_DELETE => '_delete',
    );
    
    $this->render($views[$data->activity->activityType], array(
        'activity' => $data->activity,
    ));
    ?>
</div>