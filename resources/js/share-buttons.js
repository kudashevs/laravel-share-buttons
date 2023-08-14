document.addEventListener("DOMContentLoaded", () => {
    let socialButtons = document.querySelectorAll('.social-button');

    socialButtons.forEach((button) => {
        button.addEventListener('click', socialButtonClickHandler)
    })
});

function socialButtonClickHandler(e) {
    const popupWidth = 780;
    const popupHeight = 550;

    let el = identifyTargetElement(e, provideMissingTargetElementHandler(e));
    if (el === undefined) return;

    if (el.id === 'clip') {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (window.clipboardData && window.clipboardData.setData) {
            clipboardData.setData("Text", el.href);
        } else {
            let textArea = document.createElement("textarea");
            textArea.value = el.href;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("copy");  // Security exception may be thrown by some browsers.
            textArea.remove();
        }
        return;
    }

    const windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    const windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

    const vPosition = Math.floor((windowWidth - popupWidth) / 2),
        hPosition = Math.floor((windowHeight - popupHeight) / 2);

    const popup = window.open(el.href, 'social',
        'width=' + popupWidth + ',height=' + popupHeight +
        ',left=' + vPosition + ',top=' + hPosition +
        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

    if (popup) {
        e.preventDefault();
        e.stopImmediatePropagation();
        popup.focus();
    }
}

function identifyTargetElement(e, cb) {
    let buttonClassName = 'social-button';

    if (
        e.target.parentElement &&
        e.target.parentElement.className.indexOf(buttonClassName) !== -1
    ) {
        return e.target.parentElement;
    }

    if (
        e.target.className.indexOf(buttonClassName) !== -1
    ) {
        return e.target;
    }

    typeof cb === 'function' && cb(buttonClassName)
}

// this function can be modified to handle a missing target element
// don't remove it because it is used in the socialButtonClickHandler
function provideMissingTargetElementHandler(e) {
    // returns a function with an enclosing e variable (contains a triggered event)
    // accepts a name argument (contains a classname used to identify a target element)
    return (name) => {
    }
}
