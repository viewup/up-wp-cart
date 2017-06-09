#  Plugin form controller

Controls when POST and GET request are made to this plugin.

The form controller will:
 - Detect POST requests to the plugin
 - transform the POST request in cart actions
 - Make changes on the cart
 - Redirects

## TODO:
 - [x] get_header - Hook for checking post content
 - [x] wp_redirect - Redirect after a post action (to the same page or the plugin configured page)
 - [x] OPTION: redirect page (a selected page for redirect)
 - [x] FIELD: ADD redirect hidden field on form
 - [ ] ADD query vars (register and on redirect)