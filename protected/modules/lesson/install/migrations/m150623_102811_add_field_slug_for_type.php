<?php

/**
 * Class m150623_102811_add_field_slug_for_type.
 */
class m150623_102811_add_field_slug_for_type extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{lesson_type}}','slug','varchar(250) NOT NULL');
	}

	public function safeDown(){
        $this->dropColumn('{{lesson_type}}', 'slug');
	}
}