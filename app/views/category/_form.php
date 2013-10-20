<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type' => TbHtml::FORM_LAYOUT_VERTICAL,
    ));
    ?>

    <fieldset>
        <?= $form->textFieldRow($model, 'categoryName', array('class' => 'span8', 'maxlength' => 40)); ?>
    </fieldset>

    <?= TbHtml::formActions(array(
        TbHtml::submitButton('Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
        TbHtml::linkButton('Cancel', array('url' => array('index'))),
    )); ?>

<?php $this->endWidget(); ?>

</div>