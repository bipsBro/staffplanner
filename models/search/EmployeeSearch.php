<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form of `app\models\Employee`.
 */
class EmployeeSearch extends Employee
{

    public $name;
    public $email;
    public $username;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'contract_limit', 'hour_worked', 'created_by', 'updated_by', 'emp_code'], 'integer'],
            [['name', 'email', 'username', 'contact_no', 'address1', 'address2', 'contract_url', 'contract_expirydate', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Employee::find();
        $query->joinWith('user');
        $query->joinWith('userData');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'emp_code' => $this->emp_code,
            'contract_limit' => $this->contract_limit,
            'contract_expirydate' => $this->contract_expirydate,
            'hour_worked' => $this->hour_worked,
            'created_by' => $this->created_by,
            'created_on' => $this->created_on,
            'updated_by' => $this->updated_by,
            'updated_on' => $this->updated_on,
        ]);

        $query->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'contract_url', $this->contract_url]) 
            ->andFilterWhere(['like', 'profile.public_email', $this->email])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'profile.name', $this->name]);

        return $dataProvider;
    }
}
