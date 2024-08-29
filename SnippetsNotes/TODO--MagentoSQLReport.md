```sh
https://github.com/akira28/magento-utils/tree/master/sql
```

Check Stock Status For Parent SKUs from Given List Of Child SKUs Using MySQL Query

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