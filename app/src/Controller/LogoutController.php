<?php

namespace App\Controller;

/**
 * Logout Controller
 */
class LogoutController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->deny(['index']);
    }

    /**
     * ログアウト処理
     *
     * @return \Cake\Http\Response|null ログアウト後にログインTOPに遷移する
     */
    public function index()
    {
        $this->Flash->success('ログアウトしました');
        // logoutメソッドは戻り値としてログアウト時のリダイレクト情報を返すことを利用し、ログイン画面に遷移する。
        return $this->redirect($this->Auth->logout());
    }
}