<?php

/**
 * Class m150622_090311_timetable
 * @category YupeMigration
 * @package  yupe.modules.lesson.install.migrations
 * @author   Chief88 <serg.latyshkov@gmail.com>
 */
class m150622_090311_timetable extends yupe\components\DbMigration{

    public function safeUp(){

        $this->createTable(
            '{{lesson_timetable}}',
            [
                'id'            => 'pk',
                'date'          => 'varchar(250) NOT NULL',
            ], $this->getOptions()
        );

    }

    public function safeDown(){
        $this->dropTableWithForeignKeys('{{lesson_timetable}}');
    }
}