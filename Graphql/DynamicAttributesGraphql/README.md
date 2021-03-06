# Overview

## Dynamic Attribute Text Values

Graphql products query returns only ids for select or multiselect fields. This is quickfix which will allow to get Text Labels as well as Id Values.
 Compatible with Magento Community and Enterprise, versions 2.3.x - 2.4.x.

# Installation Instructions

## Install by copying files

1. Create an `app/code/Theshreyas/DynamicAttributesGraphql` directory in your Magento installation.
2. Download the latest "Source code" from this page: [https://github.com/theshreyas/magento-2-quickies/tree/main/Graphql/DynamicAttributesGraphql](https://github.com/theshreyas/magento-2-quickies/tree/main/Graphql/DynamicAttributesGraphql)
3. Extract the file and copy the contents into the `app/code/Theshreyas/DynamicAttributesGraphql` directory.
4. Run following commands from your root Magento installation directory:

    ```
    bin/magento module:enable --clear-static-content Theshreyas_DynamicAttributesGraphql
    bin/magento setup:upgrade
    bin/magento cache:flush
    ```
# Usage

## Graphql Input Payload
```
{
  products(filter: {sku: {eq: "testProduct"}}) {
    items {
        sku
        fabric
        work
        dynamicAttributes(fields: ["fabric","work"])
    }
  }
}
```
## Output Response

```
"sku": "testProduct",
"fabric": 60,
"work": 65,
"dynamicAttributes": "{
    "fabric_label":"Pure Silk",
    "fabric":"60",
    "work_label":"Tanchoi",
    "work":"65"
}",
```
You can customize according to your needs & retrieve the data at frontend from the json accordingly.