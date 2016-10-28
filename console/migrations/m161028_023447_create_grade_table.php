<?php

use yii\db\Migration;

/**
 * Handles the creation of table `grade`.
 */
class m161028_023447_create_grade_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('grade', [
            'id' => $this->primaryKey(),
            'standard' => $this->string(50)->notNull(),
            'section' => $this->string(50)->notNull(),
            'code' => $this->string(50)->notNull()->unique(),
            'status' => $this->integer(3)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('grade');
    }
}
