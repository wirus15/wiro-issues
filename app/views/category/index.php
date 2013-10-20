<?php
/* @var $this CategoryController */
/* @var $model Category */
$this->breadcrumbs = array('Categories');
?>

<fieldset>
    <legend>Categories</legend>

    <p>
        <?= TbHtml::linkButton('Create category', array('url' => array('create'), 'color' => TbHtml::BUTTON_COLOR_PRIMARY, 'icon' => 'icon-plus icon-white')); ?>
    </p>

    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'category-grid',
        'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_CONDENSED),
        'dataProvider' => $model->search(),
        'filter' => null,
        'template' => "<div class=\"pull-right\">{summary}</div>{items}\n{pager}",
        'columns' => array(
            'categoryName',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{update} {delete}',
            ),
        ),
    ));
    ?>
</fieldset>
