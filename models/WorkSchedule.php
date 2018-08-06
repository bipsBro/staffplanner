<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_schedule".
 *
 * @property int $id
 * @property int $truck_id
 * @property int $location_id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string $remark
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_on
 * @property string $updated_on
 *
 * @property Location $location
 * @property Truck $truck
 */
class WorkSchedule extends \yii\db\ActiveRecord
{
    public $empID;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['truck_id', 'location_id', 'date', 'start_time', 'end_time'], 'required'],
            [['truck_id', 'location_id', 'created_by', 'updated_by'], 'integer'],
            [['date', 'start_time', 'end_time', 'created_on', 'updated_on', 'empID'], 'safe'],
            [['remark'], 'string'],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['truck_id'], 'exist', 'skipOnError' => true, 'targetClass' => Truck::className(), 'targetAttribute' => ['truck_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'truck_id' => Yii::t('app', 'Truck *'),
            'location_id' => Yii::t('app', 'Location *'),
            'date' => Yii::t('app', 'Date *'),
            'start_time' => Yii::t('app', 'Start Time *'),
            'end_time' => Yii::t('app', 'End Time *'),
            'remark' => Yii::t('app', 'Remark'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'empID' => Yii::t('app', 'Employee '),
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

    public function getMinutes()
    {
        return round((abs(strtotime($this->start_time) - strtotime($this->end_time)) / 60)); 
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
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTruck()
    {
        return $this->hasOne(Truck::className(), ['id' => 'truck_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\WorkScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\WorkScheduleQuery(get_called_class());
    }
}
