=== Advanced Custom Fields: Price Field ===
Contributors: speccode
Tags: acf, advanced custom fields, price
Requires at least: 3.5
Tested up to: 4.8
Requires PHP: 7.0
Stable tag: 1.3.0
License: MIT
License URI: https://opensource.org/licenses/MIT

ACF Price field with number formatting.

== Description ==

= How it works =
* Plugin will store your "price" as float so any time you will change desire number format there will be no reformatting problems.
* Best column type in database for "price" related fields is decimal. As WordPress keep meta as type "text"  I can only cast it to float. Keep it in mind.
* Field validation is "live" thanks to https://github.com/teamdf/jquery-number.
* When you use `get_field` function you will get preformatted number based on your settings.

= Options =
`format`

Available formats:
* `1 337.55`
* `1 337,55`
* `1,337.55`
* `1.337,55`
* `1337`
* `1 337`


= Default parameters result =
`1 337.00`

= Compatibility =

This ACF field type is compatible with:
* ACF 5
* ACF 4

== Installation ==

1. Copy the `acf-price` folder into your `wp-content/plugins` folder
2. Activate the Price plugin via the plugins admin page
3. Create a new field via ACF and select the Price type
4. Please refer to the description for more info regarding the field type settings

== Changelog ==

= [1.3.0] 2026-10-26 =
* Harden `update_value()`: values are sanitised server-side, so writes that bypass the client-side mask (REST API, WP-CLI, imports) are cleaned or rejected instead of stored raw
* Fix fatal `TypeError` in `format_value()` on PHP 8+ when stored meta is not strictly numeric
* Fix `|0//|` format storing thousands separators verbatim
* Fix undefined array key notices for fields without a `format` setting
* Escape the field `id` and format data attributes in the rendered input
* Add `ABSPATH` guards to included field files

= [1.2.1] 2017-07-15 =
* added translations

= [1.2.0] 2017-07-02 =
* bugfixes
* cleanup file structure
* add support for ACF 4

= [1.1.0] 2017-06-17 =
* added `format` option
* removed support for ACF 4 (temporary)

= [1.0.0] 2015-02-02 =
* Initation of plugin, no configuration. Only live validation.
