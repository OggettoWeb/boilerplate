#!/bin/sh

## Script for adapting database to local needs
## Arguments:
##  1. Database name
##  2. Magento un-secure base url
##  3. Magento secure base url
##  4. Domain for fake emails (like "foo.com")


MYSQL_DBNAME=$1
UNSECURE_BASE_URL=$2
SECURE_BASE_URL=$3
EMAILS_DOMAIN=$4

mysql ${MYSQL_DBNAME} << EOF

    # set base url
    REPLACE INTO core_config_data (scope, scope_id, path, value) VALUES
    ("default", 0, "web/unsecure/base_url", "${UNSECURE_BASE_URL}"),
    ("default", 0, "web/secure/base_url", "${SECURE_BASE_URL}");

    # change customer emails
    UPDATE customer_entity SET email = CONCAT(SUBSTR(MD5(RAND()), 1, 10), "@${EMAILS_DOMAIN}");
    UPDATE sales_flat_order SET customer_email = CONCAT(SUBSTR(MD5(RAND()), 1, 10), "@${EMAILS_DOMAIN}");
    UPDATE sales_flat_quote SET customer_email = CONCAT(SUBSTR(MD5(RAND()), 1, 10), "@${EMAILS_DOMAIN}");
    UPDATE newsletter_subscriber SET subscriber_email = CONCAT(SUBSTR(MD5(RAND()), 1, 10), "@${EMAILS_DOMAIN}");
    UPDATE sales_flat_order_address SET email = CONCAT(SUBSTR(MD5(RAND()), 1, 10), "@${EMAILS_DOMAIN}");
    UPDATE sales_flat_quote_address SET email = CONCAT(SUBSTR(MD5(RAND()), 1, 10), "@${EMAILS_DOMAIN}");

    # disable google analytics
    REPLACE INTO core_config_data (scope, scope_id, path, value) VALUES
    ("default", 0, "google/analytics/active", 0),
    ("default", 0, "google/analytics/account", "");

    # setup cache
    REPLACE INTO core_cache_option (code, value) VALUES
    ("block_html", 0),
    ("collections", 0),
    ("config", 0),
    ("config_api", 0),
    ("config_api2", 0),
    ("eav", 0),
    ("full_page", 0),
    ("layout", 0),
    ("translate", 0);

EOF
