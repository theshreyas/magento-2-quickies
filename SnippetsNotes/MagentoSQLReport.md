```sh
https://github.com/akira28/magento-utils/tree/master/sql
```
#Retrieve SQL results into csv from remote mysql server

```sh
echo "SELECT i.order_id as order_id, i.product_id as product_id, i.sku, i.qty_ordered as qty,o.customer_id as customer_id, i.created_at as date
FROM sales_order_item i
inner join sales_order o on o.entity_id = i.order_id
WHERE i.created_at > '2020-09-20 10:33:07'" | mysql --host=10.10.11.45 --user=c_user --password=c74^6mew c_db_name > output.csv
```

#Configurable Products with attached children skus

```sh
SELECT 
    parent.sku as 'sku',
    GROUP_CONCAT(DISTINCT eav.attribute_code SEPARATOR ',') as 'configurable_attribute',
    GROUP_CONCAT(child.sku SEPARATOR ',') as 'simples_skus' 
FROM catalog_product_super_link 
    INNER JOIN catalog_product_entity as child ON catalog_product_super_link.product_id = child.entity_id
    INNER JOIN catalog_product_entity as parent ON catalog_product_super_link.parent_id = parent.entity_id
    INNER JOIN catalog_product_super_attribute as super ON  super.product_id = parent.entity_id
    INNER JOIN eav_attribute as eav ON eav.attribute_id = super.attribute_id
Group By parent.sku
```

#Clean Increments
-- Get all stores that use the wrong prefix autoincrement table for orders, invoices, etc.
-- E.g. the '2345' in order number '200002345' 
```sh
SELECT store_id,
         prefix,
         entity_type,
         sequence_table
  FROM sales_sequence_meta
  JOIN sales_sequence_profile
    ON sales_sequence_profile.meta_id = sales_sequence_meta.meta_id
 WHERE CAST(SUBSTRING_INDEX(sequence_table, "_", -1) AS UNSIGNED) <> store_id
 ORDER BY store_id;
```

#--Clean Prefixes
-- Get all stores where orders, invoices, etc use the wrong prefix
-- E.g. the '2' in order number '200002345'

```sh
SELECT store_id,
       prefix,
       entity_type,
       sequence_table
  FROM sales_sequence_meta
  JOIN sales_sequence_profile
    ON sales_sequence_profile.meta_id = sales_sequence_meta.meta_id
 WHERE prefix <> store_id
 ORDER BY store_id;
```
#Configurable Products with attached children skus

```sh
SELECT 
    parent.sku as 'sku',
    GROUP_CONCAT(DISTINCT eav.attribute_code SEPARATOR ',') as 'configurable_attribute',
    GROUP_CONCAT(child.sku SEPARATOR ',') as 'simples_skus' 
FROM catalog_product_super_link 
    INNER JOIN catalog_product_entity as child ON catalog_product_super_link.product_id = child.entity_id
    INNER JOIN catalog_product_entity as parent ON catalog_product_super_link.parent_id = parent.entity_id
    INNER JOIN catalog_product_super_attribute as super ON  super.product_id = parent.entity_id
    INNER JOIN eav_attribute as eav ON eav.attribute_id = super.attribute_id
Group By parent.sku
```

#Check Stock Status For Parent SKUs from Given List Of Child SKUs Using MySQL Query

```sh
SELECT
CHILD_RESULT.ChildSku as ChildSku,
CHILD_RESULT.ChildStockStatus as ChildStockStatus,
PARENT_CPE.sku as ParentSku,
CASE
   WHEN PARENT_CSI.is_in_stock = 1 THEN 'In Stock'
   WHEN PARENT_CSI.is_in_stock = 0 THEN 'Out Of Stock'
   ELSE 'No Data Found'
END as ParentStockStatus
FROM
(
   SELECT
   CPE.entity_id as ChildProductId,
   CPE.sku as ChildSku,
   CASE
       WHEN CSI.is_in_stock = 1 THEN 'In Stock'
       WHEN CSI.is_in_stock = 0 THEN 'Out Of Stock'
       ELSE 'No Data Found'
   END as ChildStockStatus,
   CPR.parent_id AS ParentId
   FROM `catalog_product_entity` AS CPE
   INNER JOIN `cataloginventory_stock_item` AS CSI ON CSI.product_id = CPE.entity_id
   INNER JOIN `catalog_product_relation` AS CPR ON CPR.child_id = CPE.entity_id
   WHERE CPE.sku IN ("child_sku_1","child_sku_2")
) AS CHILD_RESULT
INNER JOIN `cataloginventory_stock_item` as PARENT_CSI ON PARENT_CSI.product_id = CHILD_RESULT.ParentId
INNER JOIN `catalog_product_entity` as PARENT_CPE ON PARENT_CPE.entity_id = CHILD_RESULT.ParentId
ORDER BY ParentSku ASC
```

#Where customer address has lastname same as firstname, replace lastname with correct value from main customer data
```sh
UPDATE customer_address_entity_varchar cv RIGHT JOIN (SELECT c.entity_id, cev.value as firstname, cevx.value as lastname, ce.entity_id as address_id FROM customer_entity c LEFT JOIN customer_entity_varchar cev ON c.entity_id = cev.entity_id LEFT JOIN customer_entity_varchar cevx ON c.entity_id = cevx.entity_id LEFT JOIN customer_address_entity ce ON c.entity_id = ce.parent_id WHERE cev.attribute_id=5 AND cevx.attribute_id=7) c ON c.address_id = cv.entity_id SET cv.value = lastname WHERE cv.attribute_id=22 AND firstname = cv.value 
```
