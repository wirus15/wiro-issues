User <strong><?= $user->username; ?></strong> changed status of issue
<?= TbHtml::link("#{$issue->issueId}: {$issue->title}", array('/issue/view', 'id' => $issue->issueId)); ?>
 to <?= $issue->getStatusLabel($activity->activityData); ?>.

