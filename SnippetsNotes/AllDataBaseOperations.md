```sh
$objectManager 	= \Magento\Framework\App\ObjectManager::getInstance();
$resource 		= $objectManager->get("Magento\Framework\App\ResourceConnection");
$connection 	= $resource->getConnection();
$tableName 		= $resource->getTableName("students");
```

```sh
/**
* @var ResourceConnection
*/
private $resourceConnection;
public function __construct(
    \Magento\Framework\App\ResourceConnection $resourceConnection
) { 
    $this->resourceConnection = $resourceConnection;
}
```

```sh
$connection = $this->resourceConnection->getConnection();
$tableName = $connection->getTableName(self::ORDER_STATUS_TABLE);

$query = "SELECT * from " . $tableName;
$result = $connection->fetchAll($query);

$sql = "SELECT * FROM " . $tableName . " WHERE `city` = :city";
$bind = [":city" => $city];
$result = $connection->query($sql, $bind);

$sql = "INSERT INTO `students` (`name`, `city`) VALUES ('Abc', 'Mumbai');";
$connection->query($sql);

$sql = "UPDATE $tableName SET `city` = 'Mumbai3' where id = 13;";
$connection->query($sql);

$sql = "DELETE FROM $tableName WHERE `id` = 12";
$connection->query($sql);

$query = $connection
    ->select()
    ->from($tableName, ["id", "name", "city"])
    ->where("city = ?", "Mumbai");
$result = $connection->fetchAll($query);

$query = $connection
    ->select()
    ->from($tableName)
    ->where("city = ?", "Mumbai")
    ->group("name")
    ->order("id DESC")
    ->limit(1); //->limit($limit,$offset)
$result = $connection->fetchAll($query);

$row = ["name" => "Xyz2", "city" => "Chandigarh"];
$result = $connection->insert($tableName, $row);
$status = $result . " rows affected";

$multipleRows = [
    ["name" => "Abc1", "city" => "Mumbai1"],
    ["name" => "Abc2", "city" => "Mumbai2"],
];
$result = $connection->insertMultiple($tableName, $multipleRows);
$status = $result . " rows affected";

$multipleRows = [["Abc", "Mumbai"]];
$result = $connection->insertArray($tableName, ["name", "city"], $multipleRows);
$status = $result . " rows affected";
$status =
    $result == count($multipleRows)
        ? "all success"
        : count($multipleRows) - $result . " failed";

// can be used for unique or primary column,this inserts row, if key is duplicate(name), it updates other columns(city)
$data = ["name" => "Abc2", "city" => "Mumbai2"];
$status = $connection->insertOnDuplicate($tableName, $data, []);
$status = $status ? "succes" : "fail";

$bind = ["name" => "newName"];
$where = ["city = ?" => "Mumbai"];
$result = $connection->update($tableName, $bind, $where);
$status = $result . " rows affected";

$connection->update(
    $tableName,
    ["emails_failed" => new \Zend_Db_Expr("emails_failed + 1")],
    ["rule_id = ?" => $ruleId, "customer_id = ?" => $customerId]
);

$condition = [
    "attribute_id = ?" => (int) $attribute_id,
    "store_id IN(?)" => $storeIdsArray,
]; //multiple conditions
$condition = ["id = ?" => 33]; //single condition
$result = $connection->delete($tableName, $condition);
$status = $result ? "success" : "fail";
```

**Transaction**
```sh
try {
    $multipleRows = [
        ["name" => "Abc1", "city" => "Mumbai1"],
        ["name" => "Abc2", "city1" => "Mumbai2"],
    ];
    $connection->beginTransaction();
    $connection->insertMultiple($tableName, $multipleRows); //do your stuff
    $connection->commit();
    echo "Successful";
} catch (\Exception $e) {
    file_put_contents(
        BP . "/var/log/Theshreyas.log",
        print_r($e->getMessage(), true) . PHP_EOL,
        FILE_APPEND
    );
    $connection->rollBack();
}
```

**Other Functions** 
```sh
$isTableExist = $connection->isTableExists($tableName);
addColumn, changeColumn, modifyColumn, dropColumn and many more check core adapter
```

**Different fetch methods** 
```sh
fetchCol //Fetches the first column of all SQL result rows as an array
fetchRow //Fetches the first row
fetchPairs //Fetches all SQL result rows as an array of key-value pairs. The first column is the key, the second column is the value.
fetchOne //Fetches first column of first row
fetchAssoc //Fetches all SQL result rows as an associative array.The first column is the key, the entire row array is the value
fetchAll //Fetches all SQL result rows as a sequential array.

fetchCol                      fetchRow
Array                        Array
(                            (
    [0] => 11                    [id] => 11
    [1] => 12                    [name] => Abc
)                            )
fetchPairs                    fetchOne
Array                        11
(
    [11] => Abc
    [12] => Def
)
fetchAssoc                   fetchAll
Array                        Array
(                            (
    [11] => Array                [0] => Array
        (                            (
            [id] => 11                   [id] => 11
            [name] => Abc                [name] => Abc
        )                            )
    [12] => Array                [1] => Array
        (                            (
            [id] => 12                   [id] => 12
            [name] => Def                [name] => Def
        )                            )
)                            )
```

**mySQL Triggers**
```sh
DROP TABLE IF EXISTS `sales_order_status_changes`;
CREATE TABLE `sales_order_status_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `old_status` varchar(255) NOT NULL,
  `new_status` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



delimiter //
CREATE TRIGGER order_create_change AFTER INSERT
ON `sales_order`
FOR EACH ROW
  INSERT INTO sales_order_status_changes (order_id,old_status, new_status) Values (NEW.entity_id, "",NEW.status);
//
delimiter ;


delimiter //
CREATE TRIGGER order_update_change AFTER UPDATE
ON `sales_order`
FOR EACH ROW
  IF NEW.status <> OLD.status THEN
    IF EXISTS(SELECT 1 FROM sales_order_status_changes WHERE order_id = NEW.entity_id) THEN
        UPDATE sales_order_status_changes SET old_status = OLD.status, new_status = NEW.status where order_id = NEW.entity_id;
    ELSE
        INSERT INTO sales_order_status_changes (order_id,old_status, new_status) Values (NEW.entity_id, OLD.status,NEW.status);
    END IF;
  END IF
//
delimiter ;
```

```sh
#TODO
different examples of join, complex mysql like count/having/concat/, last insert id,create stored procedure
different examples of collection filters,joins (product,category,order)
log mysql queries
searchcriteria with and/Or where conditions
https://developer.adobe.com/commerce/php/development/components/searching-with-repositories/
```
**Reset Password via SQL**
```sh
UPDATE `customer_entity` SET `password_hash` = CONCAT(SHA2('xxxxxxxNewCustomerPassword', 256), ':xxxxxxx:1') WHERE `entity_id` = 11; 

UPDATE `admin_user` SET `password` = CONCAT(SHA2('xxxxxxxxNewAdminPassword@23', 256), ':xxxxxxxx:1') WHERE `username` = 'adminusername';

xxxxxxx can by any string or you can keep it as it is.
```

**Collection**
```sh
$giftColletion = $this->_giftFactory->getCollection();
$giftColletion->addFieldToFilter('store_id', 1);
$giftColletion->setOrder('position','ASC');
$giftColletion->setOrder('salary','ASC');
$giftColletion->setPageSize(10);
```