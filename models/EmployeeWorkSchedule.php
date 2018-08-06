<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_work_schedule".
 *
 * @property int $id
 * @property int $emp_id
 * @property int $schedule_id
 * @property int $request_type 
 * @property int $status
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property Employee $emp
 * @property WorkSchedule $schedule
 */
class EmployeeWorkSchedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_work_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'schedule_id'], 'required'],
            [['emp_id', 'schedule_id', 'request_type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['emp_id', 'schedule_id'], 'unique', 'targetAttribute' => ['emp_id', 'schedule_id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'id']],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkSchedule::className(), 'targetAttribute' => ['schedule_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'emp_id' => Yii::t('app', 'Employee'),
            'schedule_id' => Yii::t('app', 'Schedule ID'),
            'request_type' => Yii::t('app', 'Request type'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }
    public function beforeSave($text)
    { 
        if($this->isNewRecord)
        { 
            $this->created_by = Yii::$app->user->identity->id;
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_on = date("Y-m-d H:i:s");
        }
        else
        {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_on = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($text);
    }

    public function getCreatedOn()
    {
        $date = strtotime($this->created_on);
        return date("M d, Y H:i:s", $date);
    }

    public function getUpdatedOn()
    {
        $date = strtotime($this->updated_on);
        return date("M d, Y H:i:s", $date);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getCreatedByName()
    {
        $content = $this->createdBy; 
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->created_by) ? "You" : $content->email;
        }
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    public function getUpdatedByName()
    {
        $content = $this->updatedBy; 
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->updated_by) ? "You" : $content->email; 
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Employee::className(), ['id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(WorkSchedule::className(), ['id' => 'schedule_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\EmployeeWorkScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\EmployeeWorkScheduleQuery(get_called_class());
    }
}
