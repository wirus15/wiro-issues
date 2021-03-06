<?php

use wiro\modules\users\models\User;
/* @var $this IssueController */
/* @var $model Issue */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'type' => TbHtml::FORM_LAYOUT_VERTICAL,
    )); ?>

	<div class="well well-small">Fields with <span class="required">*</span> are required.</div>

        <fieldset>
            <div class="row-fluid">
                <div class="span8">
                    <?= $form->textFieldRow($model, 'title', array('class'=>'input-block-level')); ?>
                    <?= $form->redactorRow($model, 'description', array(
                        'options'=>array(
                            'clipboardUploadUrl' => $this->createUrl('/site/upload', array('clipboard'=>true)),
                            'imageUpload' => $this->createUrl('/site/upload'),
                        ),
                    )); ?>
                    <br/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <?= $form->dropDownListRow($model, 'type', $model->typeList); ?>
                    <?= $form->dropDownListRow($model, 'categoryId', Category::model()->listModels('categoryName')); ?>
                </div>
                <div class="span3">
                    <?= $form->dropDownListRow($model, 'priority', $model->priorityList); ?>
                    <?= $form->dropDownListRow($model, 'status', $model->statusList); ?>
                </div>
            </div>
        </fieldset>
	
        <?= $form->dropDownListRow($model, 'assignedTo', User::model()->listModels('username'), array('empty'=>'')); ?>

	<?= TbHtml::formActions(array(
            TbHtml::submitButton('Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
            TbHtml::linkButton('Cancel', array('url' => 'javascript:history.go(-1)')),
        )); ?>

<?php $this->endWidget(); ?>

</div>
