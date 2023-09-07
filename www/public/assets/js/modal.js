const Modal = function () {
    const handleModal = function () {
        let modal = $('#myModal');
        let modalContent = $('.modal-content');

        $(document).on('click', '.close-modal',function (){
            modalContent.html('');

            modal.removeClass('show');
            modal.addClass('hide');

            return true;
        });

        window.onclick = function(event) {
            if ($(event.target)[0] == modal[0]) {

                modal.removeClass('show');
                modal.addClass('hide');

                return true;
            }
        }
    }

    const handleContent = function (data){
        if (Array.isArray(data.message)) {
            let html = '';

            data.message.forEach(function (item) {
                html += `<p>${item}</p>`;
            })

            defineContent(html)
            return;
        }

        defineContent(data.message)
    }

    function defineContent (content) {
        let modal = $('#myModal');
        let modalContent = $('.modal-content');

        modalContent.html('');
        modalContent.html(modalContent.html() + content);

        modal.removeClass('hide');
        modal.addClass('show');
    }

    return {
        init: function () {
            handleModal();
        },
        message: function (data) {
            handleContent(data);
        }
    }
}()

$(document).ready(() => {
    Modal.init();
});