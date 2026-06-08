<?= $this->extend('layouts/frontend') ?>

<?php /** @var array{headerName: string, tokenName: string, hash: string} $csrf */ ?>

<?= $this->section('scripts') ?>
<script>
    window.appCsrf = {
        headerName: "<?= esc($csrf['headerName'], 'js') ?>",
        tokenName: "<?= esc($csrf['tokenName'], 'js') ?>",
        hash: "<?= esc($csrf['hash'], 'js') ?>",
    };
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card mt-5" style="width: 320px; margin: auto;">
    <div class="card-body">
        <h5 class="card-title text-center my-4"><?= lang('Auth.title.login') ?></h5>
        <form method="post" action="/api/user/login" id="formLogin">
            <div>
                <label class="form-label"><?= lang('Auth.account') ?></label>
                <input type="text" name="account" class="form-control" autocomplete="username">
            </div>
            <div class="mt-2">
                <label class="form-label"><?= lang('Auth.password') ?></label>
                <input type="password" name="password" class="form-control" autocomplete="current-password">
            </div>
            <div class="alert alert-danger mt-3" role="alert" id="errorMsg"></div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn btn-primary"><?= lang('Common.button.login') ?></button>
            </div>
        </form>
        <div class="d-flex justify-content-between mt-3">
            <a href="/user/register" class="link-offset-2 link-underline link-underline-opacity-0"><?= lang('Auth.title.register') ?></a>
            <!-- <a href="#" class="card-link">Another link</a> -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>
