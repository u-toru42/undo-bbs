<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 */
class User extends Entity
{
    /**
     * @var array 各プロパティが一括代入できるかどうかの情報
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'nickname' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * @var array JSONレスポンスなどで非表示にするプロパティ
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * パスワードをハッシュ化する
     *
     * @param string $value 生パスワード
     * @return bool|string ハッシュ化されたパスワード     */
    // 　ハッシュ化とは...元のデータから一定の計算手順に従ってハッシュ値と呼ばれる規則性のない固定長の値を求め、その値によって元のデータを書き換えること。ハッシュ化のロジックを自前で実装するのは危険なため、CakePHPのハッシュ用のメソッドを利用する。
    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }
}
