# Magento 2 Graphql Order Tester
This script can be used to place test orders quickly using graphql APIs. Normally, we have to use postman or altair to test graphql queries, but constantly changing quote ids/tokens hinders the process.

## Screenshots
![Screenshot1](https://raw.githubusercontent.com/theshreyas/magento-2-quickies/main/media/MagentoGraphQlOrderFlowTester.gif)

[Watch the video](https://www.awesomescreenshot.com/video/31047374?key=cec0beb9cf37e20fce21e6f00b947694)

# Installation Instruction
1. Place graphql.php & graphqlQueries.php in pub directory.
2. Modify $graphqlEndpoint & $simpleProductSkuTest variables in graphqlQueries.php file.

3. Modify your magentodir/nginx.conf file to allow to execute graphql.php file

``
location ~ ^/(index|get|static|errors/report|errors/404|errors/503|health_check)\.php$ {
``

Update this part to:

``
location ~ ^/(index|get|static|errors/report|errors/404|errors/503|health_check|graphql)\.php$ {
``

4. now run graphql.php in your browser via
localmagentourl/graphql.php

# Notes
I have covered minimum basic apis to complete order flow, with only simple product types. You can modify graphql.php to add any new api. To modify the existing graphql queries/mutations, update graphqlQueries.php. 

# Support
Raise issue, if you want to request any feature/improvement/bug report.