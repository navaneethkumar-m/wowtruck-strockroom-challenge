<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teacher`.
 */
class m161028_023353_create_teacher_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teacher', [
            'id' => $this->primaryKey(),
            'salutation' => $this->string(16)->notNull(),
            'first_name' => $this->string(50)->notNull(),
            'middle_name' => $this->string(50),
            'last_name' => $this->string(50)->notNull(),
            'emp_id' => $this->integer()->notNull()->unique(),
            'joined_on' => $this->dateTime()->notNull(),
            'date_of_birth' => $this->date()->notNull(),
            'status' => $this->integer(3)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('teacher');
    }
}
