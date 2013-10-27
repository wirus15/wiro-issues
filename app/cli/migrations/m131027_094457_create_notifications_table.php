<?php

class m131027_094457_create_notifications_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{notifications}}', array(
            'userId' => 'integer not null',
            'activityId' => 'integer not null',
            'primary key (userId, activityId)',
            'foreign key (userId) references {{users}}(userId) on update cascade on delete cascade',
            'foreign key (activityId) references {{activities}}(activityId) on update cascade on delete cascade',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{notifications}}');
    }

}
