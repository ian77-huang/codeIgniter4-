<?= $this->extend('layouts/frontend') ?>

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
        <h5 class="card-title text-center my-4"><?= lang('Auth.title.register') ?></h5>
        <form method="post" action="/api/user/register" id="formRegister">
            <div>
                <label class="form-label"><?= lang("Auth.account") ?></label>
                <input type="text" name="account" class="form-control" autocomplete="username">
            </div>
            <div class="mt-2">
                <label class="form-label"><?= lang('Auth.password') ?></label>
                <input type="password" name="password" autocomplete="new-password" class="form-control">
            </div>
            <div class="mt-2">
                <label class="form-label"><?= lang('Auth.confirmPassword') ?></label>
                <input type="password" name="confirmPassword" autocomplete="new-password" class="form-control">
            </div>
            <div class="alert alert-danger mt-3" role="alert" id="errorMsg"></div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn btn-primary"><?= lang('Common.button.register') ?></button>
            </div>
        </form>
        <div class="d-flex justify-content-between mt-3">
            <a href="/user/login" class="link-offset-2 link-underline link-underline-opacity-0"><?= lang('Auth.title.login') ?></a>
            <!-- <a href=" #" class="card-link">Another link</a> -->
        </div>
    </div>
</div>
<?= $this->endSection() ?>
