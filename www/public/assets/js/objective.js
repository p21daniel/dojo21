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

    let handleButtons = function () {
        $('#objective_remove_button').click(function (){
            let id = $('#objective_remove_button').val();

            $.ajax({
                url: '/objective/remove',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.href = '/objective/list';
                }
            });
        })

        $('#objective_edit_button').click(function (){
            let id = $('#objective_edit_button').val();

            $.ajax({
                url: '/objective/edit',
                type: 'POST',
                data: {
                    id: id
                },

                success: function (data) {
                    window.location.href = '/user';
                }
            });
        })
    }

    return {
        init: () => {
            handleForm();
            handleButtons();
        }
    }
})();
$(document).ready(() => {
    Objective.init();
});