let KeyResult = (() => {
    let handleForm = function (){
        $('#key-result-form').submit(function (event) {
            let keyResultForm = $(this).serialize();

            event.preventDefault();

            $.ajax({
                url: '/key-result/save',
                type: 'POST',
                data: keyResultForm,
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

    let handleButtons = function () {
        $(document).on('click', '#key_result_remove_button', function (){
            let id = $(this).val();

            $.ajax({
                url: '/key-result/remove',
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

        $(document).on('click', '#key_result_edit_button', function (){
            let id = $(this).val();

            $.ajax({
                url: '/key-result/edit',
                type: 'POST',
                data: {
                    id: id
                },

                success: function (data) {
                    let response = JSON.parse(data);

                    if(response.success) {
                        window.location.href = '/key-result';
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
    KeyResult.init();
});