<?php

namespace app\models\blog;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\blog\Article;

/**
 * SearchArticle represents the model behind the search form of `app\models\blog\Article`.
 */
class SearchArticle extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'draft', 'recycle'], 'integer'],
            [['title'], 'string'],
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
        $query = Article::find();

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



        // grid filtering conditions
        $query->andFilterWhere([
            'category_id' => $this->category_id,
        ]);


        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->andFilterWhere($cond);

        return $dataProvider;
    }
}
