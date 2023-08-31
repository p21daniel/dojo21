let Login = (() => {
    let validateForm = () => {

    }

    let handleForm = () => {
        $('#login-form').submit(function (event) {
            event.preventDefault();
            let loginForm = $(this).serialize();

            validateForm();

            $.ajax({
                url: '/user/login',
                type: 'POST',
                data: loginForm,
                success: function (data) {
                    window.location.href = '/user';
                }
            });
        });
    }

    return {
        init: () => {
            handleForm();
        }
    }
})();
$(document).ready(() => {
   Login.init();
});