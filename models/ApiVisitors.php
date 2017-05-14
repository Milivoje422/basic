<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

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
            return false;
        }
    }
}
