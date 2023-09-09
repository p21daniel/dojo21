let Objective = (() => {
    let handleForm = function (){
        $('#objective-form').submit(function (event) {
            let userForm = $(this).serialize();

            event.preventDefault();

            $.ajax({
                url: '/objective/save',
                type: 'POST',
                data: userForm,
                success: function (data) {
                    let response = JSON.parse(data);

                    if(response.success) {
                        window.location.href = '/objective/list';
                        return;
                    }

                    Modal.message(response)
                }
            });
        });
    }

    let handleButtons = function (){
        $(document).on('click', '#objective_remove_button', function (){
            let id = $(this).val();

            $.ajax({
                url: '/objective/remove',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (data) {
                    let response = JSON.parse(data);

                    if(response.success) {
                        window.location.href = '/objective/list';
                        return;
                    }

                    Modal.message(response)
                }
            });
        })

        $(document).on('click', '#objective_edit_button', function (){
            let id = $(this).val();

            $.ajax({
                url: '/objective/edit',
                type: 'POST',
                data: {
                    id: id
                },

                success: function (data) {
                    let response = JSON.parse(data);

                    if(response.success) {
                        window.location.href = '/objective';
                        return;
                    }

                    Modal.message(response)
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