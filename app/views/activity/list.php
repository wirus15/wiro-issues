<?php

$views = array(
    Activity::TYPE_UPDATE => '/activity/_update',
    Activity::TYPE_STATUS_CHANGE => '/activity/_status',
    Activity::TYPE_PRIORITY_CHANGE => '/activity/_priority',
    Activity::TYPE_COMMENT => '/activity/_comment',
    Activity::TYPE_ASSIGNMENT => '/activity/_assignment',
);

foreach($activities as $activity) {
    $this->renderPartial('/activity/_view', array(
        'activity' => $activity,
        'view' => $views[$activity->activityType],
    ));
}