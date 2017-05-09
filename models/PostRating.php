<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_rating".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $raiting_value
 */
class PostRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'raiting_value'], 'required'],
            [['id', 'post_id'], 'integer'],
            [['user_ip'], 'string', 'max' => 255],
            [['raiting_value'], 'string', 'max' => 44],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'post_id' => Yii::t('app','Post ID'),
            'user_ip' => Yii::t('app', 'User Ip'),
            'raiting_value' => Yii::t('app','Raiting Value'),
        ];
    }
}
