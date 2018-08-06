<?php
namespace app\helpers; 

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "configuration".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $can_update_value
 */
class Configuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'can_update_value'], 'required'],
            [['value'], 'string'],
            [['can_update_value'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'can_update_value' => Yii::t('app', 'Can Update Value'),
        ];
    }



    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\ConfigurationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\ConfigurationQuery(get_called_class());
    }


    const SYSTEM_NAME = 'System';
    
    const ACTIVE = 1;
    const INACTIVE = 2;


    const YES = 3;
    const NO = 4;


    const PENDING = 5;
    const APPROVED = 6;
    const DECLINED = 7;


    const OPEN =8; 
    const ADMIN_CREATED =9;

    const USER_ROLE_EMPLOYEE ='employee';


    const FEATURE_ARRAY = [
        self::YES => "Yes",
        self::NO => "No"
    ];


    const STATUS_ARRAY = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    const LEAVE_ARRAY = [
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::DECLINED => 'Declined',
    ];

    const WORK_SCHEDULE_ARRAY = [
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::DECLINED => 'Declined', 
    ];

    const REQUEST_TYPE_ARRAY = [
        self::OPEN => 'Open request',
        self::ADMIN_CREATED => 'Admin created', 
    ];

     const GET_SKINS_ARRAY = [
        'skin-blue' => 'skin-blue',
        'skin-black' => 'skin-black',
        'skin-red' => 'skin-red',
        'skin-yellow' => 'skin-yellow',
        'skin-purple' => 'skin-purple',
        'skin-green' => 'skin-green',
        'skin-blue-light' => 'skin-blue-light',
        'skin-black-light' => 'skin-black-light',
        'skin-red-light' => 'skin-red-light',
        'skin-yellow-light' => 'skin-yellow-light',
        'skin-purple-light' => 'skin-purple-light',
        'skin-green-light' => 'skin-green-light'

    ];
    const DEFAULT_SKIN = "default_skin";

    public static function getDefaultSkin()
    {
        return self::getSitedata('default_skin');
    }

    public static function getStatus($value)
    {
        switch ($value) {
            case self::ACTIVE: return self::STATUS_ARRAY[self::ACTIVE];
            case self::INACTIVE : return self::STATUS_ARRAY[self::INACTIVE]; 
            case self::YES: return "Yes";
            case self::NO:  return "No";
            case self::PENDING: return self::LEAVE_ARRAY[self::PENDING];
            case self::APPROVED : return self::LEAVE_ARRAY[self::APPROVED]; 
            case self::DECLINED : return self::LEAVE_ARRAY[self::DECLINED]; 
            case self::OPEN : return self::REQUEST_TYPE_ARRAY[self::OPEN]; 
            case self::ADMIN_CREATED : return self::REQUEST_TYPE_ARRAY[self::ADMIN_CREATED]; 
        }
    }

     /**
     * @param $name
     * @param bool $boolenOnly
     * @return bool|mixed|null
     */
    public static function getSitedata($name, $boolenOnly = false)
    { 
          if ($name != null) {

          //  $config = self::find()->where(['name' => $name])->one();
            $config = Yii::$app->setting->getConfig();

            if (!is_null($config)) {

                $name = ArrayHelper::getValue($config,$name,'N/A');

                //check if it is  boolen value

                if ($boolenOnly) {
                    if($name == "N/A"){
                        return false;
                    }

                    $checkTrue = ['1', 'true', 'TRUE', 'True', 'one', 'One', 'ONE'];
                    $checkFalse = ['0', 'false', 'FALSE', 'False', 'zero', 'ZERO', 'Zero'];
                    if (in_array($name['value'], $checkTrue, true)) {
                        return true;
                    } elseif (in_array($name['value'], $checkFalse, true)) {
                        return false;
                    } else {
                        return false;
                    }
                }

                if($name == "N/A"){
                    return $name;
                }
                return $name['value'];

            } else {
                return null;
            }


        } else {
            return false;
        }

    }
    public static function updateSiteData($name, $value)
    {
        $configData=self::find()->where(['name' => $name])->one();
        if(!is_null($configData)){
            if($configData->can_update_value==1){
                $configData->value = $value;
                return $configData->save(false);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
 
?>