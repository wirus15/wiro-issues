<?php
/* @var $this CategoryController */
/* @var $model Category */
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Update '.$model->categoryName,
);
?>

<fieldset>
    <legend>Update <i><?= $model->categoryName; ?></i></legend>

    <p>
    <?= TbHtml::buttonGroup(array(
	array('label' => 'Categories', 'url' => array('index'), 'icon' => 'folder-open'),
    )); ?>
    </p>
	
    <hr/>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>