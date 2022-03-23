<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%post}}`.
 */
class m220316_082250_add_category_id_column_to_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'category_id', $this->integer(11)->notNull());
        $this->createIndex('idx-post-category_id', 'post', 'category_id');
        $this->addForeignKey('fk-post-category_id', 'post', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-post-category_id', 'post');
        $this->dropForeignKey('fk-post-category_id', 'post');
        $this->dropColumn('post', 'category_id');
    }
}
