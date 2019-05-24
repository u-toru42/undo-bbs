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
        $this->loadModel('Comments');
    }

    /**
     * 質問一覧画面
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
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
    public function add()
    {
        $question = $this->Questions->newEntity();

        if ($this->request->is('post')) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());

            $question->user_id = $this->Auth->user('id');

            if ($this->Questions->save($question)) {
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
        $question = $this->Questions->get($id, ['contain' => ['Users']]);

        $comments = $this
            ->Comments
            ->find()
            ->where(['Comments.question_id' => $id])
            ->contain(['Users'])
            ->orderAsc('Comments.id')
            ->all();

        $newComment = $this->Comments->newEntity();

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
        $this->request->allowMethod(['post']);

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
