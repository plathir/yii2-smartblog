<?php

namespace plathir\smartblog\frontend\helpers;

use plathir\smartblog\frontend\models\Posts;
use plathir\smartblog\common\models\Tags;
use plathir\smartblog\common\models\PostsTags;
use plathir\smartblog\common\models\PostsRating;
use \Yii;
use plathir\smartblog\frontend\models\Category;
use plathir\smartblog\frontend\models\Categorytree;
use plathir\blog\backend\blogAsset;

class PostHelper {

    public function getLatestPosts($numOfPosts) {

        $posts = Posts::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->limit($numOfPosts)
                ->all();
        $newPosts = [];
        if ($posts) {
            return $this->OwnUnpublishFilter($posts);
        } else {
            return null;
        }
    }

    public function getMostVisitedPosts($numOfPosts) {
        $posts = Posts::find()
                ->orderBy(['views' => SORT_DESC])
                ->limit($numOfPosts)
                ->all();
        if ($posts) {
            return $this->OwnUnpublishFilter($posts);
        } else {
            return null;
        }
    }

    public function getTopRated($numOfPosts) {

        $posts_rating = (new \yii\db\Query())
                ->select(['*, (rating_sum / rating_count) AS rate'])
                ->from('{{%posts_rating}}')
                ->orderBy('rate desc')
                ->limit($numOfPosts)
                ->all();

        if ($posts_rating) {
            foreach ($posts_rating as $post_rating) {
                $posts[] = Posts::findOne(['id' => $post_rating['post_id']]);
            }
            return $posts;
        } else {
            return null;
        }
    }

    public function getTopAuthors($numOfAuthors) {


        $temp_topAuthors = (new \yii\db\Query())
                ->select(['user_created as author', 'count(*) as cnt'])
                ->from('{{%posts}}')
                ->groupBy(['user_created'])
                ->limit(10)
                ->all();
        $topAuthors = [];
        foreach ($temp_topAuthors as $Author) {
            $userid = $Author['author'];
            $username = PostHelper::getUserName($userid);

            $topAuthors[] = [
                'userid' => $userid,
                'author' => $username,
                'cnt' => $Author['cnt']
            ];
        }

        if ($topAuthors) {
            return $topAuthors;
        } else {
            return null;
        }
    }

    //get username
    public function getUserName($user_id) {

        $PostsModel = new Posts();
        $userModel = new $PostsModel->module->userModel();
        return $userModel::findOne(['id' => $user_id])->{$PostsModel->module->userNameField};
    }

    public function getPostIntroImage($id, $view = null) {
        $post = Posts::find()
                ->where(['id' => $id])
                ->one();
        if ($post) {
            if ($post->post_image != null) {
                $key = $post->module->KeyFolder;
                $key_folder = $$key;
                return $post->module->ImagePathPreview . '/' . $key_folder . '/' . $post->post_image;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getPostFullImage($id, $view = null) {
        $post = Posts::find()
                ->where(['id' => $id])
                ->one();
        if ($post) {
            if ($post->full_image != null) {
                $key = $post->module->KeyFolder;
                $key_folder = $$key;
                return $post->module->ImagePathPreview . '/' . $key_folder . '/' . $post->full_image;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Get list of posts by tags separated by comma 
     * @param type $tag (e.g : tag1,tag2,tag3 )
     * @return type
     */
    public function getPostsbyTags($tag) {
        $tagsArray = explode(",", $tag);
        $posts = [];
        $listPostsIDs = [];
        foreach ($tagsArray as $tagItem) {
            $newPosts = $this->getPostsbyTag($tagItem);
            foreach ($newPosts as $post) {
                if (!empty($posts)) {
                    if (array_search($post->id, $listPostsIDs) === false) {
                        $listPostsIDs[] = $post->id;
                        $posts[] = $post;
                    }
                } else {
                    $listPostsIDs[] = $post->id;
                    $posts[] = $post;
                }
            }
        }
        return $posts;
    }

    /**
     * Get Posts by one tag 
     * @param type $tag (e.g : tag1 )
     * @return type
     */
    public function getPostsbyTag($tag) {
        $tag_id = Tags::find()->select(['id'])->where(['name' => $tag])->one();
        $tags = PostsTags::find()->select(['post_id'])
                        ->where(['tag_id' => $tag_id->id])
                        ->groupBy(['post_id'])->all();
        foreach ($tags as $tag) {
            $tags_array[] = $tag->post_id;
        }
        $posts = Posts::find()->where(['in', 'id', $tags_array])
                ->andWhere(['publish' => 1])
                ->all();
        return $posts;
    }

    /**
     * Find similar Posts by tags
     * @param type $id
     */
    public function findSimilarPosts($id) {
        $model = Posts::findOne($id);
        $posts = $this->getPostsbyTags($model->tags);
        $posts = $this->OwnUnpublishFilter($posts);
        $newPosts = [];
        if ($posts) {
            foreach ($posts as $key => $post) {
                if ($post->id != $id) {
                    $newPosts[] = $post;
                }
            }
        }
        return $newPosts;
    }

    public function OwnUnpublishFilter($posts) {
        $newPosts = [];

        if ($posts) {
            $usr = [];
            if (Yii::$app->user->identity) {
                $usr = Yii::$app->user->identity->id;
            }
            foreach ($posts as $post) {
                if ($post->publish == 1) {
                    $newPosts[] = $post;
                } else {
                    if ((\yii::$app->user->can('BlogUpdateOwnPost', ['post' => $post])) || (\yii::$app->user->can('BlogUpdatePost'))) {
                        $newPosts[] = $post;
                    }
                }
            }
            return $newPosts;
        }
    }

    public function getPostsbyCategory($id) {

        $posts = Posts::find()->where(['=', 'category', $id])
                ->andWhere(['publish' => 1])
                ->all();
        foreach ($posts as $post) {
            //    echo $post->id. 'Category :', $post->category.'<br>';
        }
        //   die();
        return $posts;
    }

    public function getTopCategories($numOfCategories) {

        $topCategories = [];
        $temp_topCategories = (new \yii\db\Query())
                ->select(['category', 'count(*) as cnt', '{{%categories}}.*'])
                ->join('LEFT JOIN', '{{%categories}}', '{{%categories}}.id = category')
                ->from('{{%posts}}')
                ->where(['{{%posts}}.publish' => 1])
                ->groupBy(['category'])
                ->orderBy('cnt desc')
                ->limit($numOfCategories)
                ->all();

        foreach ($temp_topCategories as $Category) {
            $category_id = $Category['category'];
            $cat = Categorytree::findOne($category_id);
            $topCategories[] = [
                'image' => $cat->ImageUrl,
                'category' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->path,
                'path' => $cat->path,
                'cnt' => $Category['cnt']
            ];
        }

        if ($topCategories) {
            return $topCategories;
        } else {
            return null;
        }
    }

    public function getCategoriesWithSubCategories($CategoryLevel, $CategoryID = '') {
        $Categories = [];

        if (!$CategoryID) {
            $Categories = $this->getCategoriesByLevel($CategoryLevel);
        } else {
            $Categories = $this->getSubCategories($CategoryID);
        }
        return $Categories;
    }

    public function getCategoriesByLevel($CategoryLevel) {
        $Categories = '';

        $Categories = Categorytree::find()->where(['=', 'lvl', $CategoryLevel])
                ->andWhere(['=', 'active', '1'])
                ->all();

        return $Categories;
    }

    public function getSubCategories($categoryID) {

        $Categ = Categorytree::findOne($categoryID);
        $SubCat = $Categ->childrens;
        return $SubCat;
    }

    public function getCategoryPosts($CategoryID) {

        return $Posts;
    }
    public function getBlogNoImage($id, $view = null) {
        $bundle = blogAsset::register($view);
        return $bundle->baseUrl . '/img/no_photo.png';
    }
    
}
