<?php

namespace app\models\topic;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchSpecial represents the model behind the search form of `app\models\topic\Special`.
 */
class SearchChapter extends Chapter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_id'], 'string'],
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
    public function search($params)
    {
        $query = Chapter::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['special_id' => $this->special_id]);

        return $dataProvider;
    }
}
