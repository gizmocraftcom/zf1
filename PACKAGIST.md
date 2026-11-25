# Packagist Guide
Status: no gizmocraft package is submitted on Packagist yet. You submit each repository yourself.

## 1. Submit the packages (manual)
Submit each URL at https://packagist.org/packages/submit
- https://github.com/gizmocraftcom/zf1-exception
- https://github.com/gizmocraftcom/zf1-acl
- https://github.com/gizmocraftcom/zf1-crypt
- https://github.com/gizmocraftcom/zf1-mime
- https://github.com/gizmocraftcom/zf1-server
- https://github.com/gizmocraftcom/zf1-stdlib
- https://github.com/gizmocraftcom/zf1-eventmanager
- https://github.com/gizmocraftcom/zf1-xml
- https://github.com/gizmocraftcom/zf1-dom
- https://github.com/gizmocraftcom/zf1-json
- https://github.com/gizmocraftcom/zf1-config
- https://github.com/gizmocraftcom/zf1-loader
- https://github.com/gizmocraftcom/zf1-log
- https://github.com/gizmocraftcom/zf1-cache
- https://github.com/gizmocraftcom/zf1-registry
- https://github.com/gizmocraftcom/zf1-db
- https://github.com/gizmocraftcom/zf1-locale
- https://github.com/gizmocraftcom/zf1-currency
- https://github.com/gizmocraftcom/zf1-date
- https://github.com/gizmocraftcom/zf1-filter
- https://github.com/gizmocraftcom/zf1-ldap
- https://github.com/gizmocraftcom/zf1-log-writer-db
- https://github.com/gizmocraftcom/zf1-session
- https://github.com/gizmocraftcom/zf1-auth
- https://github.com/gizmocraftcom/zf1-auth-adapter-dbtable
- https://github.com/gizmocraftcom/zf1-auth-adapter-ldap
- https://github.com/gizmocraftcom/zf1-session-savehandler-dbtable
- https://github.com/gizmocraftcom/zf1-text
- https://github.com/gizmocraftcom/zf1-progressbar
- https://github.com/gizmocraftcom/zf1-translate
- https://github.com/gizmocraftcom/zf1-validate
- https://github.com/gizmocraftcom/zf1-filter-input
- https://github.com/gizmocraftcom/zf1-mail
- https://github.com/gizmocraftcom/zf1-uri
- https://github.com/gizmocraftcom/zf1-http
- https://github.com/gizmocraftcom/zf1-oauth
- https://github.com/gizmocraftcom/zf1-service
- https://github.com/gizmocraftcom/zf1-soap
- https://github.com/gizmocraftcom/zf1-validate-db
- https://github.com/gizmocraftcom/zf1-validate-file
- https://github.com/gizmocraftcom/zf1-file
- https://github.com/gizmocraftcom/zf1-validate-ldap
- https://github.com/gizmocraftcom/zf1-validate-sitemap
- https://github.com/gizmocraftcom/zf1-view
- https://github.com/gizmocraftcom/zf1-controller
- https://github.com/gizmocraftcom/zf1-auth-adapter-http
- https://github.com/gizmocraftcom/zf1-layout
- https://github.com/gizmocraftcom/zf1-controller-action-helper-contextswitch
- https://github.com/gizmocraftcom/zf1-controller-action-helper-ajaxcontext
- https://github.com/gizmocraftcom/zf1-log-writer-mail
- https://github.com/gizmocraftcom/zf1-navigation
- https://github.com/gizmocraftcom/zf1-paginator
- https://github.com/gizmocraftcom/zf1-rest
- https://github.com/gizmocraftcom/zf1-view-helper-action
- https://github.com/gizmocraftcom/zf1-view-helper-baseurl
- https://github.com/gizmocraftcom/zf1-view-helper-json
- https://github.com/gizmocraftcom/zf1-controller-action-helper-json
- https://github.com/gizmocraftcom/zf1-view-helper-layout
- https://github.com/gizmocraftcom/zf1-view-helper-partial
- https://github.com/gizmocraftcom/zf1-form
- https://github.com/gizmocraftcom/zf1-captcha
- https://github.com/gizmocraftcom/zf1-dojo
- https://github.com/gizmocraftcom/zf1-controller-action-helper-autocomplete
- https://github.com/gizmocraftcom/zf1-view-helper-pagination
- https://github.com/gizmocraftcom/zf1-view-helper-url
- https://github.com/gizmocraftcom/zf1-view-helper-navigation
- https://github.com/gizmocraftcom/zf1-application
- https://github.com/gizmocraftcom/zf1-test
- https://github.com/gizmocraftcom/zf1

Order: submit the 68 packages first, then `gizmocraft/zendframework1` (https://github.com/gizmocraftcom/zf1, the last URL), because the main package requires them.

## 2. Vendor ownership
The first Packagist user to submit a package with the `gizmocraft` vendor becomes the maintainer of that vendor.

## 3. Organization webhook (recommended)
Requires organization owner rights on gizmocraftcom.
Location:      https://github.com/organizations/gizmocraftcom/settings/hooks
Payload URL:   https://packagist.org/api/github?username=<packagist-user>
Content type:  application/json
Secret:        <packagist-api-token>
Events:        push only

## 4. Why this approach
The organization webhook is preferred over per-repository webhooks and over the Packagist GitHub app. It covers all current and future forks without per-repository setup, and it does not depend on one account's GitHub OAuth link.

The guide contains only the placeholders <packagist-user> and <packagist-api-token>. It never holds a real username or token.
## 5. After the packages are on Packagist
Each package and the main package list `vcs` entries under `repositories` in their `composer.json` so they install before they exist on Packagist. Once all packages are on Packagist these entries are redundant but harmless. Removing them is a follow-up for a later release and is not part of this fork program.

## 6. Optional: bulk submission through the Packagist API
Packagist has an endpoint that creates a package from a repository URL. It needs your main API token (Packagist profile, "Show API Token"), not the limited one, and Packagist marks it as unsafe. Send the credentials in the `Authorization` header, never in the URL:
```
curl -X POST -H 'Content-Type: application/json' -H 'Authorization: Bearer <packagist-user>:<packagist-api-token>' 'https://packagist.org/api/create-package' -d '{"repository":"<repository URL from the list above>"}'
```
Use your own Packagist username and API token in place of the placeholders. Do not commit them and do not paste them into shared logs.

The fork program keeps a script for this outside this repository (`fork-tools/scripts/submit-to-packagist.ts`). It submits the packages in the order of `PLAN.md`, components first and `gizmocraft/zendframework1` last, skips packages that are already on Packagist, and reads the credentials from the `PACKAGIST_USERNAME` and `PACKAGIST_API_TOKEN` environment variables of your own shell. Its default is a dry run.
