class Snackbar
{
    constructor(selector) {
        this.element = $(selector).first();
        this.timeoutInstance = undefined;
    }

    setText(text) {
        this.element.text(text);

        return this;
    }

    setHtml(html) {
        this.element.html(html);

        return this;
    }

    showAndHide(miliseconds = 3000) {
        clearTimeout(this.myTimeout);
        this.show();
        var that = this;
        this.myTimeout = setTimeout(function () {
            that.hide();
        }, miliseconds);

        return this;
    }

    show() {
        this.element.addClass("show");

        return this;
    }

    hide() {
        this.element.removeClass("show");

        return this;
    }
}

function snackbar(selector) {
    return (new Snackbar(selector));
}
