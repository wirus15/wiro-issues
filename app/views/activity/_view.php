<div class="well well-small">
    <a name="activity<?= $activity->activityId; ?>"></a>
    
    <span class="date"><?= $activity->dateCreated; ?></span>

    <?php
    $this->renderPartial($view, array(
        'activity' => $activity,
        'user' => $activity->user,
        'issue' => $activity->issue,
    ));
    ?>
</div>