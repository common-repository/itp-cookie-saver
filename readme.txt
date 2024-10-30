=== ITP Cookie Saver - Convert javascript cookies to server cookies ===
Tags: tracking, ITP 2.1, ITP, cookie, server cookies, cookie saver, google analytics
Requires at least: 4.0
Tested up to: 6.1
Requires PHP: 5.3
License: GPLv3

== Description ==
This plugin removes the seven days limitations of cookies in certain browsers. Many browsers start to limit the cookie lifetime of cookies which are set by javascript to a short period of time, e.g. Safaris ITP 2.1.

## Why is the limitation of the lifetime a Problem?
Depending on your website their might be a lot of Problems. The two main challenges might be:
1. Tracking
2. Cookie Consent Banner

**Tracking**
Most Tracking Tools, like Google Analytics for example are setting their cookies by javascript. If the cookie is deleted after seven days, the tools are not able to recognize the user as a returning user anymore, so after seven days of absence every user is a new user.

**Cookie Consent Banner**
It is a problem, if the cookie consent banner implementation sets the cookie with javascript. This is how most of the banner implementation do it.
If the cookie lifetime is limited by the browser to seven days, the user will see the banner every seven days, even if he made already a choice.
This can be annoying and conversion relevant.

## How does this Plugin work exactly?
As part of the HTTP protocol all cookies are always send to the backend with every request. 
This plugin uses this fact, by checking every request if one of the defined cookies is present. If a defined cookie is present, it sets it with the same value again.

**Now the cookie is set by the server and the javascript cookie lifetime limitation is bypassed.**

A challenge with this approach might be, that the cookie is set at the beginning of a page load. During page load there might be javascripts, which overwrite the cookie. In that case the javascript cookie lifetime limitation is kicking in again.

This can be avoided by checking the "before unload"- feature. With this feature enabled, everytime the user leaves a page, an additional request is send in the background and the cookies are set again.
So you can be sure, the server was the last to touch the cookie.

== Screenshots ==

1. General Settings

== Installation ==
Just install this plugin and go to Settings > ITP Cookie Saver and activate it.
You can add the cookie names you want to save. The Google Analytics Cookie is already prefilled.

== Changelog ==

= 1.2.1 =

* Fix: missing isset: notice was spamming the logs

= 1.2.0 =

* Fix: critical vulnerability.

= 1.1.1 =

* Fixing major bug from v1.1: setcookies had problems with older php versions.

= 1.1 =

* added samesite attribute when saving cookie. It is always "lax".
* you can config the domain where to write the saved cookie now.
* bug fixes

= 1.0.2 =

* Minor Fix

= 1.0.1 =

* Minor Fix: in very few case there were some PHP Notices thrown.
* Minor Fix: Duplicate Fieldname in Settings.

= 1.0 =

* First Version of this Plugin. More to come!
