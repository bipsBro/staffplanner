<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property int $user_id
 * @property string $emp_code
 * @property string $contact_no
 * @property string $address1
 * @property string $address2
 * @property string $contract_url
 * @property int $contract_limit
 * @property string $contract_expirydate
 * @property int $hour_worked
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property Profile $user
 */
class Employee extends \yii\db\ActiveRecord
{ 
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';


    public $name;
    public $email;
    public $username;
    public $userId;  
    public $gender;
    public function setUserInfo()
    {  
        $profile = $this->getUser()->one(); 
        $this->userId = $profile->user_id; 
        $this->name = $profile->name;  
        $this->email = $profile->public_email; 
        $this->gender = $profile->gender; 
        $this->username = $profile->user->username; 
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'username', 'contact_no', 'address1', 'address2', 'contract_limit', 'contract_expirydate', 'gender'], 'required'],
            [['user_id', 'contract_limit', 'hour_worked', 'created_by', 'updated_by', 'emp_code'], 'integer'],
            [['address1', 'address2', 'name', 'email', 'username','gender'], 'string'],
            ['email','email'],
            [['contract_expirydate', 'created_on', 'updated_on'], 'safe'],
            [['contact_no', 'contract_url'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'email', 'username', 'contact_no', 'address1', 'address2', 'contract_limit', 'contract_expirydate', 'gender'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'contact_no', 'address1', 'address2', 'contract_limit', 'contract_expirydate', 'gender'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'username'),
            'emp_code' => Yii::t('app', 'Employee'),
            'contact_no' => Yii::t('app', 'Contact no'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'contract_url' => Yii::t('app', 'Contract url'),
            'contract_limit' => Yii::t('app', 'Contract limit (Hint : In Hours)'),
            'contract_expirydate' => Yii::t('app', 'Contract expiry date'),
            'hour_worked' => Yii::t('app', 'Hour worked'),
            'created_by' => Yii::t('app', 'Created by'),
            'created_on' => Yii::t('app', 'Created on'),
            'updated_by' => Yii::t('app', 'Last updated by'),
            'updated_on' => Yii::t('app', 'Last updated on'),  
            'gender' => Yii::t('app', 'Gender'), 
        ];
    }




    public function beforeSave($text)
    { 
        $this->hour_worked = $this->hour_worked * 60;
        $this->updated_by = Yii::$app->user->identity->id;
        $this->updated_on = date("Y-m-d H:i:s");
        if($this->isNewRecord)
        {
            $this->emp_code = sprintf("%06d", mt_rand(1, 999999));
            $this->created_by = Yii::$app->user->identity->id;
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

    public function getUserData()
    {
        return $this->hasOne(User::className(),['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
        
    }


    public function getName()
    {
        $content = $this->user;
        if(isset($content))
        {
            return $content->name;
        }
    }
    public function getEmail()
    {
        $content = $this->user;
        if(isset($content))
        {
            return $content->public_email;
        }
    }

    public function getUserName()
    {
        $content = $this->user;
        if(isset($content))
        {
            return $content->user->username;
        }
    }

    public function getContractLimit()
    {
        return $this->contract_limit.' hours';
    }

    public function getHourWorked()
    {
        $hour = round(($this->hour_worked / 60 )).' hours ';
        $minute = (($this->hour_worked % 60) != 0) ? ($this->hour_worked % 60).' minutes ' : '';
        return $hour. ' '.$minute;
    }

    public function getEmployeeSelectData()
    {
        $hour = round(($this->hour_worked / 60 )).' hours ';
        $minute = (($this->hour_worked % 60) != 0) ? ($this->hour_worked % 60).' minutes ' : '';
        $hoursWorked = $hour. ' '.$minute;
        return $this->emp_code.' - '.$this->getName().' ('.$hoursWorked.')'; 
    }
 
    public function getEmployeeSelectDataSchedule()
    {
        $hourRemaining = ($this->contract_limit * 60) - $this->hour_worked;
        if($hourRemaining > 0)
        {
            $hour = round(($hourRemaining / 60 )).' hours ';
            $minute = (($hourRemaining % 60) != 0) ? ($hourRemaining % 60).' minutes ' : '';
            $hourRemaining = $hour. ' '.$minute;

            return $this->emp_code.' - '.$this->getName().' ('.$hourRemaining.' remaining)';
        }
        else
        {
            return $this->emp_code.' - '.$this->getName()." (Monthly limit exceed)";
        }
    }
    public function getHourRemaining()
    {
        $hourRemaining = ($this->contract_limit * 60) - $this->hour_worked;
        if($hourRemaining > 0)
        {
            $hour = round(($hourRemaining / 60 )).' hours ';
            $minute = (($hourRemaining % 60) != 0) ? ($hourRemaining % 60).' minutes ' : '';
            $hourRemaining = $hour. ' '.$minute;

            return $hourRemaining.' remaining';
        }
        else
        {
            return "(Monthly limit exceed)";
        }
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\EmployeeQuery(get_called_class());
    }
}
