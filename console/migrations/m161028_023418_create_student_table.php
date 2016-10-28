<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student`.
 */
class m161028_023418_create_student_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('student', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(50)->notNull(),
            'middle_name' => $this->string(50),
            'last_name' => $this->string(50)->notNull(),
            'registration_no' => $this->integer()->notNull()->unique(),
            'registered_on' => $this->dateTime()->notNull(),
            'date_of_birth' => $this->date()->notNull(),
            'status' => $this->integer(3)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('student');
    }
}
