CSV parser
===============
# Usage: php parser.php --[options]
         
 --help(h)   this help"\n"
 --f         path to the CSV file for parsing"\n"
 --d         fields delimiter. E.g. ',', ':', 'tab', '\|', '\;' etc."\n"
 --e         fields enclosure. E.g. '\'', '\"', 'empty' - to unset an enclosure, etc."\n"
 --header    possible values: 'y' - first line is a header; 'n' - no header;"\n""\n"

 #Example:"\n"
 php parser.php -f coma_delimited.csv"\n"
 php parser.php -f semi_colon_delimited.txt -d \;"\n"
 php parser.php -f tab_delimited.csv -d tab"\n"
 php parser.php -f tab_delimited.csv -d tab -header y"\n"
 php parser.php -f tab_delimited.csv -d tab -e \" -header y"\n"