# Magento 2 Graphql Order Tester
This script can be used to place test orders quickly using graphql APIs. Normally, we have to use postman or altair to test graphql queries, but constantly changing quote ids/tokens hinders the process.

# Installation Instruction
```
Place graphql.php & graphqlQueries.php in pub directory.
Modify $graphqlEndpoint & $simpleProductSkuTest variables in graphqlQueries.php file.

Modify your magentodir/nginx.conf file to allow to execute graphql.php file
--before--
location ~ ^/(index|get|static|errors/report|errors/404|errors/503|health_check)\.php$ {
--after--
location ~ ^/(index|get|static|errors/report|errors/404|errors/503|health_check|graphql)\.php$ {

now run graphql.php in your browser via
localmagentourl/graphql.php
```

# Support
Raise issue, if you want to add any functionality here.