**Magento Manual Installation steps**

*install nginx*
```sh
sudo apt update
sudo apt install nginx
```

*install php8.3*
```sh
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.3 php8.3-cli php8.3-fpm php8.3-{bcmath,ctype,curl,dom,fileinfo,filter,gd,hash,iconv,intl,json,libxml,mbstring,openssl,pcre,pdo_mysql,simplexml,soap,sockets,sodium,spl,tokenizer,xmlwriter,xsl,zip,zlib,libxml}
update php.ini settings
```

*install mysql*
```sh
sudo apt install mysql-server
sudo mysql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
sudo mysql_secure_installation
```

*install elasticsearch*
```sh
wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo gpg --dearmor -o /usr/share/keyrings/elasticsearch-keyring.gpg
echo "deb [signed-by=/usr/share/keyrings/elasticsearch-keyring.gpg] https://artifacts.elastic.co/packages/8.x/apt stable main" | sudo tee /etc/apt/sources.list.d/elastic-8.x.list
sudo apt update && sudo apt install elasticsearch
sudo systemctl start elasticsearch
sudo systemctl enable elasticsearch
sudo nano /etc/elasticsearch/elasticsearch.yml
```

```sh
node.name: "ubuntu"
cluster.name: magento 2.4.7
network.host: 127.0.0.1
http.port: 9200
xpack.security.enabled: false
```

sudo systemctl restart elasticsearch 
curl -X GET "localhost:9200/"
https://www.linuxtuto.com/how-to-install-magento-2-4-7-on-ubuntu-24-04

*install composer*
```sh
sudo apt install composer
check composer path
composer config --list --global | grep 'home'
update auth.json with your keys
/home/shreyas/.config/composer/auth.json
```

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
--cleanup-database;//updatesearchengine

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
```
--nginx config--
```sh
create nginx.conf in magentorootdir
edit fastcgi_backend -> fastcgi_backend_m3
add m3 in sites-available
update default in sites-available
create symlink
sudo ln -s /etc/nginx/sites-available/m3 /etc/nginx/sites-enabled/m3
add entry in /etc/hosts
127.0.0.1       m3.test
update m3/nginx.conf
sudo nginx -t
sudo service nginx restart
```
```sh
sudo rm -rf var/cache/* var/view_preprocessed/* var/page_cache/* generated/* pub/static/frontend/* pub/static/adminhtml/* && sudo php bin/magento setup:up && sudo php bin/magento s:d:c && sudo php bin/magento s:s:d -f &&  sudo php bin/magento cache:c && sudo php bin/magento cache:f
```
*setup rabbitmq*
https://www.rabbitmq.com/docs/install-debian
```sh
'queue' =>  [
    'amqp' =>  [
        'host' => '34.222.345.76', //host of RabbitMQ
        'port' => '5672', //Port on which RabbitMQ running. 5672 is default port
        'user' => 'admin', // RabbitMQ user name
        'password' => 'xxxxxxxxxxxxx', //RabbitMQ password
        'virtualhost' => '/', //The virtual host for connecting to RabbitMQ. The default is /.
        'ssl' => '',
    ],
],
```
*setup & test cron*