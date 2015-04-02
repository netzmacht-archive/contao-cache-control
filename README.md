
Contao Cache Control
====================

This extension allows to reset the page cache for a single page without clearing the whole page cache.


Features
--------

 * Clear page cache for a single page.
 * Clear page cache for multiple pages (edit all mode).


Requirements
------------

This extension requires at least Contao 3.2.


Install
-------

It's recommend to install the extension using composer.

```
$ php composer.phar require netzmacht/contao-cache-control:~1.0
```

If you want to install the extension manually, please do these steps:

 * Copy `module` folder into `system/modules`.
 * Rename it to `cache-control`.
 * Create the folder `system/modules/cache-control/classes`.
 * Copy the `src` folder into `system/modules/cache-control/classes`.
 * Open `system/modules/cache-control/config/autoload.php` and uncomment the class loader lines.
