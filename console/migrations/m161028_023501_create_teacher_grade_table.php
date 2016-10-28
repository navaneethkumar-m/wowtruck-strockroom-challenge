<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teacher_grade`.
 * Has foreign keys to the tables:
 *
 * - `teacher`
 * - `grade`
 */
class m161028_023501_create_teacher_grade_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teacher_grade', [
            'id' => $this->primaryKey(),
            'teacher_id' => $this->integer()->notNull(),
            'grade_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `teacher_id`
        $this->createIndex(
            'idx-teacher_grade-teacher_id',
            'teacher_grade',
            'teacher_id'
        );

        // add foreign key for table `teacher`
        $this->addForeignKey(
            'fk-teacher_grade-teacher_id',
            'teacher_grade',
            'teacher_id',
            'teacher',
            'id',
            'CASCADE'
        );

        // creates index for column `grade_id`
        $this->createIndex(
            'idx-teacher_grade-grade_id',
            'teacher_grade',
            'grade_id'
        );

        // add foreign key for table `grade`
        $this->addForeignKey(
            'fk-teacher_grade-grade_id',
            'teacher_grade',
            'grade_id',
            'grade',
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
            'fk-teacher_grade-teacher_id',
            'teacher_grade'
        );

        // drops index for column `teacher_id`
        $this->dropIndex(
            'idx-teacher_grade-teacher_id',
            'teacher_grade'
        );

        // drops foreign key for table `grade`
        $this->dropForeignKey(
            'fk-teacher_grade-grade_id',
            'teacher_grade'
        );

        // drops index for column `grade_id`
        $this->dropIndex(
            'idx-teacher_grade-grade_id',
            'teacher_grade'
        );

        $this->dropTable('teacher_grade');
    }
}
