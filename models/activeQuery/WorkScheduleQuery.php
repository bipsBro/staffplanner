<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\WorkSchedule]].
 *
 * @see \app\models\WorkSchedule
 */
class WorkScheduleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\WorkSchedule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\WorkSchedule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
