<?php

namespace app\models;

use Yii;
use app\models\Posts;

/**
 * This is the model class for table "post_visitors".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $user_ip
 */
class PostVisitors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_visitors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'user_ip'], 'required'],
            [['post_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_ip'], 'string', 'max' => 44],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => Yii::t('app','Post ID'),
            'user_ip' => Yii::t('app','User Ip'),
            'created_at' => Yii::t('app','Created Time'),
        ];
    }

    public function getPosts()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    public function getAll(){
        return PostVisitors::find()->where(['user_ip' => $_SERVER['REMOTE_ADDR']])->all();
    }
}
