# Different Logging Methods
```sh
$writer = new \Zend_Log_Writer_Stream(BP . '/var/log/Theshreyas.log');
$logger = new \Zend_Log();
$logger->addWriter($writer);
$logger->info('Your text message');
$logger->info(print_r($result, true));
```
OR
```sh
file_put_contents(BP . '/var/log/Theshreyas.log', print_r($key, true).PHP_EOL, FILE_APPEND);
```
OR
```sh
$debugBackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
foreach ($debugBackTrace as $item) {
    $logger->info(@$item['class'] . @$item['type'] . @$item['function']);
}
```
OR
```sh
foreach (debug_backtrace() as $stack) {
    $string = ($stack["file"] ?? '') . ':' .
        ($stack["line"] ?? '') . ' - ' .
        ($stack["function"] ?? '') . '<br/><hr/>';
    file_put_contents(BP . '/var/log/Trace.log', print_r($string, true) . PHP_EOL, FILE_APPEND);
}
```
# run any method/ cron programmatically
```sh
$cron = $objectManager->get('\Vendor\Module\Cron\UpdateStatus')->execute();
```
# Get methods of an object
```sh
$class_name = get_class($object);
$methods = get_class_methods($class_name);
foreach($methods as $method)
{
    var_dump($method);
}
```

# Check Exception Type/Class
```sh
file_put_contents(BP . '/var/log/ShreyasMethod.log', print_r(get_class($exception), true) . PHP_EOL, FILE_APPEND);
```

# log all sql queries #1

```sh
vendor/magento/framework/DB/Statement/Pdo/Mysql.php
inside _execute function before "if ($specialExecute) {"
file_put_contents(BP . '/var/log/ShreyasParams.log', print_r($this->_stmt->queryString, true) . PHP_EOL . (!empty($params) ? json_encode($params, true) . PHP_EOL : ''), FILE_APPEND);
```

# log all sql queries #2
```sh
// in app/etc/di.xml
// change the following lines
<preference for="Magento\Framework\DB\LoggerInterface" type="Magento\Framework\DB\Logger\LoggerProxy"/>

// for the following:

<type name="Magento\Framework\DB\Logger\File">
    <arguments>
        <argument name="logAllQueries" xsi:type="boolean">true</argument>
        <argument name="debugFile" xsi:type="string">log/sql.log</argument>
    </arguments>
</type>
```

https://magento.stackexchange.com/a/370747

https://www.mageplaza.com/devdocs/how-write-log-magento-2.html
\Psr\Log\LoggerInterface $logger
$this->_logger->debug
$this->_logger->info
$this->_logger->error
$this->_logger->critical