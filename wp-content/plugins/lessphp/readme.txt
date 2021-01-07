=== Less PHP Compiler ===
Contributors: aristath, fovoc, unyson
Tags: less, compiler, preprocessor
Requires at least: 3.7
Tested up to: 4.1
Stable tag: 2.0.1
License: GPLv2 or later

Includes the less.php preprocessor so that it may be used by other plugins or themes.

== Description ==

This is a simple plugin that loads the Less.php and scssc classes and makes them available to other plugins and themes.
When activated this plugin will not do anything.
It has no functionality on its own, but can be used as a dependency for other plugins & themes.

Includes the Less.php class from http://lessphp.gpeasy.com/ and scss from http://leafo.net/scssphp/

== Changelog ==

= 2.0.1 =

* PHP 5.2 support: Replaced `__DIR__` with `dirname(__FILE__)`

= 2.0.0 =

* Bugfixes

= 1.9.0 =

* Included a new Pre_Processors_Compiler class (pending documentation)

= 1.8.0 =

* Included the Sass Compiler
* Updated the Less compiler class

= 1.7.0 =

* Compilation compatible with LESS 1.7
* Fix sourcemap generation when parser caching used
* Additional less.inc.php functionality
* Assetic compatibility
* Fix order of classes in combined file

= 1.6.3 =

* Added fixes and updates from less.js 1.6.3
* Performance enhancements
* Improved Windows compatibility
* Additional lessc.inc.php functionality for users transitioning from leafo/lessphp

= 1.6.1 =

* Less compilation compatible with less css 1.6.1

= 1.5.1.2 =

* Initial Release
