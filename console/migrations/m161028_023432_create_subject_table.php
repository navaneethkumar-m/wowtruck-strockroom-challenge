<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subject`.
 */
class m161028_023432_create_subject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('subject', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'code' => $this->string(50)->notNull()->unique(),
            'status' => $this->integer(3)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('subject');
    }
}
