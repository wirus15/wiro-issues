User <strong><?= $user->username; ?></strong> updated issue
<?= TbHtml::link("#{$issue->issueId}: {$issue->title}", array('/issue/view', 'id' => $issue->issueId)); ?>.
