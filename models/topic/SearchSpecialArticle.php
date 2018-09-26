<?php

namespace app\models\topic;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\topic\SpecialArticle;

/**
 * SearchSpecialArticle represents the model behind the search form of `app\models\topic\SpecialArticle`.
 */
class SearchSpecialArticle extends SpecialArticle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_id', 'chapter_id', 'draft', 'recycle'], 'integer'],
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
        $query = SpecialArticle::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'special_id' => $this->special_id,
            'chapter_id' => $this->chapter_id,
        ]);

        //获取筛选条件
        $draft = (bool) Yii::$app->request->get('draft');
        $recycle = (bool) Yii::$app->request->get('recycle');

        $cond['draft'] = 0;
        if($draft){
            $cond['draft'] = 1;
        }

        $cond['recycle'] = 0;
        if($recycle && !$draft){
            $cond['recycle'] = 1;
        }
        $query->andFilterWhere($cond);


        return $dataProvider;
    }
}
