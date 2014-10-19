CSV parser v 1.0
================
## Usage: php parser.php --[options]<br />
 --help(h)   this help<br />
 --f         path to the CSV file for parsing<br />
 --d         fields delimiter. E.g. ',', ':', 'tab', '\|', '\;' etc.<br />
 --e         fields enclosure. E.g. '\'', '\"', 'empty' - to unset an enclosure, etc.<br />
 --header    possible values: 'y' - first line is a header; 'n' - no header;
### Example:
 - php parser.php -f coma_delimited.csv<br />
 - php parser.php -f semi_colon_delimited.txt -d \;<br />
 - php parser.php -f tab_delimited.csv -d tab<br />
 - php parser.php -f tab_delimited.csv -d tab -header y<br />
 - php parser.php -f tab_delimited.csv -d tab -e \" -header y<br />