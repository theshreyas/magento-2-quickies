# Magento 2 Display Out of stock products at the end
Move out of stock products to the end of category page. 

To enable display of out of stock products, configure Stores->Configuration->Catalog->Inventory->Display Out of Stock Products->Yes

# Installation Instruction
```
- Copy the content of the repo to the Magento 2 app/code/Theshreyas/MoveOutofStockToLast
- Run command: php bin/magento setup:upgrade
- Run command: php bin/magento setup:di:compile
- Run Command: php bin/magento setup:static-content:deploy
- Now Flush Cache: php bin/magento cache:flush
```