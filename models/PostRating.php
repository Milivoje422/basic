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
            [['id', 'post_id', 'raiting_value'], 'required'],
            [['id', 'post_id'], 'integer'],
            [['raiting_value'], 'string', 'max' => 44],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'raiting_value' => 'Raiting Value',
        ];
    }
}
