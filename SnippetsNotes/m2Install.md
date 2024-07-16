**Magento Manual Installation steps**

php required extensions
php8.3-intl dom mysql

```sh
cd /var/www/html
sudo mkdir m3
composer create-project --repository-url=https://repo.magento.com/ magento/project-enterprise-edition m3
cd /var/www/html/m3
find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
sudo chown -R :www-data . # Ubuntu
sudo chmod u+x bin/magento
for DB clean--
remove db/create blank m3
remove env.php
run setup:install
then setup:up c:f

for DB clean--

create db m3

sudo service elasticsearch start

bin/magento setup:install \
--base-url=http://m3.test/ \
--db-host=localhost \
--db-name=m3 \
--db-user=root \
--db-password=root \
--admin-firstname=admin \
--admin-lastname=admin \
--admin-email=admin@admin.com \
--admin-user=admin \
--admin-password=admin123 \
--language=en_US \
--currency=USD \
--timezone=America/Chicago \
--use-rewrites=1 \
--search-engine=elasticsearch7 --elasticsearch-host="localhost" --elasticsearch-port=9200 \
--cleanup-database;

php bin/magento config:set admin/security/admin_account_sharing 1
php bin/magento config:set admin/security/session_lifetime 30000
php bin/magento config:set admin/usage/enabled 0
php bin/magento config:set analytics/subscription/enabled 0
php bin/magento config:set graphql/session/disable 1
php bin/magento config:set oauth/consumer/enable_integration_as_bearer 1
php bin/magento config:set webapi/jwtauth/admin_expiration 600
php bin/magento config:set webapi/jwtauth/customer_expiration 600
bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth
(optional)
php bin/magento sampledata:deploy
php bin/magento cache:flush

Create
add m3 in sites-available
update default in sites-available
create symlink
sudo ln -s /etc/nginx/sites-available/m3 /etc/nginx/sites-enabled/m3
add entry in /etc/hosts
127.0.0.1       m3.test
update m3/nginx.conf
sudo nginx -t
sudo service nginx restart

sudo rm -rf var/cache/* var/view_preprocessed/* var/page_cache/* generated/* pub/static/frontend/* pub/static/adminhtml/* && sudo php bin/magento setup:up && sudo php bin/magento s:d:c && sudo php bin/magento s:s:d -f &&  sudo php bin/magento cache:c && sudo php bin/magento cache:f
```
