## php date() function
Assuming today is March 10th, 2023, 5:16:18 pm

```sh
$today = date("F j, Y, g:i a");                 // March 10, 2023, 5:16 pm
$today = date("m.d.y");                         // 03.10.23
$today = date("j, n, Y");                       // 10, 3, 2023
$today = date("Ymd");                           // 20230310
$today = date('h-i-s, j-m-y, it is w Day');     // 05-16-18, 10-03-23, 1631 1618 6 Satpm23
$today = date('\i\t \i\s \t\h\e jS \d\a\y.');   // it is the 10th day.
$today = date("D M j G:i:s T Y");               // Sat Mar 10 17:16:18 UTC 2023
$today = date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:18 m is month
$today = date("H:i:s");                         // 17:16:18
$today = date("Y-m-d H:i:s");                   // 2023-03-10 17:16:18 (the MySQL DATETIME format)
$today = date('l \t\h\e jS');                   // Saturday the 10th 
```

```sh
# Parse English textual datetimes into Unix timestamps:
$d = strtotime("10:30pm April 15 2014"); //1397601000
echo "Created date is " . date("Y-m-d h:i:sa", $d); //2014-04-15 10:30:00pm
```

```sh
# Return the current time as a Unix timestamp,
echo time(); //1727194386
```

https://stackoverflow.com/a/40484613

```sh
* @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
protected \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
$date = $this->timezone->date()->format('Ymdu'); // 20231003236738
```

compare dates

subtract dates/ add dates