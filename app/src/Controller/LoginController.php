<?php

namespace App\Controller;

/**
 * Login Controller
 */
class LoginController extends AppController
{
    /**
     * ログイン画面/ログイン処理
     *
     * @return \Cake\Http\Response|null ログイン成功後にログインTOPに遷移する
     */
    public function index()
    {
        // if ($this->Auth->isAuthorized()) {

        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('ユーザー名またはパスワードが不正です');
        }
    }
}
