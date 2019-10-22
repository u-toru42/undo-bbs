<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Comments Controller
 */
class CommentsController extends AppController
{
    const COMMENT_UPPER_LIMIT = 100;

    /**
     * {@inheritdoc}
     */
    // CommentsControllerクラスのadd()アクションはQuestionsControllerクラスのaddアクションとは異なり、GETでアクセスする必要は無い。そのため、beforeFilter()メソッド内でallowMethod()を利用して、アクセス可能なHTTPのリクエストメソッドを限定する。
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->request->allowMethod(['post']);
    }

    /**
     * コメント投稿処理
     *
     * @return \Cake\Http\Response|null コメント投稿後に質問詳細画面へ遷移する
     */
    public function add()
    {
        // count()メソッドを利用し、件数のチェックを行う。
        $comment = $this->Comments->newEntity($this->request->getData());
        $count = $this->Comments
            ->find()
            ->where(['question_id' => $comment->question_id])
            ->count();

        if ($count >= self::COMMENT_UPPER_LIMIT) {
            $this->Flash->error('コメントの上限数に達しました');

            return $this->redirect(['controller' => 'Questions', 'action' => 'view', $comment->question_id]);
        }
        // useridの値をログイン中のユーザーIDに設定。
        $comment->user_id = $this->Auth->user('id');
        if ($this->Comments->save($comment)) {
            $this->Flash->success('コメントを投稿しました');
        } else {
            $this->Flash->error('コメントの投稿に失敗しました');
        }

        return $this->redirect(['controller' => 'Questions', 'action' => 'view', $comment->question_id]);
    }

    /**
     * コメント削除処理
     *
     * @param int $id コメントID
     * @return \Cake\Http\Response|null コメント削除後に質問詳細画面へ遷移する
     */
    public function delete(int $id)
    {
        // まず始めにallowMethod()でPOSTだけのアクセスを受け入れるようにする。その後、指定されたIDの質問をget()メソッドで取得する。質問が存在しない場合は404エラーとなる。そして、取得した質問をdelete()メソッドで削除している。質問欄も同様。質問及びコメントの削除は本人しか削除できないようにする。
        $comment = $this->Comments->get($id);
        $questionId = $Comment->question_id;
        if ($comment->user_id !== $this->Auth->user('id')) {
            $this->Flash->error('他のユーザーのコメントを削除することはできません');

            return $this->redirect(['controller' => 'Questions', 'action' => 'view', $questionId]);
        }

        if ($this->Comments->delete($comment)) {
            $this->Flash->success('コメントを削除しました');
        } else {
            $this->Flash->error('コメントの削除に失敗しました');
        }

        return $this->redirect(['controller' => 'Questions', 'action' => 'view', $questionId]);
    }
}
