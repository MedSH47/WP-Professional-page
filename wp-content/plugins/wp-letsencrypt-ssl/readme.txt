=== WP Encryption - One Click Free SSL Certificate & SSL / HTTPS Redirect to Force HTTPS, Security+ ===
Contributors: gowebsmarty, gwsharsha, freemius
Tags: security,ssl,https,https redirect,ssl certificate
Requires at least: 5.4
License: GPL3
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 7.4.0

Lifetime SSL solution & Security - Install free SSL certificate & enable HTTPS redirect, HTTPS mail, fix SSL errors, SSL score, SSL details & monitoring.

== Description ==

HTTPS Secure your WordPress site with SSL certificate provided by [Let's Encrypt®](https://letsencrypt.com) and force SSL / HTTPS sitewide, check your SSL score, fix insecure content & mixed content issues easily. Enable HTTPS secure padlock on your site within minutes.

[WP Encryption](https://wpencryption.com/?utm_source=wordpress&utm_medium=description&utm_campaign=wpencryption) plugin registers your site, verifies your domain, generates SSL certificate for your site in simple mouse clicks without the need of any technical knowledge. 

A typical SSL installation without WP Encryption would require you to generate CSR, prove domain ownership, provide your bussiness data and deal with many more technical tasks!.

= New Security Features - 1,000+ Reviews Special =

(V7.0) NEW Vulnerability Scanner + Security page - Enable important security protocols to safeguard your site.

### 5M+ SSL certificates generated - Switch to HTTPS easily ###

https://youtu.be/aKvvVlAlZ14

= REQUIREMENTS =
Linux hosting, OpenSSL, CURL, allow_url_fopen should be enabled.

== PRO FEATURES WORTH UPGRADING ==

https://youtu.be/jrkFwFH7r6o

* Automatic domain verification
* Automatic SSL certificate installation
* Automatic SSL renewal (Auto renews SSL certificate 30 days prior to expiry date)
* Wildcard SSL support - Install Wildcard SSL certificate for your primary domain that covers ALL sub-domains. Automatic DNS based domain verification for Wildcard SSL installation (DNS should be managed by cPanel or Godaddy)
* Multisite + Mapped domains support - Supports SSL installation for mapped domains
* Automatic Content Delivery Network(CDN) to boost your site performance (Annual Plan Only)
* Blocks SQL injection, XSS, Shellshock, Remote File Inclusion, Apache Structs Exploits, Local File Inclusion attacks.
* Blocks common web application vulnerabilities and common WordPress attacks.
* Blocks invalid user agents, unknown user agents, CSRF, Convicted bot traffic, Spam & abuse, Probing & forced browsing, Brute force attacks.
* Top notch one to one priority support - Live Chat, Email, Premium Support Forum
* SSL installation help for non-cPanel sites
* Daily vulnerability scan & notification

[BUY PREMIUM VERSION](https://wpencryption.com/?utm_source=wordpress&utm_medium=premiumfeatures&utm_campaign=wpencryption)

== FREE SSL PLUGIN FEATURES ==
* Verify domain ownership and generate free SSL certificate
* Secure webmail and email with HTTPS
* Download generated SSL certificate, key and Intermediate certificate files
* Force HTTPS / Enable HTTPS 301 redirection sitewide in one click
* HTTPS redirection includes redirect loop fix for Cloudflare, StackPath, Load balancers and reverse proxies.
* SSL Health page - Track your SSL score and control various SSL & Security features like HSTS strict transport security Header, HttpOnly secure cookies, etc,.
* Enable important security headers including X-XSS-Protection, X-Content-Type-Options, Referrer-Policy
* Enable mixed content / insecure content fixer
* SSL monitoring & Automatic email notification prior to SSL certificate expiration

(Optional) Running WordPress on a specialized VPS/Dedicated server without cPanel? You can download the generated SSL certificate files easily via "Download SSL Certificates" page and install it on your server by modifying server config file via SSH access as explained in our [DOCS](https://wpencryption.com/docs/). 

== (New) Vulnerability Scanner in v6.0 ==

Navigate to SSL Health & Security page and run the vulnerability scanner to scan your WordPress, Plugins and Themes for known vulnerabilities. Keep everything updated to stay secure.

== ADVANCED HTTP SECURITY HEADERS ==

Safeguard your site from cross-site scripting attacks, clickjacking, MIME sniffing attacks.

* Enable HTTPS Strict Transport Security Header to avoid request protocol downgrading
* Disable directory listing to avoid directory traversing
* Enable X-XSS protection, secure cookies, X-Content-Type-Options to avoid cross site scripting and MIME sniffing

== Switch to HTTPS in seconds ==

* Secure HTTPS browser padlock in minutes.

* Free domain validated (DV) SSL certificates are provided by Let's Encrypt (A non profit Global certificate Authority).

* SSL encryption ensures protection against man-in-middle attacks by securely encrypting the data transfer between client and your server.

== Why does My WordPress site need SSL? ==
1. SEO Benefit: Major search engines like Google ranks SSL enabled sites higher compared to non SSL sites. Thus bringing more organic traffic for your site.

2. Data Encryption: Data transmission between server and visitor are securely encrypted on a SSL site thus avoiding any data hijacks in-between the transmission(Ex: personal information, credit card information).

3. Trust: Google chrome shows non-SSL sites as 'insecure', bringing a feel of insecurity in website visitors.

4. Authentic: HTTPS green padlock represents symbol of trust, authenticity and security.

= Translations =

Many thanks to the generous efforts of our translators.

If you would like to translate plugin to your language, [Feel free to sign up and start translating!](https://translate.wordpress.org/projects/wp-plugins/wp-letsencrypt-ssl/)

= Show Your Support =

* If you find any issue, please submit a bug via support forum.

== LOVE WP ENCRYPTION SSL PLUGIN? =

If you find this plugin useful, please leave a [positive review](https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/). Your reviews are our biggest motivation for further development of plugin.

== Installation ==	
1. Make a backup of your website and database
2. Download the plugin
3. Upload the plugin to the wp-content/plugins directory,
4. Go to “plugins” in your WordPress admin, then click activate.
5. You will now see WP Encryption option on your left navigation bar. Click on it and follow the step by step guide.

== Frequently Asked Questions ==

= Does installing the plugin will instantly turn my site https? =
Installing SSL certificate is a server side process and not as straight forward as installing a ready widget and using it instantly. You will have to follow some simple steps to install SSL for your WordPress site. Our plugin acts like a tool to generate and install SSL for your WordPress site. On FREE version of plugin - You should manually go through the SSL certificate installation process following the simple video tutorial. Whereas, the SSL certificates are easily generated by our plugin by running a simple SSL generation form.

= How to temporarily disable HTTPS redirect =
By adding below line of code to your wp-config.php file, All SSL enforcements like HSTS, Upgrade insecure requests, redirect to HTTPS, mixed content fixer will be disabled. Please check your .htaccess file for any other HTTPS enforcement related codes and remove it.

define("WPLE_DISABLE_HTTPS");

= I already have SSL certificate installed, how to activate HTTPS? =
If you already have SSL certificate installed, You can use WP Encryption plugin purely for HTTPS redirection & SSL enforcing purpose. All you need to do is enable "Force HTTPS" feature in this plugin.

= Secure webmail & email server with an SSL/TLS Certificate =
Starting from WP Encryption v5.4.8, you can now secure your webmail & incoming/outgoing email server [following this guide](https://wpencryption.com/secure-webmail-with-https/)

= How to install SSL for both www & non-www version of my domain? =
First of all, Please make sure you can access your site with and without www. Otherwise you will be not able to complete domain verification for both www & non-www together. If both are accessible, You will see **"Generate SSL for both www & non-www"** option on SSL install form. Otherwise, this option will be hidden.

= Unable to check "Generate SSL for both www & non-www domain"? =
Please make sure you can access your site with and without www. Otherwise you will be not able to complete domain verification for both www & non-www together. You can also force enable this checkbox by appending **includewww=1** to page url i.e., **/wp-admin/admin.php?page=wp_encryption&includewww=1**

= Images/Fonts not loading on HTTPS site after SSL certificate installation - Insecure Content / Mixed Content issue? =
Images on your site might be loading over http:// protocol, please enable "Force HTTPS via WordPress" feature of WP Encryption. If you have Elementor page builder installed, please go to Elementor > Tools > Replace URL and replace your http:// site url with https://. Make sure you have SSL certificates installed and browser padlock shows certificate as valid before forcing these https measures. If you have too many mixed content errors because of http:// resources loaded in your css, js or external links, We recommend using "Really Simple SSL" plugin along with WP Encryption.

= How do I renew SSL certificate =
You can click on STEP 1 in progress bar or Renew SSL button (which will be enabled during last 30 days of SSL expiry date) and follow the same initial process of SSL certificate generation to renew the certificates.

= Do you support Wildcard SSL? =
Wildcard SSL support is included with PRO version

= SSL Certificates renewed but new certs not showing in frontend =
This might happen for non cPanel sites, all you need to do is reboot the server instance once.

= How to revert back to HTTP in case of force HTTPS failure? =
Please follow the revert back instructions given in [support thread - Forced SSL via Htaccess](https://wordpress.org/support/topic/locked-out-after-force-ssl-via-htaccess-method/) and [support thread - Forced SSL via WordPress](https://wordpress.org/support/topic/locked-out-unable-to-access-site-after-forcing-https-2/) accordingly.

= I am getting some errors during SSL installation =
Feel free to open a ticket in this plugin support form and we will try our best to resolve your issue.

= Should I configure anything for auto renewal of SSL certificates to work after upgrading to PRO version? =
You don't need to configure anything. Once after you upgrade to PRO version and activate PRO plugin on your site, the auto renewal of SSL certificates will start working in background according to 60 days schedule i.e., 30 days prior to SSL certificate expiry date.

= Site with Elementor is showing insecure https padlock even if SSL certificate is installed = 
If your site built with Elementor is showing insecure https padlock even if SSL certificate is properly installed & valid, it could be due to insecure http:// assets being loaded in page builder blocks like image block. Please go to Elementor > Tools > Replace URL and replace http://yoursite.com with https://yoursite.com


== Disclaimer ==

WP Encryption uses SSLLabs API for SSL scan & detection. By using the plugin, you agree to terms & conditions of [SSLLabs](https://www.ssllabs.com/downloads/Qualys_SSL_Labs_Terms_of_Use.pdf)

By enabling the Vulnerability Scan feature, you agree to terms & conditions of [WPVulnerability Database API](https://vulnerability.wpsysadmin.com). The information provided by the information database comes from different sources that have been reviewed by third parties. There is no liability of any kind for the information.

Security is an important subject regarding SSL/TLS certificates, of course. It is obvious that your private key, stored on your web server, should never be accessible from the web. When the plugin created the keys directory for the first time, it will store a .htaccess file in this directory, denying all visitors. Always make sure yourself your keys aren't accessible from the web! We are in no way responsible if your private keys go public. If this does happen, the easiest solution is to check folder permissions on your server and make sure public access is forbidden for root folders. Next, create a new certificate.

== Screenshots ==
1. SSL Health & Security page with realtime SSL score
2. Generate and Install free SSL certificate while Agreeing to TOS
3. SSL certificate generation successful message
4. Download/Copy generated SSL certificate & key
5. Force HTTPS via htaccess or WordPress method
6. Mixed Content Scanner to identify insecure contents on HTTPS site

== Changelog ==

= 7.4.0 =
* Important - Leaf signature issue fix with dynamic CA bundle. Update immediately.

= 7.3.0 =
* Important - New R11 Intermediate CA added.

= 7.2.0 =
* ajax plugin activation error fix
* fixed issue with vulnerability scan setting not saving
* store last csr for premium install process
* re-check active ssl before showing short expiry & RF notice
* mixed content scanner result improved
* PRO - automatic SSL install for Plesk

= 7.1.0 =
* Free Version - Store SSL certificate & key in ssl/domain.com/ directory above web root to avoid public access in case htaccess is not supported
* Store keys as option if root dir access is restricted

= 7.0.0 =
* PRO - CERT PANEL improvements
* Free - New Vulnerability scanner & security page
* Security Headers enforcing via WP hook

= 6.6.0 =
* http file names correction
* SSL labs scan improvements
* Freemius SDK update to 2.6.2
* Fixed issue with http verification file names

= 6.5.0 =
* PRO - resolved php path issue in crontab
* Revert to WP cron when crontab update fail
* php errors fixed
* SSL Renewal improvements
* Waited DNS propagation code flow fix during renewal process
* Please use RESET & run SSL install form once after update

= 6.4.0 =
* Intermediate CA fix
* Fixed php error cases in 2-3 places
* Handle fatal error when emailing certs
* Daily SSL scan
* Reminder admin notices will be cleared based on daily scan result

= 6.3.7 = 
* PRO - Removed advert on plugins page

= 6.3.6 =
* PRO - Curl IP binding fix

= 6.3.5 =
* Requires minimum php 7.0
* PRO - Vulnerability daily scan & email notification
* PRO - retain existing cert & key upon renewal abort
* PRO - Set interface to avoid LE directory rate limits
* PRO - Email notification when last 10 days to expiry

= 6.3.2 =
* Daily vulnerability scan and email notification
* Mixed content scanner results improved
* SSL Health page css fixes

= 6.3.1 =
* IMPORTANT - PLEASE UPDATE
* HSTS header typo fix - please disable & re-enable HSTS header in SSL Health page
* Generate SSL for www & non-www checkbox fix
* php warning fix

= 6.3.0 =
* Important update - www & non-www domain check fix
* Freemius sdk update

= 6.2.1 =
* PRO - Cron rate hitting fix

= 6.2.0 =
* PRO - plugin updation issue fix
* PRO - updated php cron path
* Lets Debug removed
* SSLLabs API integration
* SSL grade block in SSL health page
* Use SSLLabs as fallback for ssl verification failure
* www & non-www checkbox fix for SSL install form

= 6.1.3 =
* Removed source IP usage for now due to issues

= 6.1.0 =
* Auto re-create invalid order upon verification failure
* clean acme-challenge on reset
* source ip support for LE calls to avoid rate limits

= 6.0 =
* (New) Vulnerability Scanner in SSL Health & Security Page
* layout cleanups

= 5.11.5 =
* POST JWS not signed issue fix
* HSTS & CSP set via htaccess
* log authz response only when invalid status
* PRO - re-try after 30mins of DNS propagation Fixed
* PRO - cron holding
* PRO - include www has to be verified and not set by default

= 5.11.4 =
* PRO - Complete state conflict fix
* PRO - Better debugging with logging
* PRO - Hold daily SSL cron in case of fatal failure - reset or success to remove the hold
* Full auth resp logging
* Acmename resolution

= 5.11.2 =
* Slowness & error fix for previous release

= 5.11.1 =
* improved cp detection
* improved logging

= 5.11.0 =
* Major code re-build
* Improved SSL renewal crons for PRO
* pricing v2
* priority based SSL state flow
* renew button always enabled
* Mapped domains SSL support for native WP mapping in multisite

= 5.10.4 =
* PRO - Bundle JS fix

= 5.10.3 =
* PRO - Cert Panel blank page issue fix
* PRO - Automatic verification

= 5.10.1 =
* PRO - Cert Panel redirection fix

= 5.10.0 =
* PRO only release

= 5.9.5 =
* Composer issue fix
* PRO - Godaddy DNS error fix
* PRO - proceed to verification after waiting

= 5.9.4 =
* Php error fix for previous release

= 5.9.3 =
* htaccess handling improved
* additional security headers
* interface cleanup

= 5.9.2 =
* PRO - Re-try unsuccessful renewals improved
* Free - case when either http or dns challenges are missing

= 5.9.1 =
* CSS improvements
* Freemius SDK update

= 5.9.0 =
* PRO - resolved a php bug related to SSL renewal
* PRO - Correctly set success screen after successful renewals
* PRO - Visibility of log and fresh install ssl
* Free - pre-check if http verification possible

= 5.8.5 =
* FS SDK update
* Other improvements

= 5.8.4 =
* SSL monitoring
* security features added

= 5.8.2 =
* HTTP challenge fail cases

= 5.8.1 =
* paragraph improvements
* experience level input

= 5.8.0 =
* Freemius SDK update
* DNS verification improved
* helpful tooltips and info
* defined checks and many more improvements
* PRO - cron hook improved, force spmode, improved security

= 5.7.19 =
* PRO - Fixed expiry date issue in cron tab
* PRO - No cron renewal for SP mode users

= 5.7.18 =
* PRO - Fixed issue with cron tab

= 5.7.17 =
* Function exists check
* help with http local verification

= 5.7.16 =
* Moved backup suggestion to top
* PRO - local check DNS and auto proceed later
* PRO - Cron based SSL renewal after all WP Cron jobs fail

= 5.7.14 =
* Backup suggestion

= 5.7.13 =
* HTTP code checking removed for acme-challenge

= 5.7.11 =
* Important: Logic correction for HTTP based domain verification

= 5.7.10 =
* SDK update

= 5.7.9 =
* Improved HTTP challenge verification

= 5.7.8 =
* Active SSL info block for SSL health page to show installed SSL details
* Sleep before ACME DNS verification
* improved logging

= 5.7.6 =
* HTTP based domain verification - correct .txt extension
* log pending authorizations when SSL domain verification fail

= 5.7.5 =
* Remove certain options upon plugin deactivation
* fopen error catch during ssl expiration check process

= 5.7.4 =
* Log why order got invalid later
* Wording fixes
* PRO - ability to input cpanel host
* PRO - admin notice when auto renewal failed
* PRO - different flows rechecked

= 5.7.2 =
* Improved CSS
* Improved explanations
* Fix - don't show empty rows in advanced mixed content scanner
* Added - How it works Faq
* No more review requests for PRO users

= 5.7.1 =
* Updated - Intermediate cert priority. Please RESET and re-run SSL install form.

= 5.7.0 =
* New - Advanced Insecure content scanner
* Fixed path issue for subdirectory based WordPress installations
* DNS verify ajax issue fix

= 5.6.3 =
* Fixed the ajax call for "generate SSL for both www & non-www" checkbox

= 5.6.2 =
* Ajax check before enabling both "generate SSL for www & non-www" Checkbox 

= 5.6.1 = 
* SSL health in admin toolbar
* Improved instructions
* Always show checbkox to generate SSL for www & non-www together
* Activator SELF class error fix
* Fixed SSL certificate expiry date in email
* Many more improvements

= 5.6.0 =
* Check valid SSL before enabling HSTS & SSL Health page settings
* Security updates

= 5.5.0 =
* All new SSL Health page :)
* HSTS Strict Transport Security
* Mixed content fixer
* Important Security Headers
* Upgrade Insecure Requests

= 5.4.8 =
* Secure webmail with an SSL Certificate
* Make htaccess writable

= 5.4.7 =
* Fix for PRO users - PLEASE UPDATE

= 5.4.6 =
* Get more insights on SSL verification via Letsdebug

= 5.4.4 =
* PHP Fatal error fix

= 5.4.2 =
* Image width
* Activation error
* Better logging

= 5.4.1 =
* Session handling fix
* Ajax url fix
* Improved instructions

= 5.4.0 =
* CA Signature fix
* Admin color tweaks
* PRO - Fix for auto renewal

= 5.3.16 =
* SSL Install page redesign
* Special note for SPMode
* Plugin interface changes

= 5.3.13 =
* Fixed wpleauto

= 5.3.12 =
* Ajaxified SSL notices
* UI Improved
* Improved SSL alerts for PRO

= 5.3.11 =
* Improved navigation
* Bug fix for DNS verification of SSL

= 5.3.10 =
* PRO - cPanel login check fix
* PRO - Minor bug fix

= 5.3.9 =
* Minor pricing changes
* Added support link

= 5.3.8 =
* PRO - Improved SPmode flow & cpanel backup method

= 5.3.6 =
* Ability to activate the plugin network wide
* PRO - Activate license network wide
* Minor bug fixes

= 5.3.5 =
* PRO - More precise DNS verification
* PRO - Bug fixes
* FREE - Get SSL certs emailed as attachment but enabling the option in "Download SSL certificates" page.

= 5.3.4 =
* SP mode redirect loop fix
* Cleaner plugin deactivation

= 5.3.3 =
* Double check auto renewal of SSL
* Bypass SSL verify peer
* Styling fixes + asset updates
* Privacy enabled youtube videos

= 5.3.1 =
* Added contact form
* Reduced plugin size
* Updated links
* SSL renewal reminder email
* removed BF banner

= 5.3.0 =
* Certificate chain fix - Please update
* FAQs updated

= 5.2.13 =
* SSL Leaf Signature issue fix

= 5.2.10 =
* Bug fixes for Premium SSL setup
* User flow fixes for SP Mode

= 5.2.4 =
* Optimized code
* minor bug fixes
* force generate SSL for www & non-www
* spmode related fixes

= 5.2.2 =
* SDK update
* minor link fixes

= 5.2.0 =
* SP mode for annual PRO users
* Faq & Videos moved to nav
* Bug Fix related to memory exhaust

= 5.1.11 =
* User flow improvements
* Improved error catching
* Improved instructions
* PLEASE UPDATE

= 5.1.8 =
* Identify mixed content issues
* minor fixes

= 5.1.6 =
* Fixed a bug with Manual DNS verification

= 5.1.5 =
* PRO - Fixed major bug related to Wildcard SSL - Please update

= 5.1.0 =
* Fixed - Minor bugs
* Improved - Cluster free SSL generate interface
* Improved - Complete user interface design
* Improved - Sub pages instead of confusing tabs
* Added - retain SSL stage
* Added - Force SSL improvements
* Added - Checkbox to generate SSL for both www & non-www domain
* PRO - Improved DNS automation
* PRO - Improved error handling
* PRO - Added important notifications

= 5.0.9 =
* Fixed - Download SSL tab not showing after success

= 5.0.8 =
* Fixed - DNS verification feature for http verification failures of noscript

= 5.0.7 =
* Added - Attempt http verification before offering manual verification options

= 5.0.6 =
* Improved - Domain verification interface
* Fixed - minor bug
* Fixed - Cron handling

= 5.0.4 =
* Added - SSL support for cPanel users with shell_exec function disabled
* PRO only release

= 5.0.0 =
* NEW - Upon various Non-cPanel user requests, Introducing FIREWALL plan for Non-cPanel sites
* PRO - New instant firewall setup wizard
* Improved - More cleaner admin interface
* Improved - Admin css, overall coding
* Added - Force HTTPS, FAQ, SSL videos as sub pages
* Fixed - minor php error