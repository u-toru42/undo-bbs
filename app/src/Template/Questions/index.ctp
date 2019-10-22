<h2 class="mb-3"><i class="fas fa-list"></i> 質問一覧</h2>
<!-- まず、最初にコントローラーから渡された$questionをisEmpty()メソッドを利用して空かどうかの判定を行う。空の場合はmessageを表示する。-->
<?php if ($questions->isEmpty()): ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title text-center">表示できる質問がありません。</h5>
        </div>
    </div>
<!-- $questionをforeachステートメントを利用し、一覧として表示していく。foreachの中では、QuestionEntityの各プロパティを表示している。-->
<?php else: ?>
    <p><?= $this->Paginator->counter(['format' => '全{{pages}}ページ中{{page}}ページ目を表示しています']) ?></p>
    <?php foreach ($questions as $question): ?>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">
                <!-- CakePHPは自動でエスケープ処理をしないため、h()メソッドを利用し、エスケープ処理を行う。-->
                    <i class="fas fa-user-circle"></i> <?= h($question->user->nickname) ?>
                </h5>
                <!-- 質問本文はnl2br()メソッドを利用し、改行されるようにしておく。-->
                <p class="card-text"><?= nl2br(h($question->body)) ?></p>
                <p class="card-subtitle mb-2 text-muted">
                    <small><?= h($question->created) ?></small>
                    <small>
                        <i class="fas fa-comment-dots"></i> <?= $this->Number->format($question->commented_count) ?>
                    </small>
                </p>
                <!-- 本人の投稿した質問でないと、質問一覧画面の質問削除のリンクは表示されないようにする。　ログイン中のユーザーIDと質問のユーザーIDを比較し、リンクの表示制御を行う。未ログインの場合はNULLになるが、質問のユーザーIDがNULLになることはない。-->
                <?= $this->Html->link('詳細へ', ['action' => 'view', $question->id], ['class' => 'card-link']) ?>
                <?php if ($this->request->getSession()->read('Auth.User.id') === $question->user_id): ?>
                    <?= $this->Form->postLink('削除する', ['action' => 'delete', $question->id],
                        ['confirm' => '質問を削除します。よろしいですか？'], ['class' => 'card-link']) ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< 最初へ') ?>
            <?= $this->Paginator->prev('< 前へ') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('次へ >') ?>
            <?= $this->Paginator->last('最後へ >>') ?>
        </ul>
    </div>

<?php endif; ?>
