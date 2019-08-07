# Blackout: Dark Mode Widget for WordPress
🌓 Add a Dark Mode / Night Mode to your website in a few seconds

A simple solution to allow your users to enable/disable dark mode on your website.

It creates a widget that your users can use to toggle between normal and dark modes.

It uses the CSS mix-blend-mode to bring dark-mode to any of your websites.

Sandoche made the widget and, it has a standalone version that allows you to implement it on your website by copy+pasting a simple JavaScript script, you can find more about that by [clicking here](https://darkmodejs.learn.uno/).

## ✨ Demo
Check out the demo in these websites:

- https://inboundlatino.com/google-tag-manager/
- https://cosasdeanas.com/documental-que-no-es-vegano-pero-que-podria-ser/
- https://blog.cheaptotrip.com/mexico/cancun-viaje-divertido-e-inolvidable/

These have the widget, but not the WordPress plugin

- https://darkmodejs.learn.uno
- https://tradivegan.com (with custom label)
- https://what.toeat.in (with custom label)
- https://www.kanbanote.com (without the widget, once logged in)
- https://www.sandoche.com (with custom label)

## 📖 How to use
As with any other WordPress plugin, you can follow this simple steps to install it:

* Install using the WordPress built-in Plugin installer, or extract the zip file and drop the contents in the wp-content/plugins/ directory of your WordPress installation.
* Activate the plugin through the ‘Plugins’ menu in WordPress.
* Go to settings > Blackout to customize the configurations of the widget (optional).

## Override style
* Use the class `darkmode-ignore` where you don't want to apply darkmode, it will implement `mix-blend-mode: difference;` but only when the widget is active, that way it won't look weird if it's disabled.

**You don't need to do it with images or iframes as it's added by default.**

## Browser compatibility
This library uses the CSS `mix-blend-mode: difference;` in order to provide the Dark Mode.
It may not be compatible with all the browsers.

Check the compatibility here: https://caniuse.com/#search=mix-blend-mode

## ⭐ Show your support
Please ⭐ this plugin if this project helped you!

Also, if it helped you it would be awesome if you could leave a review in WordPress, you can do that by [clicking here](https://wordpress.org/support/plugin/blackout-darkmode-widget/reviews/#new-post).

## Want to help?
If you like this plugin, feel free to donate:

* [Donation Page](https://compras.inboundlatino.com/blackout/?ref=github) (Paypal and Credit Card with Stripe)
* Bitcoin: 12Nth97LEFYFiWJ66PEhHfWbwFPT8fnznN
* Ethereum: 0x6a5bF47fef1fC52BC41ca190b11E05Ac95490D0a
* BAT (Basic Attention Token): 0x6a5bF47fef1fC52BC41ca190b11E05Ac95490D0a
* Litecoin: LLce6WFs2SVrp5s
