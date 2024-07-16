```sh
| Operator                 |     | Use                                            |
|--------------------------|-----|------------------------------------------------|
| Ternary Operator         | ?   | Used to shorten if/else structures             |
| Null Coalescing Operator | ??  | Used to provide default values instead of null |
| Spaceship Operator       | <=> | Used to compare two values                     |

```
https://www.atatus.com/blog/shorthand-comparisons-in-php/

PHP conditions

|       | isset | is_null | ===null | ==null | empty |
|-------|-------|---------|---------|--------|-------|
| null  | F     | T       | T       | T      | T     |
| unset | F     | T       | T       | T      | T     |
| ""    | T     | F       | F       | T      | T     |
| []    | T     | F       | F       | T      | T     |
| 0     | T     | F       | F       | T      | T     |
| false | T     | F       | F       | T      | T     |
| true  | T     | F       | F       | F      | F     |
| 1     | T     | F       | F       | F      | F     |
| \0    | T     | F       | F       | F      | F     |


        !$groupId ?: $customer->setGroupId($groupId);
        //this is equivalent to
        if($groupId){$customer->setGroupId($groupId);}


|       | true  | false | 1     | 0     | -1    | "1"   | "0"   | "-1"  | null  | []    | "php" | ""    |h
|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|
| true  | true  | false | false | false | false | false | false | false | false | false | false | false |
| false | false | true  | false | false | false | false | false | false | false | false | false | false |
| 1     | false | false | true  | false | false | false | false | false | false | false | false | false |
| 0     | false | false | false | true  | false | false | false | false | false | false | false | false |
| -1    | false | false | false | false | true  | false | false | false | false | false | false | false |
| "1"   | false | false | false | false | false | true  | false | false | false | false | false | false |
| "0"   | false | false | false | false | false | false | true  | false | false | false | false | false |
| "-1"  | false | false | false | false | false | false | false | true  | false | false | false | false |
| null  | false | false | false | false | false | false | false | false | true  | false | false | false |
| []    | false | false | false | false | false | false | false | false | false | true  | false | false |
| "php" | false | false | false | false | false | false | false | false | false | false | true  | false |
| ""    | false | false | false | false | false | false | false | false | false | false | false | true  |