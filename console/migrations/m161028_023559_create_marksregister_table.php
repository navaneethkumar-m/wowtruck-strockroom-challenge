<?php

use yii\db\Migration;

/**
 * Handles the creation of table `marksregister`.
 * Has foreign keys to the tables:
 *
 * - `grade`
 * - `student`
 * - `subject`
 * - `user`
 */
class m161028_023559_create_marksregister_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('marksregister', [
            'id' => $this->primaryKey(),
            'grade_id' => $this->integer()->notNull(),
            'student_id' => $this->integer()->notNull(),
            'subject_id' => $this->integer()->notNull(),
            'score' => $this->integer()->notNull(),
            'updated_on' => $this->dateTime()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        // creates index for column `grade_id`
        $this->createIndex(
            'idx-marksregister-grade_id',
            'marksregister',
            'grade_id'
        );

        // add foreign key for table `grade`
        $this->addForeignKey(
            'fk-marksregister-grade_id',
            'marksregister',
            'grade_id',
            'grade',
            'id',
            'CASCADE'
        );

        // creates index for column `student_id`
        $this->createIndex(
            'idx-marksregister-student_id',
            'marksregister',
            'student_id'
        );

        // add foreign key for table `student`
        $this->addForeignKey(
            'fk-marksregister-student_id',
            'marksregister',
            'student_id',
            'student',
            'id',
            'CASCADE'
        );

        // creates index for column `subject_id`
        $this->createIndex(
            'idx-marksregister-subject_id',
            'marksregister',
            'subject_id'
        );

        // add foreign key for table `subject`
        $this->addForeignKey(
            'fk-marksregister-subject_id',
            'marksregister',
            'subject_id',
            'subject',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-marksregister-updated_by',
            'marksregister',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-marksregister-updated_by',
            'marksregister',
            'updated_by',
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
        // drops foreign key for table `grade`
        $this->dropForeignKey(
            'fk-marksregister-grade_id',
            'marksregister'
        );

        // drops index for column `grade_id`
        $this->dropIndex(
            'idx-marksregister-grade_id',
            'marksregister'
        );

        // drops foreign key for table `student`
        $this->dropForeignKey(
            'fk-marksregister-student_id',
            'marksregister'
        );

        // drops index for column `student_id`
        $this->dropIndex(
            'idx-marksregister-student_id',
            'marksregister'
        );

        // drops foreign key for table `subject`
        $this->dropForeignKey(
            'fk-marksregister-subject_id',
            'marksregister'
        );

        // drops index for column `subject_id`
        $this->dropIndex(
            'idx-marksregister-subject_id',
            'marksregister'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-marksregister-updated_by',
            'marksregister'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'idx-marksregister-updated_by',
            'marksregister'
        );

        $this->dropTable('marksregister');
    }
}
