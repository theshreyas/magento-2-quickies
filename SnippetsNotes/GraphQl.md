**GraphQL available context params**
```sh
$context == Magento\GraphQl\Model\Query\Context

$customerId = $context->getUserId();

$userType = $context->getUserType()
# \Magento\Authorization\Model\UserContextInterface::USER_TYPE_INTEGRATION = 1;
# \Magento\Authorization\Model\UserContextInterface::USER_TYPE_ADMIN = 2;
# \Magento\Authorization\Model\UserContextInterface::USER_TYPE_CUSTOMER = 3;
# \Magento\Authorization\Model\UserContextInterface::USER_TYPE_GUEST = 4;

$storeId = (int)$context->getExtensionAttributes()->getStore()->getId();
$context->getExtensionAttributes()->getIsCustomer(); //boolean
$context->getExtensionAttributes()->getCustomerGroupId(); //integer|null
```
**Disable GraphQL Introspection**
Edit app/etc/env.php
```sh
'graphql' => [
        'disable_introspection' => true,
]
```
https://devhooks.in/blog/how-to-disable-graphql-introspection-in-magento-2

**Change GraphQL Endpoint**
add di.xml in your custom module
```sh
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="Magento\Framework\App\AreaList">
        <arguments>
            <argument name="areas" xsi:type="array">
                <item name="graphql" xsi:type="array">
                    <item name="frontName" xsi:type="string">custom43_graphql</item>
                </item>
            </argument>
        </arguments>
    </type>
</config>
```
Now, we can access our graphql using the below URL.
https://yourdomain.com/custom43_graphql

https://devhooks.in/blog/how-to-change-graphql-endpoint-in-magento-2

**Adobe recommends that you use authorization tokens instead of session cookies for GraphQL requests.**
```sh
bin/magento config:set graphql/session/disable 1
```
https://developer.adobe.com/commerce/webapi/graphql/usage/authorization-tokens/#session-cookies