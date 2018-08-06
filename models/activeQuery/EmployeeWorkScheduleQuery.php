<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\EmployeeWorkSchedule]].
 *
 * @see \app\models\EmployeeWorkSchedule
 */
class EmployeeWorkScheduleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\EmployeeWorkSchedule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\EmployeeWorkSchedule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
