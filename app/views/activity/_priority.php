User <strong><?= $user->username; ?></strong> changed priority of issue
<?= TbHtml::link("#{$issue->issueId}: {$issue->title}", array('/issue/view', 'id' => $issue->issueId)); ?>
 to <?= $issue->getPriorityLabel($activity->activityData); ?>.

