|                       SSH Command                       |          Shortcut          |                                             Description                                            |
|:-------------------------------------------------------:|:--------------------------:|:--------------------------------------------------------------------------------------------------:|
|                           help                          |              h             |                                     Displays help for a command                                    |
|                   php bin/magento list                  |      php bin/magento l     |                                           Lists commands                                           |
|            php bin/magento admin:user:create            |    php bin/magento a:u:c   |                                      Creates an administrator                                      |
|            php bin/magento admin:user:unlock            |    php bin/magento a:u:u   |                                        Unlock Admin Account                                        |
|             php bin/magento app:config:dump             |                            |                                     Create dump of application                                     |
|            php bin/magento app:config:import            |                            |               Import data from shared configuration files to appropriate data storage              |
|               php bin/magento cache:clean               |     php bin/magento c:c    |                                        Cleans cache type(s)                                        |
|              php bin/magento cache:disable              |     php bin/magento c:d    |                                       Disables cache type(s)                                       |
|               php bin/magento cache:enable              |     php bin/magento c:e    |                                        Enables cache type(s)                                       |
|               php bin/magento cache:flush               |     php bin/magento c:f    |                             Flushes cache storage used by cache type(s)                            |
|               php bin/magento cache:status              |     php bin/magento c:s    |                                         Checks cache status                                        |
|          php bin/magento catalog:images:resize          |    php bin/magento c:i:r   |                                   Creates resized product images                                   |
|    php bin/magento catalog:product:attributes:cleanup   |   php bin/magento c:p:a:c  |                                 Removes unused product attributes.                                 |
|           php bin/magento config:sensitive:set          |                            |                                 Set sensitive configuration values                                 |
|                php bin/magento config:set               |                            |                                     Change system configuration                                    |
|               php bin/magento config:show               |                            | Shows configuration value for given path. If path is not specified, all saved values will be shown |
|               php bin/magento cron:install              |                            |                           Generates and installs crontab for current user                          |
|               php bin/magento cron:remove               |                            |                                     Removes tasks from crontab                                     |
|                 php bin/magento cron:run                |     php bin/magento c:r    |                                        Runs jobs by schedule                                       |
|          php bin/magento customer:\hash:upgrade         |    php bin/magento c:h:u   |                      Upgrade customer’s hash according to the latest algorithm                     |
|             php bin/magento deploy:mode:set             |   php bin/magento d:m:set  |                                        Set application mode.                                       |
|             php bin/magento deploy:mode:show            |   php bin/magento d:m:sho  |                                 Displays current application mode.                                 |
|               php bin/magento dev:di:info               |                            |             Provides information on Dependency Injection configuration for the Command.            |
|          php bin/magento dev:query-log:disable          |                            |                                      Disable DB query logging                                      |
|           php bin/magento dev:query-log:enable          |                            |                                       Enable DB query logging                                      |
|         php bin/magento dev:source-theme:deploy         |    php bin/magento d:s:d   |                           Collects and publishes source files for theme.                           |
|        php bin/magento dev:template-hints:disable       |                            |                  Disable frontend template hints. A cache flush might be required.                 |
|        php bin/magento dev:template-hints:enable        |                            |                  Enable frontend template hints. A cache flush might be required.                  |
|              php bin/magento dev:tests:run              |    php bin/magento d:t:r   |                                             Runs tests                                             |
|         php bin/magento dev:urn-catalog:generate        |    php bin/magento d:u:g   |            Generates the catalog of URNs to *.xsd mappings for the IDE to highlight xml.           |
|             php bin/magento dev:xml:convert             |    php bin/magento d:x:c   |                              Converts XML file using XSL style sheets                              |
|           php bin/magento i18n:collect-phrases          |    php bin/magento i1:c    |                                  Discovers phrases in the codebase                                 |
|                php bin/magento i18n:pack                |     php bin/magento i:p    |                                       Saves language package                                       |
|              php bin/magento i18n:uninstall             |     php bin/magento i:u    |                                    Uninstalls language packages                                    |
|               php bin/magento indexer:info              |     php bin/magento i:i    |                                       Shows allowed Indexers                                       |
|             php bin/magento indexer:reindex             |    php bin/magento i:rei   |                                           Reindexes Data                                           |
|              php bin/magento indexer:reset              |    php bin/magento i:res   |                                  Resets indexer status to invalid                                  |
|             php bin/magento indexer:set-mode            |    php bin/magento i:set   |                                        Sets index mode type                                        |
|            php bin/magento indexer:show-mode            |    php bin/magento i:sho   |                                          Shows Index Mode                                          |
|              php bin/magento indexer:status             |    php bin/magento i:sta   |                                       Shows status of Indexer                                      |
|              php bin/magento info:adminuri              |     php bin/magento i:a    |                                   Displays the Magento Admin URI                                   |
|            php bin/magento info:backups:list            |    php bin/magento i:b:l   |                                Prints list of available backup files                               |
|            php bin/magento info:currency:list           |    php bin/magento i:c:l   |                              Displays the list of available currencies                             |
|     php bin/magento info:dependencies:show-framework    | php bin/magento i:d:show-f |                          Shows number of dependencies on Magento framework                         |
|      php bin/magento info:dependencies:show-modules     |                            |                            Shows number of dependencies between modules                            |
| php bin/magento info:dependencies:show-modules-circular |                            |                        Shows number of circular dependencies between modules                       |
|            php bin/magento info:language:list           |    php bin/magento i:l:l   |                           Displays the list of available language locales                          |
|            php bin/magento info:timezone:list           |    php bin/magento i:t:l   |                              Displays the list of available timezones                              |
|          php bin/magento maintenance:allow-ips          |     php bin/magento m:a    |                                  Sets maintenance mode exempt IPs                                  |
|           php bin/magento maintenance:disable           |    php bin/magento ma:d    |                                      Disables maintenance mode                                     |
|            php bin/magento maintenance:enable           |    php bin/magento ma:e    |                                      Enables maintenance mode                                      |
|            php bin/magento maintenance:status           |    php bin/magento ma:s    |                                  Displays maintenance mode status                                  |
|              php bin/magento module:disable             |    php bin/magento mo:d    |                                     Disables specified modules                                     |
|              php bin/magento module:enable              |    php bin/magento mo:e    |                                      Enables specified modules                                     |
|              php bin/magento module:status              |    php bin/magento mo:s    |                                     Displays status of modules                                     |
|             php bin/magento module:uninstall            |     php bin/magento m:u    |                              Uninstalls modules installed by composer                              |
|            php bin/magento sampledata:deploy            |    php bin/magento sa:d    |                                     Deploy sample data modules                                     |
|            php bin/magento sampledata:remove            |   php bin/magento sa:rem   |                         Remove all sample data packages from composer.json                         |
|             php bin/magento sampledata:reset            |   php bin/magento sa:res   |                          Reset all sample data modules for re-installation                         |
|               php bin/magento setup:backup              |     php bin/magento s:b    |                  Takes backup of Magento Application code base, media and database                 |
|             php bin/magento setup:config:set            |    php bin/magento s:c:s   |                          Creates or modifies the deployment configuration                          |
|              php bin/magento setup:cron:run             |    php bin/magento s:c:r   |                            Runs cron job scheduled for setup application                           |
|          php bin/magento setup:db-data:upgrade          |  php bin/magento s:db-d:u  |                                Installs and upgrades data in the DB                                |
|         php bin/magento setup:db-schema:upgrade         |  php bin/magento s:db-s:u  |                                 Installs and upgrades the DB schema                                |
|             php bin/magento setup:db:status             |    php bin/magento s:d:s   |                            Checks if DB schema or data requires upgrade                            |
|             php bin/magento setup:di:compile            |    php bin/magento s:d:c   |            Generates DI configuration and all missing classes that can be auto-generated           |
|              php bin/magento setup:install              |     php bin/magento s:i    |                                  Installs the Magento application                                  |
|   php bin/magento setup:performance:generate-fixtures   |    php bin/magento s:p:g   |                                         Generates fixtures                                         |
|              php bin/magento setup:rollback             |    php bin/magento se:r    |                     Rolls back Magento Application codebase, media and database                    |
|       php bin/magento setup:static-content:deploy       |    php bin/magento s:s:d   |                                      Deploys static view files                                     |
|          php bin/magento setup:store-config:set         |    php bin/magento s:s:s   |          Installs the store configuration. Deprecated since 2.2.0. Use config:set instead          |
|             php bin/magento setup:uninstall             |    php bin/magento s:un    |                                 Uninstalls the Magento application                                 |
|              php bin/magento setup:upgrade              |    php bin/magento s:up    |                        Upgrades the Magento application, DB data, and schema                       |
|                php bin/magento store:list               |                            |                                     Displays the list of stores                                    |
|                    store:website:list                   |                            |                                    Displays the list of websites                                   |
|             php bin/magento theme:uninstall             |     php bin/magento t:u    |                                          Uninstalls theme                                          |
|              php bin/magento varnish:vcl:ge             |                            |                                                                                                    |


**Create Admin User**
```sh
php bin/magento admin:user:create --admin-user admin --admin-password admin123 --admin-email admin@email.com --admin-firstname john --admin-lastname cage
```

**Disable all Modules of single Vendor(Mageplaza_)**
```sh
php bin/magento module:status | grep Mageplaza_ | grep -v List | grep -v None | grep -v -e '^$'| xargs php bin/magento module:disable -f
```

**Disable MSI**
```sh
Issues have been observed with Magento MultiSource Inventory Module.It doesn't handle backorders correctly, has no option to decrease stock when order is placed (only when shipped). So, if you are using singlestore mode with single-source inventory, it is better to disable MSI modules.
```

**Disable MSI in Magento 2.4.2**
```sh
php bin/magento module:disable -f Magento_InventoryAdvancedCheckout Magento_InventoryBundleImportExport Magento_InventoryBundleProduct Magento_InventoryBundleProductAdminUi Magento_InventoryBundleProductIndexer Magento_InventoryCache Magento_InventoryCatalogSearch Magento_InventoryConfigurableProduct Magento_InventoryConfigurableProductAdminUi Magento_InventoryConfigurableProductFrontendUi Magento_InventoryConfigurableProductIndexer Magento_InventoryDistanceBasedSourceSelection Magento_InventoryDistanceBasedSourceSelectionAdminUi Magento_InventoryElasticsearch Magento_InventoryExportStock Magento_InventoryGraphQl Magento_InventoryGroupedProduct Magento_InventoryGroupedProductAdminUi Magento_InventoryGroupedProductIndexer Magento_InventoryImportExport Magento_InventoryInStorePickupAdminUi Magento_InventoryInStorePickupFrontend Magento_InventoryInStorePickupGraphQl Magento_InventoryInStorePickupMultishipping Magento_InventoryInStorePickupQuoteGraphQl Magento_InventoryInStorePickupSalesAdminUi Magento_InventoryInStorePickupShipping Magento_InventoryInStorePickupShippingAdminUi Magento_InventoryInStorePickupWebapiExtension Magento_InventoryLowQuantityNotificationAdminUi Magento_InventoryProductAlert Magento_InventoryRequisitionList Magento_InventoryReservationCli Magento_InventoryReservations Magento_InventorySalesAdminUi Magento_InventorySalesFrontendUi Magento_InventorySetupFixtureGenerator Magento_InventoryShipping Magento_InventoryShippingAdminUi Magento_InventorySourceSelection Magento_InventorySwatchesFrontendUi Magento_InventoryVisualMerchandiser Magento_InventoryWishlist Magento_Inventory Magento_InventoryAdminUi Magento_InventoryApi Magento_InventoryCatalog Magento_InventorySales Magento_InventoryCatalogAdminUi Magento_InventoryCatalogApi Magento_InventoryCatalogFrontendUi Magento_InventoryConfiguration Magento_InventoryConfigurationApi Magento_InventoryDistanceBasedSourceSelectionApi Magento_InventoryExportStockApi Magento_InventoryIndexer Magento_InventorySalesApi Magento_InventoryInStorePickupApi Magento_InventorySourceSelectionApi Magento_InventoryInStorePickup Magento_InventoryInStorePickupShippingApi Magento_InventoryInStorePickupSales Magento_InventoryInStorePickupSalesApi Magento_InventoryInStorePickupQuote Magento_InventoryLowQuantityNotification Magento_InventoryLowQuantityNotificationApi Magento_InventoryMultiDimensionalIndexerApi Magento_InventoryReservationsApi Magento_InventorySourceDeductionApi
```

**Disable MSI in Magento 2.3.3/2.3.4**
```sh
php bin/magento module:disable -f Magento_Inventory Magento_InventoryAdminUi Magento_InventoryApi Magento_InventoryBundleProduct Magento_InventoryBundleProductAdminUi Magento_InventoryCatalog Magento_InventorySales Magento_InventoryCatalogAdminUi Magento_InventoryCatalogApi Magento_InventoryCatalogSearch Magento_InventoryConfigurableProduct Magento_InventoryConfigurableProductAdminUi Magento_InventoryConfigurableProductIndexer Magento_InventoryConfiguration Magento_InventoryConfigurationApi Magento_InventoryGroupedProduct Magento_InventoryGroupedProductAdminUi Magento_InventoryGroupedProductIndexer Magento_InventoryImportExport Magento_InventoryIndexer Magento_InventoryLowQuantityNotification Magento_InventoryLowQuantityNotificationAdminUi Magento_InventoryLowQuantityNotificationApi Magento_InventoryMultiDimensionalIndexerApi Magento_InventoryProductAlert Magento_InventoryReservations Magento_InventoryReservationsApi Magento_InventoryCache Magento_InventorySalesAdminUi Magento_InventorySalesApi Magento_InventorySalesFrontendUi Magento_InventoryShipping Magento_InventorySourceDeductionApi Magento_InventorySourceSelection Magento_InventorySourceSelectionApi Magento_InventoryShippingAdminUi Magento_InventoryDistanceBasedSourceSelectionAdminUi Magento_InventoryDistanceBasedSourceSelectionApi Magento_InventoryElasticsearch Magento_InventoryExportStockApi Magento_InventoryReservationCli Magento_InventoryExportStock Magento_CatalogInventoryGraphQl Magento_InventorySetupFixtureGenerator Magento_InventoryAdvancedCheckout Magento_InventoryDistanceBasedSourceSelection Magento_InventoryRequisitionList Magento_InventoryGraphQl
```

**Set Base URL**
```sh
bin/magento setup:store-config:set --base-url="http://m2.store/"
bin/magento setup:store-config:set --base-url-secure="https://m2.store/"
```

**Generate Patch**
```sh
bin/magento setup:db-declaration:generate-patch app/code/Vendor/ModuleName PatchName
```

**Generate Test Data**
```sh
sudo php bin/magento setup:perf:generate-fixtures /var/www/html/m2/setup/performance-toolkit/profiles/ce/small.xml
```

**Generate Whitelist**
```sh
php bin/magento setup:db-declaration:generate-whitelist --module-name=YourModule_Name
```
