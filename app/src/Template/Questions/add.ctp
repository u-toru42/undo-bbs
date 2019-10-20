<h2 class="mb-3"><i class="fas fa-pen"></i> 質問を投稿する</h2>
<!-- Formヘルパーを利用し、コントローラーと効率的にHTMLを連動させる。バリデーションエラー時のメッセージを自動で表示してくれたり、submit時のURLやリクエストメソッドを(あくまで規約に沿っていれば)明示的に書かなくてもよくなる。セキュリティ観点でもCSRF対策を行ってくれるから安心。-->
<?= $this->Form->create($question) ?>
<!-- Formヘルパーを利用し、質問内容(body)を投稿できるフォームを作成する。-->
<?= $this->Form->control('body', ['type' => 'textarea', 'label' => false, 'maxLength' => 200]) ?>
<?= $this->Form->button('投稿する', ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>
