$(document).ready(function () {
    let popupSize = {
        width: 780,
        height: 550
    };

    $(document).on('click', '.social-button', function (e) {
        if ((e.target.id || e.target.parentElement.id) === 'clip') {
            e.preventDefault();
            if (window.clipboardData && window.clipboardData.setData) {
                clipboardData.setData("Text", this.href);
            } else {
                let textArea = document.createElement("textarea");
                textArea.value = this.href;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand("copy");  // Security exception may be thrown by some browsers.
                textArea.remove();
            }
            return;
        }

        let verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

        let popup = window.open($(this).prop('href'), 'social',
            'width=' + popupSize.width + ',height=' + popupSize.height +
            ',left=' + verticalPos + ',top=' + horisontalPos +
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }
    });
});
