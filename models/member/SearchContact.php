<?php

namespace app\models\member;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\member\Contact;

/**
 * SearchContact represents the model behind the search form of `app\models\member\Contact`.
 */
class SearchContact extends Contact
{
    public $username;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'string'],
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
        $query = Contact::find();

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

        if( !empty($this->username) ){
            $user_id = User::find()->where(['username'=> $this->username])->select(['id'])->scalar();
            // grid filtering conditions
            $query->andFilterWhere(['user_id' => $user_id]);
        }


        return $dataProvider;
    }
}
