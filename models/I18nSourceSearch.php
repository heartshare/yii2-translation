<?php

namespace krok\translation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use krok\translation\models\I18nSource;

/**
 * I18nSourceSearch represents the model behind the search form about `krok\translation\models\I18nSource`.
 */
class I18nSourceSearch extends I18nSource
{
    /**
     * @var null
     */
    public $translation = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category', 'message', 'translation'], 'safe'],
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
        $query = I18nSource::find()->joinWith('i18nMessage');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
            ]
        );

        $query
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'translation', $this->translation])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
