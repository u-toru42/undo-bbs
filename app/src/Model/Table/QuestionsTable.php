<?php

namespace App\Model\Table;

use Cake\ORM\Table;
// バリデーションルールを定義する。
use Cake\Validation\Validator;

/**
 * Questions Model
 */
class QuestionsTable extends Table
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('questions'); // 使用されるテーブル名
        $this->setDisplayField('id'); // list形式でデータ取得される際に使用されるカラム
        $this->setPrimaryKey('id'); // プライマリキーとなるカラム名

        $this->addBehavior('Timestamp'); // created及びmodifiedカラムを自動設定する

        $this->hasMany('Comments', [
            'foreignKey' => 'question_id'
        ]);
        // 質問一覧を表示する際に、どのユーザーがその質問やコメントを投稿していたかがわかるようにする。アソシエーションを利用して、モデル同士を関連付ける。
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * バリデーションルールの定義
     *
     * @param \Cake\Validation\Validator $validator バリデーションインスタンス
     * @return \Cake\Validation\Validator バリデーションインスタンス
     */
    // バリデーションルールはvalidationDefault()メソッドに定義する。
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id', 'IDが不正です')
            ->allowEmpty('id', 'create', 'IDが不正です');

        //bodyのバリデーションルールは1.scalar()値であること。単一のデータを示す。PHPにはboolean型、integer型、double型、string型のこと。
        $validator
            ->scalar('body', '質問内容が不正です')
            // 2.requirePresence()はキーが存在していること。第2引数にcreateを指定することで、新規登録時のみルールが適用される。
            ->requirePresence('body', 'create', '質問内容が不正です')
            // 3.notEmpty()、値が空でないこと。
            ->notEmpty('body', '質問内容は必ず入力してください')
            // 4.maxLength()、指定した文字列以内であること。今回は140文字という設定。
            ->maxLength('body', 140, '質問内容は140字以内で入力してください');

        return $validator;
    }

    /**
     * 回答付きの質問一覧を取得する
     *
     * @return \Cake\ORM\Query 回答付きの質問一覧クエリ
     */
    public function findQuestionsWithCommentedCount()
    {
        $query = $this->find();
        $query
            ->select(['commented_count' => $query->func()->count('Comments.id')])
            ->leftJoinWith('Comments')
            ->group(['Questions.id'])
            ->enableAutoFields(true);

        return $query;
    }
}
