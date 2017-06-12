# UP WP Cart
Simple cart plugin for WordPress

The plugin allow you to select a post type to be the products and a meta name to be the price.
With shortcodes, you can add a **ADD TO CART** button and a **CART PAGE**.
The plugin integrates with `contact form 7`, allowing you to insert on your contact form the user cart.

## Motivation
Most of the cart plugins/libraries for WordPress are only for `WooCommerce`. We want a simple plugin, that allow users to easily create a Shopping cart with any `post_type` and `post_meta` they want.

The plugin has/will have the following features:

 - post types and meta integration
 - Cart on user session
 - RestFul API for theme developers
 - Filters modifications for theme developers
 - panel config screen
 - Contact Form 7 integration
 - Shortcode support
 - Widgets support (SOON)
 - Cart Update with AJAX (no refresh) and theme integration (SOON)

## License
The plugin is under [GPL-2.0](LICENSE.md) license.

## Theme/Plugins support

for now, the theme can change the item's `content` shape. by default, it looks like the rest API post. only replace the `cart_content` filter with anything you want!
SOON, will be a fancy API and shortcodes...

## Contact Form 7

The plugin has integration with Contact Form 7. That way, you can insert the cart on your email.

On the contact form, the `cart` button will allow you to insert the cart hook on the form, and make it required.

If required, the form will only submit if the cart has items.

The plugin by default will render a table on the email, on the specified area, with all items and values, and total values.
This table can be modified by any plugin or theme, or can be completely replaced if you want!

The plugin also adds a render method for no-HTML emails. a list with the products will be rendered.

## Pull Requests
OF COURSE! Help us get the plugin better! read the [Contributing section](CONTRIBUTING.md) to know how!
