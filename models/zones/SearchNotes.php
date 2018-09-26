<?php

namespace app\models\zones;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\components\helper\Helper;

/**
 * SearchNotes represents the model behind the search form of `app\models\notes\Notes`.
 */
class SearchNotes extends Notes
{
    public $start_time;
    public $end_time;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'user_id'], 'safe'],
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
        $query = Notes::find();

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
            'user_id' => $this->user_id,
        ]);

        if(!empty($this->start_time) && !empty($this->end_time)){
            //检测时间格式
            if(Helper::checkTime($this->start_time) && Helper::checkTime($this->end_time)){
                $start_time = strtotime($this->start_time);
                $end_time = strtotime($this->end_time);
                $query->andFilterWhere(['>=', 'created_at', $start_time]);
                $query->andFilterWhere(['<=', 'created_at', $end_time]);
            }
        }

        return $dataProvider;
    }
}
