CSV parser v 1.0
================
## Usage: php inspect.php --[options]<br />
 --help(h)   this help<br />
 -t          transport(comma-separated): bike,car,truck,bus,tram<br />
 -c          driving category(comma-separate): A,B,C,D,F<br />
 --header    possible values: 'y' - first line is a header; 'n' - no header;
### Example:
 - php inspect.php -t car,moto -c a,c,b<br />