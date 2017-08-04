import Cart from './Cart';
import $ from './JQuery'

export const updateClass = ' upwpcart-loading'

export default class UPWPCartHandler {

    constructor({ api }) {
        this.cart = new Cart({ api });
        $(document).on('wpcsubmit', function () {

        });

    }

    submitForm(event) {
        event.preventDefault();
        const $form = $(event.target);
    }

    update({ rendered: cart }) {
        const $forms = $('[data-upwpcart-cart]');
        const $cart = $(cart);
        $forms.html($cart);
        $('[data-upwp-cart-item]').removeClass(updateClass)
        this.isUpdating = false;
        return this;
    }

}