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
                    let response = JSON.parse(data);

                    if(response.success) {
                        window.location.href = '/user';
                        return;
                    }

                    if (Array.isArray(response.message)) {
                        response.message.forEach(function (item) {
                            alert(item);
                        })

                        return;
                    }

                    alert(response.message);
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