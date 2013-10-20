<?php
/* @var $this IssueController */
/* @var $model Issue */
$this->breadcrumbs=array(
	'Issues'=>array('index'),
	'Update issue #'.$model->issueId,
);
?>

<fieldset>
    <legend>Update issue #<i><?= $model->issueId; ?></i></legend>

    <p>
    <?= TbHtml::buttonGroup(array(
	array('label' => 'Issues', 'url' => array('index'), 'icon' => 'tasks'),
    )); ?>
    </p>
	
    <hr/>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>