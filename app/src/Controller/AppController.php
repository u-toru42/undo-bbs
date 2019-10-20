<?php

namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 */
class AppController extends Controller
{
    /**
     * 初期化処理
     *
     * @return void
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        // 
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        // Authコンポーネントを利用し、認証処理をおこなう。各コントローラークラスの親クラスであるAppControllerクラスを修正していく。Authコンポーネントを適用することで、認証が必要な画面にはアクセスできないようにする。
        $this->loadComponent('Auth', [
            // authenticateキーではFormによる認証をおこない、認証キーはusersテーブルのusernameとpasswordカラムで照合するという設定。なお、この設定はCakePHPの標準なので、省略することも可。
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ]
                ]
            ],
            // loginActionはログイン時のアクション
            'loginAction' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            // loginRedirectはログイン時のリダイレクト先
            'loginRedirect' => [
                'controller' => 'Questions',
                'action' => 'index'
            ],
            // logoutRedirectはログアウト時のリダイレクト先
            'logoutRedirect' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            // unauthorizedRedirectは未承認時のリダイレクト先
            'unauthorizedRedirect' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            // 認証エラーの場合
            'authError' => 'ログインが必要です'
        ]);
        // allowメソッドは認証が不要なアクションを設定することができる。今回はindex()とview()アクションを指定。
        $this->Auth->allow(['display', 'index', 'view']);
    }
}