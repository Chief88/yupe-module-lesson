<?php

/**
 * Class m150622_125811_timetable_lesson
 * @category YupeMigration
 * @package  yupe.modules.lesson.install.migrations
 * @author   Chief88 <serg.latyshkov@gmail.com>
 */
class m150622_125811_timetable_lesson extends yupe\components\DbMigration{

    public function safeUp(){

        $this->createTable(
            '{{lesson_timetable_lesson}}',
            [
                'id'            => 'pk',
                'date_id'       => 'int(11) NOT NULL',
                'time_id'       => 'int(11) NOT NULL',
                'lesson_id'     => 'int(11) NOT NULL',
                'staff_id'      => 'int(11) NOT NULL',
            ], $this->getOptions()
        );

    }

    public function safeDown(){
        $this->dropTableWithForeignKeys('{{lesson_timetable_lesson}}');
    }
}