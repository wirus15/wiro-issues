<?php

class m130328_111458_create_pages_table extends CDbMigration
{

    public function safeUp()
    {
        $this->createTable('{{pages}}', array(
            'pageId' => 'pk',
            'pageAlias' => 'string',
            'pageTitle' => 'string not null',
            'pageContent' => 'text',
            'metaKeywords' => 'string',
            'metaDescription' => 'text',
            'pageView' => 'string',
            'updateTime' => 'datetime',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{pages}}');
    }
}