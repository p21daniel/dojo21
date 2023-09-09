let Login = (() => {
    let handleForm = function () {
        $('#login-form').submit(function (event) {
            event.preventDefault();

            let loginForm = $(this).serialize();

            $.ajax({
                url: '/user/login',
                type: 'POST',
                data: loginForm,
                success: function (data) {
                    let response = JSON.parse(data);

                    if(response.success) {
                        window.location.href = '/user';
                        return;
                    }

                    Modal.message(response)
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