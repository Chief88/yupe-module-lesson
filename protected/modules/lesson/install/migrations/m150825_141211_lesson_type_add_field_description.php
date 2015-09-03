<?php

/**
 * Class m150825_141211_lesson_type_add_field_description.
 */
class m150825_141211_lesson_type_add_field_description extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{lesson_type}}','description','text NOT NULL');
	}

	public function safeDown(){
        $this->dropColumn('{{lesson_type}}', 'description');
	}
}