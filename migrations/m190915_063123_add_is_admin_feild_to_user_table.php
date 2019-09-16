<?php

use yii\db\Migration;

/**
 * Class m190915_063123_add_is_admin_feild_to_user_table
 */
class m190915_063123_add_is_admin_feild_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'is_admin', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'is_admin');
    }
}
