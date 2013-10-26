User <strong><?= $activity->user->username; ?></strong> changed priority of issue
<?= TbHtml::link("#{$activity->issueId}: {$activity->issue->title}", array('/issue/view', 'id' => $activity->issueId)); ?>
 to <?= $activity->issue->getPriorityLabel($activity->activityData); ?>.

