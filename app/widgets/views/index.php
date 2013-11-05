<div id="notifications" class="bottom">
    <div class="arrow"></div>
    <h3 class="popover-title">
        Notifications
        <a class="remove pull-right" href="<?= $this->controller->createUrl('/notification/deleteall'); ?>">
            <i class="icon-remove"></i> Remove all
        </a>
    </h3>
    
    <div class="popover-content">
        <div id="notification-list">
        <?php 
            $this->widget('bootstrap.widgets.TbListView', array(
                'id' => 'notification-list-view',
                'itemView' => '_view',
                'template' => '{items}',
                'dataProvider' => $dataProvider,
            ));
        ?>
        </div>
    </div>
</div>