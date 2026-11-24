# Zend Framework 1
[![Build](https://github.com/gizmocraftcom/zf1/workflows/Build/badge.svg?event=push)](https://github.com/gizmocraftcom/zf1/actions?query=workflow%3ABuild+event%3Apush)
[![Latest Stable Version](https://poser.pugx.org/gizmocraft/zendframework1/v/stable)](https://packagist.org/packages/gizmocraft/zendframework1)
[![Total Downloads](https://poser.pugx.org/gizmocraft/zendframework1/downloads)](https://packagist.org/packages/gizmocraft/zendframework1)
[![License](https://poser.pugx.org/gizmocraft/zendframework1/license)](https://packagist.org/packages/gizmocraft/zendframework1)

This is a fork of Zend Framework 1 that keeps it working on current versions of PHP. It requires PHP 8.5 or newer and is tested on PHP 8.5 and 8.6.

This fork is based on the final release of the original project (version 1.12.20). It was originally forked from https://github.com/diablomedia/zf1, which is itself a fork of Zend Framework 1. Releases follow [semantic versioning](https://semver.org/).

Installation via composer is the suggested way to install this fork:

`composer require gizmocraft/zendframework1`

The components are separate packages (`gizmocraft/zendframework1-*`) that this package requires. Install only the ones you need if you do not want the whole framework.

Some components were not carried over because the services they talk to no longer exist or the extensions they need are gone. See [EXCLUDED_PACKAGES.md](EXCLUDED_PACKAGES.md) for the list, the reasons and the evidence.

## Installing before the packages are on Packagist
Until the `gizmocraft/zendframework1*` packages are on Packagist, Composer finds them through VCS repositories on GitHub (`https://github.com/gizmocraftcom/zf1-*`). Composer does not read the `repositories` entries of a dependency's `composer.json`, so your project must list them itself. Either:
-   copy the `repositories` block from [composer-repositories.json](composer-repositories.json) (68 entries, one per package) into the `composer.json` of your project, then run `composer require gizmocraft/zendframework1`, or
-   wait until the packages are on Packagist, when no `repositories` entries are needed.
A single entry looks like this:
```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/gizmocraftcom/zf1-acl" }
    ]
}
```
`composer-repositories.json` is generated from the `repositories` section of this repository's `composer.json`. Regenerate it whenever that section changes.
## Not carried over
Six packages are not part of this fork: `zendframework1-openid`, `zendframework1-auth-adapter-openid`, `zendframework1-service-amazon`, `zendframework1-service-recaptcha`, `zendframework1-log-writer-firebug` and `zendframework1-wildfire`. These classes were removed from `library/` of this repository: `Zend_Gdata`, `Zend_Mobile` (push), `Zend_Service_Yahoo`, `Zend_Service_Delicious`, `Zend_Service_SlideShare`, `Zend_Service_Ebay`, `Zend_Service_Twitter`, `Zend_Service_LiveDocx`, `Zend_Service_StrikeIron`, and the Amazon adapters of `Zend_Cloud` (S3, SimpleDb, Sqs, Ec2). The reasons and evidence are in [EXCLUDED_PACKAGES.md](EXCLUDED_PACKAGES.md). Other breaking changes are in [CHANGELOG.md](CHANGELOG.md).
## Maintenance
-   PHP: minimum 8.5. Tested on PHP 8.5.13 and 8.6.0 (CI runs 8.5 and 8.6).
-   Tests: run `composer install`, then `cd tests && php runalltests.php`. The `Zend_Queue_Adapter_Db` tests need MySQL (see `.github/workflows/build.yml`).
-   Static analysis: `composer phpstan`. Code style: `composer style-check`.
-   Each component package (`gizmocraft/zendframework1-*`) has its own repository and runs its own tests.
## Release Highlights
### Unreleased
-   Renamed to `gizmocraft/zendframework1` and raised the minimum PHP version to 8.5 (CI runs 8.5 and 8.6). See `CHANGELOG.md` for all changes.
-   Dev dependencies upgraded to PHPUnit 13, PHPStan 2 and php-cs-fixer 3.
-   Dropped dead services and APIs (Zend_Gdata, Zend_Service_Yahoo, Twitter and others, see `EXCLUDED_PACKAGES.md`).
### 5.0.0

-   Removed phpunit/dbunit from Zend_Test component, as this has been abandoned and made it difficult to upgrade to newer versions of phpunit (which makes it difficult to test against newer versions of PHP)
-   Fixed some function signatures in these classes to move required parameters before parameters with defaults (this behavior is deprecated in PHP 8 and will throw errors in a later version of PHP):
    -   Zend_Pdf_Element_Reference
    -   Zend_Service_WindowsAzure_CommandLine_Certificate::getCertificatePropertyCommand
    -   Zend_Service_WindowsAzure_CommandLine_Deployment::createFromStorageCommand & createFromLocalCommand
    -   Zend_Service_WindowsAzure_Diagnostics_Manager::setConfigurationForRoleInstance
    -   Zend_Service_WindowsAzure_Storage_Queue::deleteMessage
-   All packages, and the remaining components in this repo have been tested against PHP 8 (both with phpunit and phpstan). For the most part this didn't require any code changes, and what was changed shouldn't break BC except what's listed above.

### 4.0.0

-   Moved a majority of components to their own separate composer package. This package can still be used like before (if being installed with composer, if not, you'll need to stick to the 3.x line), as it pulls in all of the separate components via composer, but it's recommended to just use the components you need. View this project's `composer.json` to see which components are available as a separate package.
-   Removed sqlite cache classes from Zend_Cache (in the `gizmocraft/zendframework1-cache` package) since they're not compatible with PHP 7.0+
-   Autoloading namespaces changed to be more specific, which should speed up non-optimized autoloaders a bit.

### 3.0.0

-   Minimum PHP version set to 7.0
-   PHPUnit upgraded to 6.0

### 2.0.0

-   Renamed to our organization in Composer
-   Minimum PHP version set to 5.6

## The following is the original README contents from upstream:

![Logo](http://framework.zend.com/images/logos/ZendFramework-logo.png)

> ## End-of-Life occurs 28 Sep 2016
>
> Between now and 28 Sep 2016, we will only be accepting security patches to
> this repository; after that date, we will issue no more releases.
>
> For more information:
>
> -   https://framework.zend.com/blog/2016-06-28-zf1-eol.html

# RELEASE INFORMATION

Zend Framework 1.12.21dev Release.
Released on MMM DD, YYYY.

## IMPORTANT FIXES FOR 1.12.21

See http://framework.zend.com/changelog for full details.

# NEW FEATURES

## Zend_Loader changes

A number of autoloaders and autoloader facilities were back ported from
ZF2 to provide performant alternatives to those already available in the
1.X releases. These include: Zend_Loader_StandardAutoloader, which
improves on Zend_Loader_Autoloader by allowing the ability to specify a
specific path to associate with a vendor prefix or namespace;
Zend_Loader_ClassMapAutoloader, which provides the ability to use lookup
tables for autoloading (which are typically the fastest possible way to
autoload); and Zend_Loader_AutoloaderFactory, which can both create and
update autoloaders for you, as well as register them with
spl_autoload_register().

The Zend_Loader changes were back ported from ZF2 by Matthew Weier
O’Phinney

## Zend_EventManager

Zend_EventManager is a component that allows you to attach and detach
listeners to named events, both on a per-instance basis as well as via
shared collections; trigger events; and interrupt execution of
listeners.

Zend_EventManager was back ported from ZF2 by Matthew Weier O’Phinney

## Zend_Http_UserAgent_Features_Adapter_Browscap

This class provides a features adapter that calls get_browser() in order
to discover mobile device capabilities to inject into UserAgent device
instances.

Browscap (http://browsers.garykeith.com/) is an open project dedicated
to collecting an disseminating a “database” of browser capabilities. PHP
has built-in support for using these files via the get_browser()
function. This function requires that your php.ini provides a browscap
entry pointing to the PHP-specific php_browscap.ini file which is
available at http://browsers.garykeith.com/stream.asp?PHP_BrowsCapINI.

Zend_Http_UserAgent_Features_Adapter_Browscap was created by Matthew
Weier O’Phinney

# Removed features

## Zend_Http_UserAgent_Features_Adapter_WurflApi

Due to the changes in licensing of WURFL, we have removed the WurflApi
adapter. We will be providing the WurflApi adapter to ScientiaMobile so
that users of WURFL will still have that option.

# Bug Fixes

In addition, over 200 reported issues in the tracker have been fixed.
We’d like to particularly thank Adam Lundrigan, Frank Brückner and
Martin Hujer for their efforts in making this happen. Thanks also to the
many people who ran the ZF1 unit tests and reported their results!

For a complete list of closed issues beginning with 1.12.3, visit:

-   https://github.com/zendframework/zf1/issues?labels=&milestone=&page=1&state=closed
-   http://framework.zend.com/changelog/

# MIGRATION NOTES

A detailed list of migration notes may be found at:

http://framework.zend.com/manual/en/migration.html

# SYSTEM REQUIREMENTS

Zend Framework requires PHP 5.2.11 or later. Please see our reference
guide for more detailed system requirements:

http://framework.zend.com/manual/en/requirements.html

# INSTALLATION

Please see [INSTALL.md](INSTALL.md).

# REPOSITORY HISTORY

This repository was created based on the release-1.12 branch of a Subversion
repository, http://framework.zend.com/svn/framework/standard/. It contains a
subset of the project history, dating from between the 1.5.0 and 1.6.0 releases,
and only contains the tags for the 1.12 series. If you would like an older
version, you may access the subversion repository linked above, or download an
older version from http://framework.zend.com/downloads/archives.

# CONTRIBUTING

Please see [README-GIT.md](README-GIT.md) and
[DEVELOPMENT_README.md](DEVELOPMENT_README.md).

# QUESTIONS AND FEEDBACK

Online documentation can be found at http://framework.zend.com/manual.
Questions that are not addressed in the manual should be directed to the
appropriate mailing list:

-   http://framework.zend.com/wiki/display/ZFDEV/Mailing+Lists

If you find code in this release behaving in an unexpected manner or
contrary to its documented behavior, please create an issue in the Zend
Framework issue tracker at:

-   https://github.com/zendframework/zf1/issues

If you would like to be notified of new releases, you can subscribe to
the fw-announce mailing list by sending a blank message to:

-   fw-announce-subscribe@lists.zend.com.

# LICENSE

The files in this archive are released under the Zend Framework license.
You can find a copy of this license in [LICENSE.txt](LICENSE.txt).

# ACKNOWLEDGEMENTS

The Zend Framework team would like to thank all the contributors to the Zend
Framework project, our corporate sponsor, and you, the Zend Framework user.
Please visit us sometime soon at http://framework.zend.com.
