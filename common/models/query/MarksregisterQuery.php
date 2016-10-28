<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Marksregister]].
 *
 * @see \common\models\Marksregister
 */
class MarksregisterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Marksregister[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Marksregister|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
