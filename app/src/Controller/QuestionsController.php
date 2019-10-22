<?php

namespace App\Controller;

/**
 * Questions Controller
 */
class QuestionsController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        parent::initialize();
        // loadModel()メソッドを利用することで、Commentsモデルの利用が可能となる。
        $this->loadModel('Comments');
    }

    /**
     * 質問一覧画面
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // ここに処理を書いていく
        // paginateメソッドはページング(ページ分割)された情報を取得するメソッド。
        $questions = $this->paginate($this->Questions->findQuestionsWithCommentedCount()->contain(['Users']), [
            'order' => ['Questions.id' => 'DESC']
        ]);

        $this->set(compact('questions'));
    }

    /**
     * 質問投稿画面/質問投稿処理
     *
     * @return \Cake\Http\Response|null 質問投稿後に質問一覧画面へ遷移する
     */
    // add()アクションはGETメソッドでアクセスされた時はフォーム画面を表示し、POSTメソッドでアクセスされた時(=フォームをsubmitした時)はフォームの内容をデータベースに保存する。
    public function add()
    {
        // フォーム画面を表示させるにはEntityオブジェクトを作成し、それをビューに渡す。
        $question = $this->Questions->newEntity();

        if ($this->request->is('post')) {
            // フォームの内容を取得、patchEntity()というメソッドを使い、既存のEntityにマージする。
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            // ユーザーIDの値を動的に行う。
            $question->user_id = $this->Auth->user('id');

            if ($this->Questions->save($question)) {
                // Flashコンポーネントは、フォームの処理結果を一回だけ通知するような時に使う。
                $this->Flash->success('質問を投稿しました');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('質問の投稿に失敗しました');
        }

        $this->set(compact('question'));
    }

    /**
     * 質問詳細画面
     *
     * @param int $id 質問ID
     * @return void
     */
    public function view(int $id)
    {
        // 最初にパスで指定した質問IDの情報を取得する。get()メソッドはfind()メソッドとは異なり、quesitonテーブルに存在しないIDを指定した場合は404エラーとなる。contain()メソッド質問情報と併せて、ユーザー情報を取得することができる。
        $question = $this->Questions->get($id, ['contain' => ['Users']]);

        $comments = $this
            ->Comments
            ->find()
            ->where(['Comments.question_id' => $id])
            ->contain(['Users'])
            ->orderAsc('Comments.id')
            // コメントに関しては1つの質問につき100件という制限を設計時に設けたため、find()->all()で全件取得する。
            ->all();

        $newComment = $this->Comments->newEntity(); // CommentのEntityオブジェクトを生成し、ビューに渡す。ビューは回答一覧を表示しているsectionタグの直下に回答投稿フォームを設置する。

        $this->set(compact('question', 'comments', 'newComment'));
    }

    /**
     * 質問削除処理
     *
     * @param int $id 質問ID
     * @return \Cake\Http\Response|null 質問削除後に質問一覧画面へ遷移する
     */
    public function delete(int $id)
    {
        // まず始めにallowMethod()でPOSTだけのアクセスを受け入れるようにする。その後、指定されたIDの質問をget()メソッドで取得する。質問が存在しない場合は404エラーとなる。そして、取得した質問をdelete()メソッドで削除している。
        $this->request->allowMethod(['post']);
        // 質問及びコメントの削除は本人しか削除できないようにする。
        $question = $this->Questions->get($id);
        if ($question->user_id !== $this->Auth->user('id')) {
            $this->Flash->error('他のユーザーの質問を削除することは出来ません');

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Questions->delete($question)) {
            $this->Flash->success('質問を削除しました');
        } else {
            $this->Flash->error('質問の削除に失敗しました');
        }

        return $this->redirect(['action' => 'index']);
    }
}
