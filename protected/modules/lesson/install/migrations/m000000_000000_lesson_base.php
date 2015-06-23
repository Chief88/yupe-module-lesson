<?php

/**
 * Class m000000_000000_lesson_base
 * @category YupeMigration
 * @package  yupe.modules.lesson.install.migrations
 * @author   Chief88 <serg.latyshkov@gmail.com>
 */
class m000000_000000_lesson_base extends yupe\components\DbMigration{

    public function safeUp(){

        $this->createTable(
            '{{lesson_lesson}}',
            [
                'id'            => 'pk',
                'name'          => 'varchar(250) NOT NULL',
                'image'         => 'varchar(250) DEFAULT NULL',
                'hall'          => 'varchar(250) NOT NULL',
                'slug'          => 'varchar(250) NOT NULL',
                'description'   => 'text NOT NULL',
                'type_id'       => 'int(11) NOT NULL',
                'category_id'   => 'int(11) NOT NULL',
                'time_id'       => 'int(11) NOT NULL',
                'staff_id'      => 'int(11) NOT NULL',
                'date'          => 'date NOT NULL',
            ], $this->getOptions()
        );

        $this->createTable(
            '{{lesson_type}}',
            [
                'id'    => 'pk',
                'name'  => 'varchar(250) NOT NULL',
                'image' => 'varchar(250) DEFAULT NULL',
                'slug'  => 'varchar(250) NOT NULL',
            ], $this->getOptions()
        );

        $this->createTable(
            '{{lesson_time}}',
            [
                'id'            => 'pk',
                'time_begin'    => 'varchar(250) NOT NULL',
                'sort'          => 	"integer NOT NULL DEFAULT '1'",
            ], $this->getOptions()
        );

    }

    public function safeDown(){
        $this->dropTableWithForeignKeys('{{lesson_lesson}}');
        $this->dropTableWithForeignKeys('{{lesson_type}}');
        $this->dropTableWithForeignKeys('{{lesson_time}}');
    }
}