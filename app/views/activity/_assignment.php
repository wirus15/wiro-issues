User <strong><?= $user->username; ?></strong> assigned issue
<?= TbHtml::link("#{$issue->issueId}: {$issue->title}", array('/issue/view', 'id' => $issue->issueId)); ?>
 to <strong><?= $activity->activityData; ?></strong>.

