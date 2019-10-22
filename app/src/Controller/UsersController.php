<?php

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add']);
    }

    /**
     * ユーザー登録画面/ユーザー登録処理
     *
     * @return \Cake\Http\Response|null ユーザー登録後にログイン画面へ遷移する
     */
    public function add()
    {
        // ログイン中のユーザー情報はAuthコンポーネントのuser()メソッドで取得できる。
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('ユーザーの登録が完了しました');

                return $this->redirect(['controller' => 'login', 'action' => 'index']);
            }
            $this->Flash->error('ユーザーの登録に失敗しました');
        }
        $this->set(compact('user'));
    }

    /**
     * ユーザー編集画面/ユーザー情報更新画面
     *
     * @return \Cake\Http\Response|null ユーザー情報更新後に質問一覧画面へ遷移する
     */
    public function edit()
    {
        // ログイン中のユーザー情報はAuthコンポーネントのuser()メソッドで取得できる。今回は引数に取得したいキーを指定できるため、idを指定して、ユーザーのEntity情報を更新する。その後、save()メソッドで更新する。save()メソッドが新規登録(insert)をするか、更新(update)をするかはEntityのisNew()メソッドの戻り値によって決まる。先のget()メソッドの場合はisNew()メソッドがfalseになるため、ここでは更新処理が行われる。
        $user = $this->Users->get($this->Auth->user('id'));
        if ($this->request->is('put')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Auth->setUser($user->toArray());

                $this->Flash->success('ユーザー情報を更新しました');

                return $this->redirect(['controller' => 'Questions', 'action' => 'index']);
            }
            // 更新処理が成功した後は、ログイン時にセッションに書き込んだユーザー情報を更新する。最後は、質問一覧画面にリダイレクトさせる。
            $this->Flash->error('ユーザー情報の更新に失敗しました');
        }
        $this->set(compact('user'));
    }

    /**
     * パスワード更新画面/パスワード更新処理
     *
     * @return \Cake\Http\Response|null パスワード更新後にユーザー編集画面に遷移する
     */
    public function password()
    {
        // パスワード更新画面はパスワードを入力するだけで、現状のユーザー情報をセットする必要がないため、newEntity()メソッドを利用する。フォームのsubmit時のリクエストメソッドはPOSTメソッドになる。
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->get($this->Auth->user('id'));

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Auth->setUser($user->toArray());

                $this->Flash->success('パスワードを更新しました');

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error('パスワードの更新に失敗しました');
        }
        $this->set(compact('user'));
    }
}
