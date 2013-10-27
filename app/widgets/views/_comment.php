User <strong><?= $activity->user->username; ?></strong> 
wrote a new comment on issue
<?= TbHtml::link("#{$activity->issueId}: {$activity->issue->title}", array('/issue/view', 'id' => $activity->issueId)); ?>.