class Loader {
    constructor(element) {
        this.showed = false;
        this.element = $(element);
    }
    show(message = null) {
        let width = '45%';

        if(window.outerWidth < 699){
            width = '80%';
        }

        this.element.block({
            message: (message || '<h3>İşlemler yapılıyor. Lütfen bekleyiniz...</h3>'),
            css: {
                backgroundColor: '#000',
                color: '#fff',
                borderRadius: '7px',
                border: '1px solid #111',
                padding: '10px 5px',
                width: width
            }
        });

        this.showed = true;
    }
    hide() {
        this.element.unblock();
        this.showed = false;
    }
    toggle() {
        this.showed ? this.hide() : this.show();
    }
}

export default window.Loader = Loader;