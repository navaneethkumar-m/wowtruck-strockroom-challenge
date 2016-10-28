<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teacher_grade_subject`.
 * Has foreign keys to the tables:
 *
 * - `teacher`
 * - `grade`
 * - `subject`
 */
class m161028_023642_create_teacher_grade_subject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teacher_grade_subject', [
            'id' => $this->primaryKey(),
            'teacher_id' => $this->integer()->notNull(),
            'grade_id' => $this->integer()->notNull(),
            'subject_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `teacher_id`
        $this->createIndex(
            'idx-teacher_grade_subject-teacher_id',
            'teacher_grade_subject',
            'teacher_id'
        );

        // add foreign key for table `teacher`
        $this->addForeignKey(
            'fk-teacher_grade_subject-teacher_id',
            'teacher_grade_subject',
            'teacher_id',
            'teacher',
            'id',
            'CASCADE'
        );

        // creates index for column `grade_id`
        $this->createIndex(
            'idx-teacher_grade_subject-grade_id',
            'teacher_grade_subject',
            'grade_id'
        );

        // add foreign key for table `grade`
        $this->addForeignKey(
            'fk-teacher_grade_subject-grade_id',
            'teacher_grade_subject',
            'grade_id',
            'grade',
            'id',
            'CASCADE'
        );

        // creates index for column `subject_id`
        $this->createIndex(
            'idx-teacher_grade_subject-subject_id',
            'teacher_grade_subject',
            'subject_id'
        );

        // add foreign key for table `subject`
        $this->addForeignKey(
            'fk-teacher_grade_subject-subject_id',
            'teacher_grade_subject',
            'subject_id',
            'subject',
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
            'fk-teacher_grade_subject-teacher_id',
            'teacher_grade_subject'
        );

        // drops index for column `teacher_id`
        $this->dropIndex(
            'idx-teacher_grade_subject-teacher_id',
            'teacher_grade_subject'
        );

        // drops foreign key for table `grade`
        $this->dropForeignKey(
            'fk-teacher_grade_subject-grade_id',
            'teacher_grade_subject'
        );

        // drops index for column `grade_id`
        $this->dropIndex(
            'idx-teacher_grade_subject-grade_id',
            'teacher_grade_subject'
        );

        // drops foreign key for table `subject`
        $this->dropForeignKey(
            'fk-teacher_grade_subject-subject_id',
            'teacher_grade_subject'
        );

        // drops index for column `subject_id`
        $this->dropIndex(
            'idx-teacher_grade_subject-subject_id',
            'teacher_grade_subject'
        );

        $this->dropTable('teacher_grade_subject');
    }
}
