<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student_grade`.
 * Has foreign keys to the tables:
 *
 * - `student`
 * - `grade`
 */
class m161028_023520_create_student_grade_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('student_grade', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer()->notNull(),
            'grade_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `student_id`
        $this->createIndex(
            'idx-student_grade-student_id',
            'student_grade',
            'student_id'
        );

        // add foreign key for table `student`
        $this->addForeignKey(
            'fk-student_grade-student_id',
            'student_grade',
            'student_id',
            'student',
            'id',
            'CASCADE'
        );

        // creates index for column `grade_id`
        $this->createIndex(
            'idx-student_grade-grade_id',
            'student_grade',
            'grade_id'
        );

        // add foreign key for table `grade`
        $this->addForeignKey(
            'fk-student_grade-grade_id',
            'student_grade',
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
        // drops foreign key for table `student`
        $this->dropForeignKey(
            'fk-student_grade-student_id',
            'student_grade'
        );

        // drops index for column `student_id`
        $this->dropIndex(
            'idx-student_grade-student_id',
            'student_grade'
        );

        // drops foreign key for table `grade`
        $this->dropForeignKey(
            'fk-student_grade-grade_id',
            'student_grade'
        );

        // drops index for column `grade_id`
        $this->dropIndex(
            'idx-student_grade-grade_id',
            'student_grade'
        );

        $this->dropTable('student_grade');
    }
}
