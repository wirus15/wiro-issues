User <strong><?= $activity->user->username; ?></strong> assigned issue
<?= TbHtml::link("#{$activity->issueId}: {$activity->issue->title}", array('/issue/view', 'id' => $activity->issueId)); ?>
 to <strong><?= $activity->activityData; ?></strong>.

