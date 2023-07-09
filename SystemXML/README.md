# Mage2 Module Theshreyas SystemXML

    ``theshreyas/module-systemxml``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
All System Configurations Reference

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Theshreyas`
 - Enable the module by running `php bin/magento module:enable Theshreyas_SystemXML`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require theshreyas/module-systemxml`
 - enable the module by running `php bin/magento module:enable Theshreyas_SystemXML`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - Text Field (allconfig/simplefields/text_field)

 - Textarea (allconfig/simplefields/textarea)

 - Encrypted Field (allconfig/simplefields/encrypted_field)

 - Yes / No (allconfig/dropdowns/yesno)

 - Enable Disable (allconfig/dropdowns/enable_disable)

 - Locale (allconfig/dropdowns/locale)

 - stores (allconfig/dropdowns/stores)

 - websites (allconfig/dropdowns/websites)

 - currency (allconfig/dropdowns/currency)

 - countries (allconfig/dropdowns/countries)

 - payments (allconfig/dropdowns/payments)

 - Order Statuses (allconfig/dropdowns/order_statuses)

 - order_status_processing (allconfig/dropdowns/order_status_processing)

 - order_status_new (allconfig/dropdowns/order_status_new)

 - category_displaymode (allconfig/dropdowns/category_displaymode)

 - category_staticblock (allconfig/dropdowns/category_staticblock)

 - Category Sort By (allconfig/dropdowns/category_sortby)

 - Product Layouts (allconfig/dropdowns/product_layout)

 - product_country (allconfig/dropdowns/product_country)

 - Product Types (allconfig/dropdowns/producttype)

 - Customer Groups (allconfig/dropdowns/customergroup)

 - Customer Stores (allconfig/dropdowns/customer_store)

 - Customer Websites (allconfig/dropdowns/customer_website)

 - Custom Values (allconfig/dropdowns/own)


## Specifications




## Attributes



