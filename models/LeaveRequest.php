<?php

namespace app\models;

use Yii;
use app\helpers\Configuration;

/**
 * This is the model class for table "leave_request".
 *
 * @property int $id
 * @property int $emp_id
 * @property string $leave_date
 * @property int $status
 * @property string $message
 * @property string $requested_date
 * @property int $verified_by
 * @property string $verified_on
 *
 * @property Employee $emp
 */
class LeaveRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'leave_date', 'status', 'message'], 'required'],
            [['emp_id', 'status', 'verified_by'], 'integer'],
            [['leave_date', 'requested_date', 'verified_on'], 'safe'],
            [['message'], 'string'],
            [['emp_id', 'leave_date'], 'unique', 'targetAttribute' => ['emp_id', 'leave_date']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'emp_id' => Yii::t('app', 'Emp code'),
            'leave_date' => Yii::t('app', 'Leave Date'),
            'status' => Yii::t('app', 'Status'),
            'message' => Yii::t('app', 'Message'),
            'requested_date' => Yii::t('app', 'Requested Date'),
            'verified_by' => Yii::t('app', 'Verified By'),
            'verified_on' => Yii::t('app', 'Verified On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Employee::className(), ['id' => 'emp_id']);
    }

    public function getEmployeeCode()
    {
        $content =$this->emp;
        if(isset($content))
        {
            return $content->emp_code. ' - '.$content->getName();
        }
    }

    public function getEmail()
    {
        $content =$this->emp;
        if(isset($content))
        {
            return $content->getEmail();
        }
    }

    public function getVerifiedOn()
    {
        if($this->status == Configuration::PENDING)
        {
            return Configuration::getStatus($this->status);
        } else{
            $date = strtotime($this->verified_on);
            return date("M d, Y H:i:s", $date);
        }
    }
    public function getVerifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'verified_by']);
    }
    public function getVerifiedByName()
    {
        if($this->status == Configuration::PENDING)
        {
            return Configuration::getStatus($this->status);
        } else{
            
            $content = $this->verifiedBy;
            if(isset($content))
            {
                return (Yii::$app->user->identity->id == $this->verified_by) ? "You" : $content->email; 
            }
        }
    }


    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\LeaveRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\LeaveRequestQuery(get_called_class());
    }
}
