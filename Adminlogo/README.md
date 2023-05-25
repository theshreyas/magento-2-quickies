# Magento 2 Admin Logo
This module is used for adding custom logos in the admin


# Features
- Change admin login page logo
- Change admin dashboard logo
- Add logo to custom menu
- Add logo to the system configuration section


# Installation Instruction
```
- Copy the content of the repo to the Magento 2 app/code/Theshreyas/Adminlogo
- Run command: php bin/magento setup:upgrade
- Run command: php bin/magento setup:di:compile
- Run Command: php bin/magento setup:static-content:deploy
- Now Flush Cache: php bin/magento cache:flush
```
![Screenshots](https://raw.githubusercontent.com/theshreyas/magento-2-quickies/main/media/ChangeLogo.gif)


If you want to change the default hexagonal icon for custom modules check this :
https://webkul.com/blog/magento-2-change-default-icon-in-menu-for-custom-module/
