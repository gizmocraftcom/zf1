# Changelog

## Unreleased
### PHP 8.5 and 8.6
-   Minimum PHP version is 8.5. CI runs PHP 8.5 and 8.6 (GitHub Actions at the latest majors).
-   `Zend_Pdf`, `Zend_Amf`: `spl_object_hash()` (deprecated in PHP 8.6) is replaced by `sprintf('%032x', spl_object_id())`, which keeps the 32 character string ids. `is_integer()`, `is_long()`, `is_double()` (deprecated in PHP 8.6) are replaced by `is_int()`/`is_float()` in `Zend_Pdf`, `Zend_Queue`, `Zend_Search_Lucene`, `Zend_XmlRpc_Value`.
-   `Zend_Pdf`: `SplObjectStorage::attach()`/`contains()` (deprecated in PHP 8.5) are replaced by `offsetSet()`/`offsetExists()`.
-   `Zend_Feed` (Atom, RSS, `Zend_Feed_Element`): `DOMDocument::$actualEncoding` (deprecated in PHP 8.4) is replaced by `DOMDocument::$encoding`.
-   `Zend_CodeGenerator_Php_Property_DefaultValue`: the array walk no longer iterates over objects with `RecursiveArrayIterator` (deprecated in PHP 8.5, "object as backing array"). The generated code is unchanged.
-   `Zend_Service_WindowsAzure_Management_Client`: `utf8_decode()` (deprecated in PHP 8.2) is replaced by the new protected method `_utf8Decode()` (mbstring, falls back to iconv). `Zend_Service_WindowsAzure_Storage_Blob`: `utf8_encode()` on the ASCII block list XML was a no-op and is removed.
-   `Zend_Cloud_StorageService_Adapter_WindowsAzure::storeItem()` and `Zend_Service_WindowsAzure_Management_Client`: strings with NUL bytes (binary data, PFX certificates) are no longer passed to `file_exists()`, which throws a `ValueError` for them on PHP 8.6.
-   No public method signature changed. The only added method is the protected `Zend_Service_WindowsAzure_Management_Client::_utf8Decode()`.
-   `Zend_Version::VERSION` stays at the upstream value `1.12.21dev` on purpose (see the class docblock): code that compares against 1.12.x keeps working. The fork release number is the Composer package version.
### Dev dependencies and tests
-   `require-dev`: PHPUnit ^13.4.8, phpunit/phpcov ^13.2.1, PHPStan ^2.3.7, php-cs-fixer ^3.95.32.
-   The test suite is migrated to PHPUnit 13 (attributes, static data providers, `failOnDeprecation`/`failOnNotice`/`failOnWarning`/`failOnRisky`, no removed APIs). `tests/phpunit.xml` now contains only the suites for code that lives in this repository; the suites for the `gizmocraft/zendframework1-*` packages were dropped because each package runs its own tests. The `Zend_Queue_Adapter_Db` tests run against MySQL in CI.

### Breaking changes

#### Removed classes (dead services and APIs)

These classes lived in `library/` of this repository. They are removed together with their tests, demos, documentation, `composer.json` autoload entries and phpstan baseline entries. The reasons and evidence are recorded in `EXCLUDED_PACKAGES.md`, section "Removed classes in the main repository".

| Removed | Reason | Evidence |
|---|---|---|
| `Zend_Gdata` and all `Zend_Gdata_*` classes | Google Data APIs (ClientLogin, AuthSub, Calendar/Docs/Spreadsheets/Picasa/Books/Analytics GData endpoints) were shut down or replaced by REST APIs with OAuth 2. | https://developers.google.com/gdata/docs/auth/clientlogin ; https://workspaceupdates.googleblog.com/2014/06/calendar-gdata-api-google-calendar.html |
| `Zend_Service_Yahoo` | Yahoo BOSS search service was closed. | https://searchengineland.com/yahoo-to-close-boss-build-your-own-search-service-next-month-242046 |
| `Zend_Service_Delicious` | Delicious was bought by Pinboard and closed. | https://betanews.com/article/pinboard-buys-delicious-closes-it/ |
| `Zend_Service_SlideShare` | The public SlideShare API has been retired. | https://support.scribd.com/hc/en-us/articles/53231623793684-Slideshare-API-errors-the-public-API-has-been-retired |
| `Zend_Service_Ebay` (`Zend_Service_Ebay_Abstract`, `Zend_Service_Ebay_Exception`) and the former `Zend_Service_Ebay_Finding*` classes | eBay Finding API decommissioned in Feb 2025. It was the only eBay API implemented, so the whole `Zend_Service_Ebay` remnant is removed. | https://developer.ebay.com/api-docs/user-guides/static/trading-user-guide/compatible-parts-api-support.html |
| `Zend_Mobile_Push` (Apns, C2dm, Gcm, Mpns) and the whole `Zend_Mobile` namespace | Apple retired the legacy binary APNs protocol in 2021. C2DM and legacy GCM were replaced by FCM, and MPNS (Windows Phone) is discontinued. | https://developer.apple.com/news/?id=c88acm2b |
| `Zend_Service_Twitter` | Implements the retired Twitter API v1.1. The current X API needs different endpoints and authentication. | https://docs.x.com/x-api/posts/manage-tweets/migrate/overview |
| `Zend_Service_LiveDocx` | User decision. No vendor evidence. | none (user decision) |
| `Zend_Service_StrikeIron` | User decision. No vendor evidence. | none (user decision) |
| `Zend_Cloud_StorageService_Adapter_S3`, `Zend_Cloud_DocumentService_Adapter_SimpleDb` (and `_SimpleDb_Query`), `Zend_Cloud_QueueService_Adapter_Sqs`, `Zend_Cloud_Infrastructure_Adapter_Ec2` | They wrap the excluded `Zend_Service_Amazon` and cannot work without it. WindowsAzure, Rackspace, FileSystem and ZendQueue adapters stay. | none (follows the exclusion of `Zend_Service_Amazon`) |

Also removed: the `Zend_Gdata_` and `Zend_Mobile_` psr-0 entries and the `library/Zend/Gdata.php` classmap entry in `composer.json`, `tests/Zend/Gdata/TestUtility/MockHttpClient.php` from `autoload-dev`, the `phpstan-php83.php` baseline file (its only entry belonged to `Zend_Gdata`), and 1448 entries from `phpstan-baseline.php`.

Also removed: the ReCaptcha test entries in `tests/phpunit.xml`, the `Zend_Captcha_ReCaptcha` documentation section in all languages, the matching Slovak translations, and the dead includes and prose for the Firebug log writer and Firebug DB profiler in the manual. `Zend_Log_Formatter_Firebug` stays. The Cloud Explorer demo and the Zend_Cloud manual pages now use Windows Azure and Rackspace instead of Amazon.
Kept: Flickr, Akismet, Audioscrobbler, ShortUrl, WindowsAzure, SqlAzure, Cloud and Service_Console. `Zend_Service_Rackspace` is kept for now and needs a follow-up decision (see `EXCLUDED_PACKAGES.md`).

#### Dropped excluded packages

The main repository also no longer contains the demos (`demos/Zend/OpenId`, `demos/Zend/Wildfire`, `demos/Zend/WebServices/Amazon`), documentation, `tests/phpunit.xml` suites, `TestConfiguration.php.dist` constants and `tests/runtests.sh` groups of these packages.

These packages are not forked and are removed from the `require`/`replace` of the main package:

| Package | Reason | Evidence |
|---|---|---|
| `zendframework1-service-recaptcha` | Zend_Service_ReCaptcha implements reCAPTCHA v1, which Google shut down on 2018-03-31. | https://developers.google.com/recaptcha/docs/changelog |
| `zendframework1-log-writer-firebug` | Firebug reached end of life in 2017 and the FirePHP extension is gone. | https://github.com/firebug/firebug/issues/8093 |
| `zendframework1-service-amazon` | Product Advertising API 4 was shut down in 2020. User decision. | https://affiliate-program.amazon.com/help/node/topic/GUVFJTV7MGMMNY94 |
| `zendframework1-wildfire` | The Wildfire/FirePHP protocol has no maintained client. User decision. | https://github.com/firephp/firephp-extension |
| `zendframework1-openid` | OpenID 2.0 is superseded by OpenID Connect. User decision. | https://openid.net/developers/specs/ |
| `zendframework1-auth-adapter-openid` | Wraps openid. User decision. | https://openid.net/developers/specs/ |

Consequences for kept packages:

- `zendframework1-captcha` no longer depends on `service-recaptcha`. The ReCaptcha captcha adapter is unusable.
- `zendframework1-db` no longer depends on `wildfire`. `Zend_Db_Profiler_Firebug` is unusable.
