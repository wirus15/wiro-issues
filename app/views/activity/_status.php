User <strong><?= $activity->user->username; ?></strong> changed status of issue
<?= TbHtml::link("#{$activity->issueId}: {$activity->issue->title}", array('/issue/view', 'id' => $activity->issueId)); ?>
 to <?= $activity->issue->getStatusLabel($activity->activityData); ?>.

