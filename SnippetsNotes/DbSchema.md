**TODO**
```sh
1. db_schema exhaustive file with all datatypes, with corresponding mysql column type 
/var/www/html/m3/vendor/magento/framework/Setup/Declaration/Schema/etc/types/
2. constraint, primary, foreign ,etc
3. mysql column types with maximum value it can hold
4. uninstall guide
	a.how to safelty uninstall module, how to delete tables as well
	b.how to remove modules installed via composer
	c.how to delete patches/column changes
	d.whitelist.json use? what if we dont have
	e.two modules altering same table?
	f.uninstall via command VS deleting directory and s:up
	
php bin/magento module:uninstall -r Hyva_Admin Hyva_AdminTest
composer remove hyva-themes/module-magento2-admin
composer remove hyva-themes/module-magento2-admin-test
php bin/magento setup:upgrade
```