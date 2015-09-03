<?php

/**
 * Class m150625_090711_timetable_add_fields
 */
class m150625_090711_timetable_add_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{lesson_timetable}}','number_year','int(11) NOT NULL');
        $this->addColumn('{{lesson_timetable}}','number_month','int(11) NOT NULL');
        $this->addColumn('{{lesson_timetable}}','number_week','int(11) NOT NULL');
        $this->addColumn('{{lesson_timetable}}','number_day_week','int(11) NOT NULL');
	}

	public function safeDown(){
        $this->dropColumn('{{lesson_timetable}}', 'number_year');
        $this->dropColumn('{{lesson_timetable}}', 'number_month');
        $this->dropColumn('{{lesson_timetable}}', 'number_week');
        $this->dropColumn('{{lesson_timetable}}', 'number_day_week');
	}
}