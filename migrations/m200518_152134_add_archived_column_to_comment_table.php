<?php

use yii\db\Migration;

/**
 * Handles adding url to table `comment`.
 */
class m200518_152134_add_archived_column_to_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%comment}}', 'archived', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%comment}}', 'archived');
    }
}
