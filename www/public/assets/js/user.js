let User = (() => {
    let handleForm = () => {
        $('#user-form').submit(function (event) {
            event.preventDefault();

            let userForm = $(this).serialize();

            $.ajax({
                url: '/user/save',
                type: 'POST',
                data: userForm,
                success: function (data) {
                    let dataJson = JSON.parse(data);

                    if(dataJson.result == 'success') {
                        window.location.href = '/';
                    }
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
   User.init();
});