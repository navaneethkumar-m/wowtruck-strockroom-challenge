<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teacher_user`.
 * Has foreign keys to the tables:
 *
 * - `teacher`
 * - `user`
 */
class m161028_023622_create_teacher_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teacher_user', [
            'id' => $this->primaryKey(),
            'teacher_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `teacher_id`
        $this->createIndex(
            'idx-teacher_user-teacher_id',
            'teacher_user',
            'teacher_id'
        );

        // add foreign key for table `teacher`
        $this->addForeignKey(
            'fk-teacher_user-teacher_id',
            'teacher_user',
            'teacher_id',
            'teacher',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-teacher_user-user_id',
            'teacher_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-teacher_user-user_id',
            'teacher_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `teacher`
        $this->dropForeignKey(
            'fk-teacher_user-teacher_id',
            'teacher_user'
        );

        // drops index for column `teacher_id`
        $this->dropIndex(
            'idx-teacher_user-teacher_id',
            'teacher_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-teacher_user-user_id',
            'teacher_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-teacher_user-user_id',
            'teacher_user'
        );

        $this->dropTable('teacher_user');
    }
}
