<?php

namespace greeschenko\useractivitylog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UseractivitylogSearch extends Useractivitylog
{
    public $users;
    public $useremail;
    public $created_at_period;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'type'], 'integer'],
            [['msg'], 'string'],
            [['ip'], 'string', 'max' => 255],
            [['useremail', 'created_at_period'], 'safe'],
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

        $query->joinWith(['user u']);

        // add conditions that should always apply here
        if ($this->users != '') {
            $query->where(['user_id' => $this->users]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['useremail'] = [
            'asc' => ['u.email' => SORT_ASC],
            'desc' => ['u.email' => SORT_DESC],
        ];

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

        //$query->andFilterWhere(['like', 'msg', $this->msg]);
        //
        $from = 0;
        $to = time();
        $period_list = explode(' - ', $this->created_at_period);
        if (count($period_list) == 2) {
            $from = strtotime($period_list[0]);
            $to = strtotime($period_list[1]);
        }

        $query->andFilterWhere(['like', 'u.email', $this->useremail]);
        $query->andFilterWhere(['between', 'useractivitylog.created_at', $from, $to]);

        return $dataProvider;
    }
}
