<?php if (!$this->request->getSession()->read('Auth.User.id')): ?>
    <?php $this->start('sub-header'); ?>
        <section class="sub-header">
            <div class="container col-md-7 col-12">
                <div class="jumbotron mt-4">
                    <p class="display-4">ようこそ！</p>
                    <p class="lead">日々のちょっとした運動に関する質問ができます。<br>気軽に相談してみましょう。</p>
                    <hr class="my-4">
                    <p>さっそくはじめてみましょう。</p>
                    <?= $this->Html->link('ユーザー登録',
                        ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-success btn-lg']) ?>
                </div>
            </div>
        </section>
    <?php $this->end(); ?>
<?php endif; ?>
<h2 class="text-center mb-4">ちょこっと運動広場って？</h2>
<div class="row text-center">
    <div class="col-sm">
        <div class="circle-div mb-3">
            <span class="circle-number">1</span>
        </div>
        <h3><i class="fa fa-flag"></i> 相談</h3>
        <p>ちょこっと運動広場は、気軽にちょっとした運動の相談ができます。</p>
    </div>
    <div class="col-sm">
        <div class="circle-div mb-3">
            <span class="circle-number">2</span>
        </div>
        <h3><i class="fas fa-comments"></i> コメント</h3>
        <p>おすすめの運動のコメントがつきます。</p>
    </div>
    <div class="col-sm">
        <div class="circle-div mb-3">
            <span class="circle-number">3</span>
        </div>
        <h3><i class="fas fa-running"></i> Let's do it!</h3>
        <p>コメントを読んで、まずは1回からでも試してみましょう！</p>
    </div>
</div>
