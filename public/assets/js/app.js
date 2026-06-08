window.app = () => {
    let userLogin = () => {
        let init = () => {
            bindEvent();
        };
        let bindEvent = () => {
            errorMsg('');

            $('#linkUserLogin').hide();

            let form = $('#formLogin');
            form.on('submit', function (e) {
                try {
                    e.preventDefault();
                    errorMsg('');

                    const data = transfromData(this);
                    validUser(data);

                    $.ajax({
                        url: '/api/user/login',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            if (response.success === true) {
                                alert(response.message);
                                window.location.reload();
                            }
                        },
                        error: function (xhr) {
                            let response = xhr.responseJSON;
                            if (response && !response.success) {
                                errorMsg(response.message);
                            }
                        },
                    });
                } catch (e) {
                    errorMsg(e);
                }
            }).on('input change', ':input', function () {
                try {
                    const data = transfromData(form);

                    checkButtonFormSubmit(form, validUser(data));
                } catch (e) {
                    checkButtonFormSubmit(form, false);
                }
            });
            checkButtonFormSubmit(form, false);
        };
        init();
    };
    let userRegister = () => {
        let init = () => {
            bindEvent();
        };
        let bindEvent = () => {
            errorMsg('');

            let form = $('#formRegister');
            form.on('submit', function (e) {
                try {
                    e.preventDefault();
                    errorMsg('');

                    const data = transfromData(this);
                    validUser(data);
                    validUserPassword(data);

                    $.ajax({
                        url: '/api/user/register',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            if (response.success === true) {
                                alert(response.message);
                                window.location.reload();
                            }
                        },
                        error: function (xhr) {
                            let response = xhr.responseJSON;
                            if (response && !response.success) {
                                errorMsg(response.message);
                            }
                        },
                    });
                } catch (e) {
                    errorMsg(e);
                }
            }).on('input change', ':input', function () {
                try {
                    const data = transfromData(form);

                    checkButtonFormSubmit(form, validUser(data));
                    checkButtonFormSubmit(form, validUserPassword(data));
                } catch (e) {
                    checkButtonFormSubmit(form, false);
                }
            });
            checkButtonFormSubmit(form, false);
        };
        init();
    };
    let transfromData = (e) => {
        const formArray = $(e).serializeArray();
        const data = {};

        $.each(formArray, function (_, field) {
            data[field.name] = field.value;
        });
        return data;
    };
    let validUser = (data) => {
        if (typeof data?.account === 'undefined' || data?.account === '') {
            throw `${window.appLangs.users.errorCredentials1}(1)`;
        }
        if (typeof data?.password === 'undefined' || data?.password === '') {
            throw `${window.appLangs.users.errorCredentials1}(2)`;
        }
        return true;
    };
    let validUserPassword = (data) => {
        if (typeof data?.confirmPassword === 'undefined' || data?.confirmPassword === '') {
            throw `${window.appLangs.users.errorConfirmPassword1}`;
        }
        if (data?.password !== data?.confirmPassword) {
            throw `${window.appLangs.users.errorConfirmPassword2}`;
        }
        return true;
    };
    let checkButtonFormSubmit = (e, hide) => {
        $("button[type='submit']", e).attr('disabled', !hide);
    };
    let errorMsg = (msg) => {
        $('#errorMsg')[msg !== '' ? 'show' : 'hide']().html(msg);
    };
    let init = () => {
        let pathname = window.location.pathname;
        if (pathname === '/user/login') {
            userLogin();
        }
        if (pathname === '/user/register') {
            userRegister();
        }
    };
    init();
};
