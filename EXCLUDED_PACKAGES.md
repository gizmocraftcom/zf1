# Excluded Packages

## Obsolete API
| Package | Reason | Evidence |
|---|---|---|
| diablomedia/zendframework1-log-writer-firebug | Zend_Log_Writer_Firebug only emits Wildfire/FirePHP headers for the Firebug + FirePHP browser extension. Firebug reached end of life with Firefox 57 (2017) and the FirePHP extension repositories are marked DEPRECATED, so no supported client reads the output. The Wildfire headers are not understood by current Firefox/Chrome DevTools. | https://github.com/firebug/firebug/issues/8093 |
| diablomedia/zendframework1-service-recaptcha | Zend_Service_ReCaptcha implements reCAPTCHA v1 (VERIFY_SERVER http://www.google.com/recaptcha/api/verify, challenge/recaptcha_challenge_field). Google shut down reCAPTCHA v1 on 2018-03-31, so verify() can never succeed. MailHide additionally needs the mcrypt extension, which PHP removed in 7.2. | https://developers.google.com/recaptcha/docs/changelog |

## Dependencies on excluded packages
| Active package | Excluded dependency | Resolution (dropped / reclassified) |
|---|---|---|
| diablomedia/zendframework1-captcha | diablomedia/zendframework1-service-recaptcha | dropped |

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
| diablomedia/zendframework1-service-amazon | Mixed package. The main Zend_Service_Amazon/Query/Item classes call the Product Advertising API 4 (AWSECommerceService 2011-08-01), which Amazon shut down on 2020-03-09 (PA-API 5 is itself deprecated in favour of the Creators API). The S3, SQS, EC2 and SimpleDb classes target 2006/2009 API versions and S3 SigV2 signing, which AWS has turned off for newer regions/buckets. Whether any of these classes is still useful needs a human call. Recommendation: OBSOLETE. |
| diablomedia/zendframework1-wildfire | Wildfire/FirePHP protocol has no maintained client (see log-writer-firebug), but it is required by zendframework1-db (Zend_Db_Profiler_Firebug) and zendframework1-log-writer-firebug. Marking it OBSOLETE forces every package depending on db to drop or reclassify the dependency. Recommendation: OBSOLETE and drop the dependency from db. |

## Notes

- The resolution `dropped` for captcha -> service-recaptcha is provisional and awaits the user's confirmation.
- Packages in "Needs decision" (diablomedia/zendframework1-service-amazon, diablomedia/zendframework1-wildfire) are neither forked nor excluded until the user decides.
- `diablomedia/zendframework1-db` requires `diablomedia/zendframework1-wildfire`. Its handling depends on the decision for wildfire.
- Required extensions of the active packages (dom, libxml, SimpleXML, iconv, ctype, session, hash, fileinfo, tokenizer) are all bundled with PHP 8.5. No required extension is missing.
- The "Missing PHP extensions" table lists optional or conditional extensions (suggested, or probed at runtime) that are not bundled with PHP 8.5 or 8.6.
