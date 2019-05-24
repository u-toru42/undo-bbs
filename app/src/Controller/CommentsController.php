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
        $comment = $this->Comments->newEntity($this->request->getData());
        $count = $this->Comments
            ->find()
            ->where(['question_id' => $comment->question_id])
            ->count();

        if ($count >= self::COMMENT_UPPER_LIMIT) {
            $this->Flash->error('コメントの上限数に達しました');

            return $this->redirect(['controller' => 'Questions', 'action' => 'view', $comment->question_id]);
        }

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
        $Comment = $this->Comments->get($id);
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
