$(document).ready(function () {
    const popupWidth = 780;
    const popupHeight = 550;

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

        let vPosition = Math.floor(($(window).width() - popupWidth) / 2),
            hPosition = Math.floor(($(window).height() - popupHeight) / 2);

        let popup = window.open($(this).prop('href'), 'social',
            'width=' + popupWidth + ',height=' + popupHeight +
            ',left=' + vPosition + ',top=' + hPosition +
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }
    });
});
