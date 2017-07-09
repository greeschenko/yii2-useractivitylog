<?php

namespace greeschenko\useractivitylog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UseractivitylogSearch extends Useractivitylog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'type'], 'integer'],
            [['msg'], 'string'],
            [['ip'], 'string', 'max' => 255],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Useractivitylog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orderBy('created_at DESC');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'ip' => $this->ip,
            //'msg' => $this->msg,
            'created_at' => $this->created_at,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'msg', $this->msg]);

        return $dataProvider;
    }
}
