
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

After installing it you have to update the database structure and clear your page cache.


Limitations
-----------

This extension make use of the `getCacheKey` hook. If the hook is used by a 3rd party extension make sure that the 
cache control hook is the last one.

The cache control is reset by the weekly cron job (as the page cache). If you have disabled the weekly cron for the page
cache, you have to remove the cache control cron hook as well.
