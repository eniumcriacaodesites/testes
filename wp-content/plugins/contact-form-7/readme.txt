=== Contact Form 7 ===
Contributors: takayukister
Donate link: https://contactform7.com/donate/
Tags: contact, form, contact form, feedback, email, ajax, captcha, akismet, multilingual
Requires at least: 4.7
Tested up to: 4.9.1
Stable tag: 4.9.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Just another contact form plugin. Simple but flexible.

== Description ==

Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup. The form supports Ajax-powered submitting, CAPTCHA, Akismet spam filtering and so on.

= Docs & Support =

You can find [docs](https://contactform7.com/docs/), [FAQ](https://contactform7.com/faq/) and more detailed information about Contact Form 7 on [contactform7.com](https://contactform7.com/). If you were unable to find the answer to your question on the FAQ or in any of the documentation, you should check the [support forum](https://wordpress.org/support/plugin/contact-form-7/) on WordPress.org. If you can't locate any topics that pertain to your particular issue, post a new topic for it.

= Contact Form 7 Needs Your Support =

It is hard to continue development and support for this free plugin without contributions from users like you. If you enjoy using Contact Form 7 and find it useful, please consider [__making a donation__](https://contactform7.com/donate/). Your donation will help encourage and support the plugin's continued development and better user support.

= Recommended Plugins =

The following plugins are recommended for Contact Form 7 users:

* [Flamingo](https://wordpress.org/plugins/flamingo/) by Takayuki Miyoshi - With Flamingo, you can save submitted messages via contact forms in the database.
* [Bogo](https://wordpress.org/plugins/bogo/) by Takayuki Miyoshi - Bogo is a straight-forward multilingual plugin that doesn't cause headaches.

= Translations =

You can [translate Contact Form 7](https://contactform7.com/translating-contact-form-7/) on [__translate.wordpress.org__](https://translate.wordpress.org/projects/wp-plugins/contact-form-7).

== Installation ==

1. Upload the entire `contact-form-7` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

You will find 'Contact' menu in your WordPress admin panel.

For basic usage, you can also have a look at the [plugin web site](https://contactform7.com/).

== Frequently Asked Questions ==

Do you have questions or issues with Contact Form 7? Use these support channels appropriately.

1. [Docs](https://contactform7.com/docs/)
1. [FAQ](https://contactform7.com/faq/)
1. [Support Forum](https://wordpress.org/support/plugin/contact-form-7/)

[Support](https://contactform7.com/support/)

== Screenshots ==

1. screenshot-1.png

== Changelog ==

For more information, see [Releases](https://contactform7.com/category/releases/).

= 4.9.2 =

* Remove improper uses of esc_sql().
* Fix the refill REST-API request so that a nonce is set when available.
* Give more contrast to unused mail-tags in the Mail tab panel to make them easier to recognize.
* Undo the previous change of HTTP status code for the REST-API response.

= 4.9.1 =

* Code using create_function() has been removed to avoid security risks and warnings given when using with PHP 7.2+.
* Display the notice of config validation again to encourage admins to apply some important validation items recently added.
* REST API endpoint returns more specific HTTP status code 409 instead of 400.
* Fixed appearance of configuration error signs in the Additional Settings tab.

= 4.9 =

* Supports subscribers_only setting
* Changes the default value of WPCF7_VERIFY_NONCE to false
* WPCF7_FormTagsManager::collect_tag_types() supports invert option
* New filter hooks: wpcf7_verify_nonce, wpcf7_subscribers_only_notice, wpcf7_remote_ip_addr, and wpcf7_submission_is_blacklisted
* Fixed: Form-tag's tabindex option did not accept 0 or negative integer values
* Shows a validation error when no option in a radio buttons group is checked
* Config validator: Adds a validation rule against the use of deprecated settings (on_sent_ok and on_submit)
* Allows to pass the skip_mail option through the WPCF7_ContactForm::submit() and WPCF7_Submission::get_instance() function parameters.
* Triggers wpcf7beforesubmit custom DOM event. You can manipulate the formData object through an event handler.

= 4.8.1 =

* wpcf7.initForm JavaScript function added to isolate form initialization process.
* Fix response message duplication caused by repeated click on submit button.
* Clear $phpmailer->AltBody to avoid unintended inheritance from previous wp_mail() calls.
* Fix incorrect character count of textarea input.
* Akismet: Exclude the comment_author, comment_author_email, and comment_author_url values from the comment_content value.
* REST API: More reliable approach to build route URLs.
* Include free_text inputs into event.detail.inputs.

= 4.8 =

* Stopped using jquery.form.js.
* Added custom REST API endpoints for Ajax form submissions.
* WPCF7_FormTag class implements ArrayAccess interface.
* WPCF7_FormTagsManager::filter() filters form-tags based on features they support.
* New form-tag features: do-not-store, display-block, and display-hidden
* Removed inappropriate content from h1 headings.
* Added the support of size:invisible option to the reCAPTCHA form-tag.
