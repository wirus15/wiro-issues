<?php
/* @var $this CategoryController */
/* @var $model Category */
$this->breadcrumbs=array(
	'Issues'=>array('index'),
	'Create issue',
);
?>

<fieldset>
    <legend>Create issue</legend>

    <p>
    <?= TbHtml::buttonGroup(array(
	array('label' => 'Issues', 'url' => array('index'), 'icon' => TbHtml::ICON_TASKS),
    )); ?>
    </p>
	
    <hr/>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>