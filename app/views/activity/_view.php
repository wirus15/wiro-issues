<div class="well well-small">
    <a name="activity<?= $data->activityId; ?>"></a>
    
    <span class="date"><?= $data->dateCreated; ?></span>

    <?php
    $views = array(
        Activity::TYPE_UPDATE => '/activity/_update',
        Activity::TYPE_STATUS_CHANGE => '/activity/_status',
        Activity::TYPE_PRIORITY_CHANGE => '/activity/_priority',
        Activity::TYPE_COMMENT => '/activity/_comment',
        Activity::TYPE_ASSIGNMENT => '/activity/_assignment',
    );
    
    $this->renderPartial($views[$data->activityType], array(
        'activity' => $data,
    ));
    ?>
</div>