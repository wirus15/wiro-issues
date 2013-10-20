<?php

class m131020_184201_create_categories_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{categories}}', array(
            'categoryId' => 'pk',
            'categoryName' => 'string not null',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{categories}}');
    }
}
