<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * This is the model class for table "api_visitors".
 *
 * @property integer $id
 * @property string $user_ip
 * @property string $datetime
 * @property string $last_get
 * @property string $status
 */
class ApiVisitors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_visitors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_ip', 'datetime', 'last_get'], 'required'],
            [['datetime', 'last_get'], 'safe'],
            [['status'], 'string'],
            [['user_ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_ip' => 'User Ip',
            'datetime' => 'Datetime',
            'last_get' => 'Last Get',
            'status' => 'Status',
        ];
    }

    public function findByIp($ip){
        if(($model = ApiVisitors::find()->where(['user_ip' => $ip])->one()) !== null ){
            return $model;
        }else {
            return $model;
        }
    }

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
        $query = ApiVisitors::find();

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
//            'id' => $this->id,
//            'user_ip' => $this->user_ip,
//            'datetime' => $this->datetime,
//            'visited' => $this->visited,
//            'last_get' => $this->last_get,
//            'status' => $this->status,
        ]);

//        $query->andFilterWhere(['like', 'user_ip', $this->user_ip])
//        ->andFilterWhere(['like', 'visited', $this->visited])
//        ->andFilterWhere(['like', 'last_get', $this->last_get])
//            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

}
