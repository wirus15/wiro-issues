<div class="notification">
    <?= TbHtml::link(
            TbHtml::icon('remove'), 
            array('/notification/delete', 'activityId'=>$data->activityId),
            array('class' => 'remove pull-right')
    ); ?>
    <span class="date"><?= $data->activity->dateCreated; ?></span>

    <?php
    $views = array(
        Activity::TYPE_UPDATE => '/activity/_update',
        Activity::TYPE_STATUS_CHANGE => '/activity/_status',
        Activity::TYPE_PRIORITY_CHANGE => '/activity/_priority',
        Activity::TYPE_COMMENT => '/notification/_comment',
        Activity::TYPE_ASSIGNMENT => '/activity/_assignment',
    );
    
    $this->renderPartial($views[$data->activity->activityType], array(
        'activity' => $data->activity,
    ));
    ?>
</div>