<?php

namespace plathir\smartblog\backend\models\search;

use \plathir\smartblog\backend\models\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Posts_s represents the model behind the search form about `app\models\Posts`.
 */
class Category_s extends Category {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'active'], 'integer'],
            [['name', 'description'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
         
                $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
        ]);
                
        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
