<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('page_title', true) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="/assets/js/app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        window.appLangs = {
            users: {
                errorCredentials1: "<?= esc(lang('Validation.users.errorCredentials1'), 'js') ?>",
                errorConfirmPassword1: "<?= esc(lang('Validation.users.errorConfirmPassword1'), 'js') ?>",
                errorConfirmPassword2: "<?= esc(lang('Validation.users.errorConfirmPassword2'), 'js') ?>",
            },
        };

        $(() => {
            if (typeof window.app === "function") {
                app();
            }
        })
    </script>
    <?= $this->renderSection('scripts') ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                rbbr
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/"><?= lang('Index.title.index') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/"></a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <?php if (auth_service()->isLoggedIn()): ?>
                        <a id="linkUserLogin" href="/user/logout" class="link-offset-2 link-underline link-underline-opacity-0" aria-label=" <?= lang('Auth.title.logout') ?>">
                            <?= lang('Auth.title.logout') ?>
                        </a>
                    <?php else: ?>
                        <a id="linkUserLogin" href="/user/login" class="link-offset-2 link-underline link-underline-opacity-0" aria-label=" <?= lang('Auth.title.login') ?>">
                            <?= lang('Auth.title.login') ?>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </nav>
    <div><?= $this->renderSection('content') ?></div>
</body>

</html>
