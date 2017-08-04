import { Ajax } from './JQuery';

/**
 * Default Plugin Cart Class
 * 
 * Some methods can be overriden
 * 
 * @export
 * @class UPWPCart
 */
export default class UPWPCart {

    /**
     * Creates an instance of UPWPCart.
     * 
     * @param {Object} { api = '' } API base URL
     * @memberof UPWPCart
     */
    constructor({ api = '' }) {
        this.api = api;
    }

    /**
     * Get Cart Instance
     * 
     * @param {Function} success Success Callback 
     * @param {Function} [error=console.error] Error Callback
     * @returns 
     * @memberof UPWPCart
     */
    get(success, error = console.error) {
        return this.ajaxGet({ success, error });
    }

    /**
     * Get Cart Item
     * 
     * @param {Object} { id } 
     * @param {Function} success Success Callback 
     * @param {Function} [error=console.error] Error Callback
     * @returns 
     * @memberof UPWPCart
     */
    getItem({ id }, success, error = console.error) {
        return this.ajaxGet({ action: id, success, error });
    }

    /**
     * Add item to Cart
     * 
     * @param {Object} { id, ...data }
     * @param {Function} success Success Callback 
     * @param {Function} [error=console.error] Error Callback
     * @returns 
     * @memberof UPWPCart
     */
    add({ id, ...data }, success, error = console.error) {
        return this.ajaxPost({ data: { id, ...data }, success, error });
    }

    /**
     * Removes item of cart
     * 
     * @param {Object} { id } 
     * @param {Function} success Success Callback 
     * @param {Function} [error=console.error] Error Callback
     * @returns 
     * @memberof UPWPCart
     */
    remove({ id }, success, error = console.error) {
        return this.ajaxPost({ action: id, success, error });
    }

    /**
     * Update item in cart
     * 
     * @param {Object} { id, amount = 1 } 
     * @param {Function} success Success Callback 
     * @param {Function} [error=console.error] Error Callback
     * @returns 
     * @memberof UPWPCart
     */
    update({ id, amount = 1 }, success, error = console.error) {
        return this.ajaxPost({ action: id, data: { amount }, success, error });
    }

    /**
     * Clear cart
     * 
     * @param {Function} success Success Callback 
     * @param {Function} [error=console.error] Error Callback
     * @returns 
     * @memberof UPWPCart
     */
    clear(success, error = console.error) {
        return this.ajaxDelete({ success, error });
    }

    // Ajax

    /**
     * Ajax Handler
     * 
     * When extending this class, this method can be modified, using fetch for instance. Default uses jQuery Ajax.
     * 
     * @param {Object} options 
     * @returns 
     * @memberof UPWPCart
     */
    ajaxHandler(options) {
        return Ajax(options);
    }

    /**
     * Ajax Requests
     * 
     * All ajax requests uses this method.
     * 
     * @param {Object} { method = 'GET', action = '', url = this.api, data, success, error } 
     * @returns 
     * @memberof UPWPCart
     */
    ajax({ method = 'GET', action = '', url = this.api, data, success, error }) {
        return this.ajaxHandler({ url: this.urlJoin(url, action), method, action, data, success, error })
    }

    /**
     * Ajax GET Request
     * 
     * @param {Object} [args={}] 
     * @returns 
     * @memberof UPWPCart
     */
    ajaxGet(args = {}) {
        return this.ajax({ ...args, method: 'GET' });
    }

    /**
     * Ajax POST Request
     * 
     * @param {Object} [args={}] 
     * @returns 
     * @memberof UPWPCart
     */
    ajaxPost(args = {}) {
        return this.ajax({ ...args, method: 'POST' });
    }

    /**
     * Ajax DELETE Request
     * 
     * @param {Object} [args={}] 
     * @returns 
     * @memberof UPWPCart
     */
    ajaxDelete(args = {}) {
        return this.ajax({ ...args, method: 'DELETE' });
    }

    // Utils

    /**
     * URL Join Helper
     * 
     * this helper join the URL paths on params and returns a sanitized URL
     * 
     * @param {Array} paths Array of paths in arguments
     * @returns {String} the Sanitized URL
     * @memberof UPWPCart
     */
    urlJoin(...paths) {
        const trimmedPaths = paths.map(path => {
            path = String(path);

            if (path.slice(0, 1) == '/')
                path = path.slice(1);

            if (path.slice(-1) == '/')
                path = path.slice(0, -1);

            return path;
        })

        return trimmedPaths.join('/');
    }

    /**
     * Join with base API
     * 
     * @param {Object} paths 
     * @returns 
     * @memberof UPWPCart
     */
    getUrl(...paths) {
        return this.urlJoin(this.api, ...paths)
    }
}