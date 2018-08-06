<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\LeaveRequest]].
 *
 * @see \app\models\LeaveRequest
 */
class LeaveRequestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\LeaveRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\LeaveRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
