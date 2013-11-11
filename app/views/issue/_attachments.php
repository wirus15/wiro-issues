<legend>Attachments</legend>
<ul id="attachment-list" class="unstyled">
<?php foreach($issue->attachments as $attachment): ?>
    <li>
        <?= TbHtml::icon('paperclip'); ?>
        <?= TbHtml::link($attachment->fileName, array('/attachment/download', 'id'=>$attachment->attachmentId)); ?>
        <small>Added by <strong><?= $attachment->user->username; ?></strong>
            on <?= $attachment->dateCreated; ?></small>
        <?php if($attachment->canEdit)
            echo TbHtml::linkButton(TbHtml::icon('ban-circle'), array(
                'url' => '#',
                'color' => 'danger',
                'size' => 'mini',
                'title' => 'Delete',
                'confirm' => 'Are you sure you want to delete this file?',
                'submit' => array('/attachment/delete', 'id'=>$attachment->attachmentId),
            )); ?>
    </li>
<?php endforeach; ?>
</ul>

<?php  
$this->widget('wiro\widgets\UploadButton', array(
    'action' => array('/attachment/create', 'id'=>$issue->issueId),
    'model' => new Attachment(),
    'attribute' => 'file',
    'buttonOptions' => array(
        'color' => 'primary',
        'icon' => 'plus',
    ),
)); ?>