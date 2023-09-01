let Objective = (() => {
    let handleForm = () => {
        $('#objective-form').submit(function (event) {
            let userForm = $(this).serialize();
            event.preventDefault();
            $.ajax({
                url: '/objective/save',
                type: 'POST',
                data: userForm,
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
    Objective.init();
});