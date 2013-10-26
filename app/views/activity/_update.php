User <strong><?= $activity->user->username; ?></strong> updated issue
<?= TbHtml::link("#{$activity->issueId}: {$activity->issue->title}", array('/issue/view', 'id' => $activity->issueId)); ?>.
