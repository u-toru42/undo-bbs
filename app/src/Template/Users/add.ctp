<h2 class="mb-3"><i class="fas fa-user"></i> ユーザー登録</h2>
<!-- フィールド名がpasswordの場合はinputタグが自動でtype="password" になる。-->
<?= $this->Form->create($user) ?>
<?= $this->Form->control('username', ['label' => 'ユーザー名 *50文字以内', 'maxLength' => 50]) ?>
<?= $this->Form->control('password', ['label' => 'パスワード *英語と数字の両方を使って50文字以内', 'value' => '', 'maxLength' => 50]); ?>
<?= $this->Form->control('password_confirm', ['label' => 'パスワード確認用', 'value' => '', 'required' => true, 'type' => 'password', 'maxLength' => 50]) ?>
<?= $this->Form->control('nickname', ['label' => 'ニックネーム *50文字以内', 'maxLength' => 50]) ?>
<?= $this->Form->button('登録する', ['class' => 'btn btn-success mb-5']) ?>
<?= $this->Form->end() ?>