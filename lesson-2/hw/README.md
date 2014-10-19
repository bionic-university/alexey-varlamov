CSV parser
===============
# Usage: php parser.php --[options]
         
 --help(h)   this help
 --f         path to the CSV file for parsing
 --d         fields delimiter. E.g. ',', ':', 'tab', '\|', '\;' etc.
 --e         fields enclosure. E.g. '\'', '\"', 'empty' - to unset an enclosure, etc.
 --header    possible values: 'y' - first line is a header; 'n' - no header;
 
 #Example:
 php parser.php -f coma_delimited.csv
 php parser.php -f semi_colon_delimited.txt -d \;
 php parser.php -f tab_delimited.csv -d tab
 php parser.php -f tab_delimited.csv -d tab -header y
 php parser.php -f tab_delimited.csv -d tab -e \" -header y