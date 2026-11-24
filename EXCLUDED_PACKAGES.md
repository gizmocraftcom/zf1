# Excluded Packages

## Obsolete API
| Package | Reason | Evidence |
|---|---|---|
| diablomedia/zendframework1-auth-adapter-openid | User decision (task 9): excluded together with openid, which it wraps. | https://openid.net/developers/specs/ |
| diablomedia/zendframework1-log-writer-firebug | Zend_Log_Writer_Firebug only emits Wildfire/FirePHP headers for the Firebug + FirePHP browser extension. Firebug reached end of life with Firefox 57 (2017) and the FirePHP extension repositories are marked DEPRECATED, so no supported client reads the output. The Wildfire headers are not understood by current Firefox/Chrome DevTools. | https://github.com/firebug/firebug/issues/8093 |
| diablomedia/zendframework1-openid | User decision (task 9): excluded. Zend_OpenId implements OpenID 2.0, superseded by OpenID Connect and dropped by nearly all providers; not maintained for PHP 8.6. | https://openid.net/developers/specs/ |
| diablomedia/zendframework1-service-amazon | User decision (task 9): excluded. Product Advertising API 4 was shut down on 2020-03-09; S3/SQS/EC2/SimpleDb classes target 2006/2009 API versions with SigV2 signing. | https://affiliate-program.amazon.com/help/node/topic/GUVFJTV7MGMMNY94 |
| diablomedia/zendframework1-service-recaptcha | Zend_Service_ReCaptcha implements reCAPTCHA v1 (VERIFY_SERVER http://www.google.com/recaptcha/api/verify, challenge/recaptcha_challenge_field). Google shut down reCAPTCHA v1 on 2018-03-31, so verify() can never succeed. MailHide additionally needs the mcrypt extension, which PHP removed in 7.2. | https://developers.google.com/recaptcha/docs/changelog |
| diablomedia/zendframework1-wildfire | User decision (task 9): excluded. The Wildfire/FirePHP protocol has no maintained client. Consequence: Zend_Db_Profiler_Firebug becomes unusable. | https://github.com/firephp/firephp-extension |

## Dependencies on excluded packages
| Active package | Excluded dependency | Resolution (dropped / reclassified) |
|---|---|---|
| diablomedia/zendframework1-captcha | diablomedia/zendframework1-service-recaptcha | dropped |
| diablomedia/zendframework1-db | diablomedia/zendframework1-wildfire | dropped |

## Missing PHP extensions
| Extension | Affected classes | Package |
|---|---|---|
| apc | Zend_Cache_Backend_Apc | diablomedia/zendframework1-cache |
| big_int | Zend_Crypt_Math_BigInteger (big_int probe) | diablomedia/zendframework1-crypt |
| ibm_db2 | Zend_Db_Adapter_Db2, Zend_Db_Statement_Db2 | diablomedia/zendframework1-db |
| lzf | Zend_Filter_Compress_Lzf | diablomedia/zendframework1-filter |
| mcrypt | Zend_Crypt_Math::randBytes (mcrypt_create_iv fallback, guarded by function_exists) | diablomedia/zendframework1-crypt |
| mcrypt | Zend_Filter_Encrypt_Mcrypt, Zend_Service_ReCaptcha_MailHide | diablomedia/zendframework1-filter |
| memcache | Zend_Cache_Backend_Memcached | diablomedia/zendframework1-cache |
| memcached | Zend_Cache_Backend_Libmemcached | diablomedia/zendframework1-cache |
| oci8 | Zend_Db_Adapter_Oracle, Zend_Db_Statement_Oracle | diablomedia/zendframework1-db |
| pdo_oci | Zend_Db_Adapter_Pdo_Oci | diablomedia/zendframework1-db |
| rar | Zend_Filter_Compress_Rar | diablomedia/zendframework1-filter |
| sqlsrv | Zend_Db_Adapter_Sqlsrv, Zend_Db_Statement_Sqlsrv | diablomedia/zendframework1-db |
| wincache | Zend_Cache_Backend_WinCache | diablomedia/zendframework1-cache |
| xcache | Zend_Cache_Backend_Xcache | diablomedia/zendframework1-cache |

## Needs decision
| Package | Open question |
|---|---|

## Removed classes in the main repository

These classes are not separate packages. They live in `library/` of the main repository and are removed from the `gizmocraft/zf1` fork in task 11.7.

**Status: DONE** in the main clone (commits 92c7b7ef8 library, f65cd380d tests, c16276a4f demos, 12cccd804 documentation, 7240ff730 composer/phpstan; see `CHANGELOG.md`, Breaking changes). Zend_Service_Ebay remnant (Abstract, Exception) removed in e6fcb27fa; demos, tests config and docs of the excluded packages removed in 3abfc907c, f866bd4e5, 29091003b. Remaining follow-up: `Zend_Service_Rackspace` (see below) and leftover mentions listed under "Leftovers".

| Class | Reason | Evidence |
|---|---|---|
| Zend_Gdata (library/Zend/Gdata/, library/Zend/Gdata.php) | Google Data APIs (ClientLogin, AuthSub, Calendar/Docs/Spreadsheets/Picasa/Books/Analytics GData endpoints) were shut down or replaced by REST APIs with OAuth 2. | https://developers.google.com/gdata/docs/auth/clientlogin ; https://workspaceupdates.googleblog.com/2014/06/calendar-gdata-api-google-calendar.html |
| Zend_Service_Yahoo | Yahoo BOSS search service was closed. | https://searchengineland.com/yahoo-to-close-boss-build-your-own-search-service-next-month-242046 |
| Zend_Service_Delicious | Delicious was bought by Pinboard and closed. | https://betanews.com/article/pinboard-buys-delicious-closes-it/ |
| Zend_Service_SlideShare | The public SlideShare API has been retired. | https://support.scribd.com/hc/en-us/articles/53231623793684-Slideshare-API-errors-the-public-API-has-been-retired |
| Zend_Service_Ebay_* (library/Zend/Service/Ebay/, formerly incl. Finding.php, Finding/) | eBay Finding API decommissioned in Feb 2025. It was the only eBay API implemented; Abstract and Exception were the only remaining classes, so Zend_Service_Ebay_* is now fully removed. | https://developer.ebay.com/api-docs/user-guides/static/trading-user-guide/compatible-parts-api-support.html |
| Zend_Mobile_Push (Apns, Gcm, Mpns, C2dm; library/Zend/Mobile/) | Apple retired the legacy binary APNs protocol in 2021. C2DM and legacy GCM were replaced by FCM, and MPNS (Windows Phone) is discontinued. Evidence link covers APNs only; the other three are stated from the vendors' public deprecations. | https://developer.apple.com/news/?id=c88acm2b |
| Zend_Service_Twitter | Implements the retired Twitter API v1.1. The current X API requires different endpoints and authentication. | https://docs.x.com/x-api/posts/manage-tweets/migrate/overview |
| Zend_Service_LiveDocx | User decision. No shutdown notice was found, so this is not backed by vendor evidence. | none (user decision) |
| Zend_Service_StrikeIron | User decision. No shutdown notice was found, so this is not backed by vendor evidence. | none (user decision) |

### Kept

Flickr, Akismet, Audioscrobbler, ShortUrl, WindowsAzure, SqlAzure, Cloud and Service_Console.

### Needs follow-up: Zend_Service_Rackspace

Kept for now. `Zend_Service_Rackspace_Abstract` uses the Rackspace v1.0 auth API (`auth.api.rackspacecloud.com`, `X-Auth-User`/`X-Auth-Key`), and `Zend_Service_Rackspace_Servers` is the first-generation Cloud Servers API. The classes are not clearly separable: Abstract, Files and Servers share one auth base, and `Zend_Cloud_StorageService_Adapter_Rackspace` and `Zend_Cloud_Infrastructure_Adapter_Rackspace` (Zend_Cloud is kept) depend on them. Evidence that the first-generation API is retired: https://docs-ospc.rackspace.com/cloud-servers/v2/release-notes/index.html. Decide later whether to remove the whole Rackspace set together with the two Cloud adapters.

### Leftovers (not removed, need a decision)
- `Zend_Cloud_{StorageService,DocumentService,QueueService,Infrastructure}_Adapter_{S3,SimpleDb,Sqs,Ec2}` (library, tests, docs `Zend_Cloud_*.xml`) depend on the excluded `Zend_Service_Amazon`; they cannot work without it. Their tests still read the removed `TESTS_ZEND_SERVICE_AMAZON_*` constants (guarded by `defined()`, so they skip).
- `Zend_Captcha_ReCaptcha` and `Zend_Form_Decorator_ReCaptcha` tests/docs (package captcha) and prose in `Zend_Captcha-Adapters.xml` still mention `Zend_Service_ReCaptcha` (now plain `classname`).
- `Zend_Log_Formatter_Firebug`, `Zend_Db_Profiler_Firebug` and their tests live in the active log/db packages; the Zend_Db_Profiler/Log-Writers docs still mention Firebug.

### Directories and files that task 11 must also remove or edit

- Library: `library/Zend/Gdata/`, `library/Zend/Gdata.php`, `library/Zend/Mobile/`, `library/Zend/Service/{Twitter,Yahoo,Delicious,SlideShare,LiveDocx,StrikeIron}/` with the matching `.php` files, `library/Zend/Service/Ebay/Finding/`, `library/Zend/Service/Ebay/Finding.php`. Two `@throws Zend_Service_Ebay_Finding_Exception` doc comments in `library/Zend/Service/Ebay/Abstract.php` need adjusting.
- Tests: `tests/Zend/Gdata/` (including `TestUtility/MockHttpClient.php`), `tests/Zend/Mobile/`, `tests/Zend/Service/{Twitter,Yahoo,Delicious,SlideShare,LiveDocx,StrikeIron}/`, `tests/Zend/Service/SlideShareTest.php`, `tests/Zend/Service/Ebay/Finding/`. Edit the matching suites in `tests/phpunit.xml` and entries in `tests/TestConfiguration.php.dist`.
- Demos: `demos/Zend/Gdata/`, `demos/Zend/Mobile/`, `demos/Zend/Service/LiveDocx/`, `demos/Zend/WebServices/Yahoo/`.
- Documentation (all languages under `documentation/manual/<lang>/`): `module_specs/Zend_Gdata*.xml`, `Zend_Mobile_Push-*.xml`, `Zend_Service_{Twitter,Twitter_Search,Yahoo,Delicious,SlideShare,LiveDocx,StrikeIron-*,Ebay_Finding}.xml`, plus references in `manual.xml.in`, `manual-print1.xml.in`, `manual-print2.xml.in` and `ref/requirements*.xml`. Remove `Zend_Gdata_` and `Zend_Mobile_` from the `psr-0` autoload, `library/Zend/Gdata.php` from the classmap, and `tests/Zend/Gdata/TestUtility/MockHttpClient.php` from `autoload-dev` in `composer.json`. Regenerate `phpstan-baseline.php` (about 2600 entries mention these classes) and fix `phpstan-php83.php`.

## Notes

- User decisions (task 9): service-amazon, wildfire, openid and auth-adapter-openid are excluded and not forked. They are removed from the main require/replace.
- `diablomedia/zendframework1-db` drops its wildfire dependency. `Zend_Db_Profiler_Firebug` becomes unusable.
- `captcha` drops service-recaptcha. `log-writer-firebug` (obsolete) and `auth-adapter-openid` (excluded) are not forked, so they need no dependency record.
- The main package `diablomedia/zendframework1` also requires openid, auth-adapter-openid, service-amazon and wildfire. Those entries are removed from its require/replace in task 11.
- The "Needs decision" table is empty: every open question has been decided.
- Required extensions of the active packages (dom, libxml, SimpleXML, iconv, ctype, session, hash, fileinfo, tokenizer) are all bundled with PHP 8.5. No required extension is missing.
- The "Missing PHP extensions" table lists optional or conditional extensions (suggested, or probed at runtime) that are not bundled with PHP 8.5 or 8.6.
