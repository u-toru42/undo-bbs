<h2 class="mb-3"><i class="fas fa-flag"></i> 質問</h2>

<section class="question">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-user-circle"></i> <?= h($question->user->nickname) ?>
            </h5>
            <p class="card-text"><?= nl2br(h($question->body)) ?></p>
            <p class="card-subtitle mb-2 text-muted">
                <small><?= h($question->created) ?></small>
                <small><i class="fas fa-comment-dots"></i> <?= $this->Number->format($comments->count()) ?></small>
            </p>
        </div>
    </div>
</section>

<section class="comment mb-4">
    <?php if ($comments->isEmpty()): ?>
        <div class="card w-75 mb-2 ml-auto">
            <div class="card-body">
                <h5 class="card-title text-center">コメントはまだありません。</h5>
            </div>
        </div>
    <?php else: ?>
        <div class="w-75 ml-auto">
            <h5><i class="fas fa-reply"></i> コメント</h5>
        </div>
        <?php foreach ($comments as $comment): ?>
            <div class="card w-75 mb-2 ml-auto">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-circle"></i> <?= h($comment->user->nickname) ?></h5>
                    <p class="card-text"><?= nl2br(h($comment->body)) ?></p>
                    <p class="card-subtitle mb-2 text-muted">
                        <small><?= h($comment->created) ?></small>
                        <!-- ログイン中のユーザーIDと書き込むIDを比較して、リンクの表示制御を行う。-->
                        <?php if ($this->request->getSession()->read('Auth.User.id') === $comment->user_id): ?>
                            <?= $this->Form->postLink('削除する', ['controller' => 'Comments', 'action' => 'delete', $comment->id],
                                ['confirm' => 'コメントを削除します。よろしいですか？'], ['class' => 'card-link']) ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
<!-- コメントは100件以上は表示できないようにする。-->
<section class="comment-post mb-5">
    <h2 class="mb-3"><i class="fas fa-comment-dots"></i> コメントする</h2>
    <?php if ($this->request->getSession()->read('Auth.User.id')): ?>
        <?php if ($comments->count() >= \App\Controller\CommentsController::COMMENT_UPPER_LIMIT): ?>
            <p class="text-center">コメント数が上限に達しているためこれ以上コメントすることはできません</p>
        <?php else: ?>
        <!-- ログイン中のユーザーのみ表示されるようにする。-->
            <?= $this->Form->create($newComment, ['url' => '/comments/add']) ?>
            <?php
            echo $this->Form->control('body', [
                'type' => 'textarea',
                'label' => false,
                'value' => '',
                'maxLength' => 200
            ]);
            echo $this->Form->hidden('question_id', ['value' => $question->id]);
            ?>
            <?= $this->Form->button('投稿する', ['class' => 'btn btn-warning']) ?>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    <?php else: ?>
        <p>コメントするには<?= $this->Html->link('ログイン', ['controller' => 'Login', 'action' => 'index']) ?>が必要です</p>
    <?php endif; ?>
</section>
