<?php

namespace common\modules\gallery\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\gallery\models\Pictures;

/**
 * PicturesSearch represents the model behind the search form of `common\modules\gallery\models\Pictures`.
 */
class PicturesSearch extends Pictures
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['author', 'pic_heading', 'pic_category', 'upload_date', 'status', 'extension'], 'safe'],
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
        $query = Pictures::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>
            [
                'pageSize' => 10,
            ]
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
            'upload_date' => $this->upload_date,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'pic_heading', $this->pic_heading])
            ->andFilterWhere(['like', 'pic_category', $this->pic_category])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
