<?= $this->extend('layouts/frontend') ?>

<?php
/** @var array<int, array<string, mixed>> $messages */
/** @var array{headerName: string, tokenName: string, hash: string} $csrf */
?>

<?= $this->section('scripts') ?>
<script>
    window.appCsrf = {
        headerName: "<?= esc($csrf['headerName'], 'js') ?>",
        tokenName: "<?= esc($csrf['tokenName'], 'js') ?>",
        hash: "<?= esc($csrf['hash'], 'js') ?>",
    };
    window.appLangs.message = {
        errorEmptyContent: "<?= esc(lang('Message.error.emptyContent'), 'js') ?>",
    };
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4"><?= lang('Message.title.list') ?></h5>

                    <?php if ($messages === []): ?>
                        <div class="text-secondary"><?= lang('Message.notice.empty') ?></div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($messages as $message): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between gap-3">
                                        <strong><?= esc($message['account']) ?></strong>
                                        <small class="text-secondary text-nowrap"><?= esc($message['created_at']) ?></small>
                                    </div>
                                    <div class="mt-2"><?= nl2br(esc($message['content'])) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4"><?= lang('Message.title.board') ?></h5>

                    <?php if (auth_service()->isLoggedIn()): ?>
                        <form id="formMessage" method="post" action="/api/message/create">
                            <div>
                                <label class="form-label"><?= lang('Message.content') ?></label>
                                <textarea name="content" class="form-control" rows="4" maxlength="1000"></textarea>
                            </div>
                            <div class="alert alert-danger mt-3" role="alert" id="errorMsg"></div>
                            <div class="mt-3 d-grid d-sm-flex justify-content-sm-end">
                                <button type="submit" class="btn btn-primary"><?= lang('Common.button.submit') ?></button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0" role="alert">
                            <?= lang('Message.notice.loginRequired') ?>
                            <a href="/user/login" class="alert-link"><?= lang('Auth.title.login') ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
