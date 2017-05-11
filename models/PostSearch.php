<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rssnews;
use app\models\PostRatingSearch;

/**
 * PostSearch represents the model behind the search form about `app\models\rssnews`.
 */
class PostSearch extends rssnews
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['title', 'content', 'datetime', 'raiting', 'preview', 'main_link'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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

    public function getContent($content)
    {
      $content_text = preg_replace("/<img[^>]+\>/i", " ", $content);
        return  substr($content_text, 0, 200);
    }
    
    public function get_img($content)
    {
        preg_match('/<img[^>]+\>/i',$content, $matches1);
        foreach ($matches1 as $value) {
            return $value;    
        }
    }

    public function getRating()
    {
        return $this->hasMany(PostRatingSearch::className(), ['post_id' => 'id']);
    }

    public function ratingFilter($getRating)
    {
        $ratings =array();
        foreach ($getRating as $key => $value) {
            $ratings[] = $value['raiting_value'];
        }

        if(array_sum($ratings) !== 0){
            $totalRating = array_sum($ratings) / count($ratings);
        }else
        {
            $totalRating = 0;
        }

        if($totalRating >= 5)
            $totalRating = 5;

        return $totalRating;
    }


    public function search($params)
    {
        $query = rssnews::find();
        $query = joinWith('postVisitors');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => [count('post_visitors.post_id')=>SORT_DESC]],
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
            'category_id' => $this->category_id,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'raiting', $this->raiting])
            ->andFilterWhere(['like', 'main_link', $this->main_link]);

        return $dataProvider;
    }
}
