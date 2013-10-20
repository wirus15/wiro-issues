<?php

class m130701_174407_create_config_table extends CDbMigration
{

    public function safeUp()
    {
        $this->createTable('{{config}}', array(
            'id' => 'pk',
            'key' => 'string not null',
            'value' => 'text',
            'type' => 'integer not null default 0',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{config}}');
    }
}