rem Usage (on Windows) servertest0 username
rem Example: servertest0.sh username 
rem Assumes project is deployed at localhost/cs637/username/proj2/proj2_server
rem servertest0: provided capabilities
rem add -v for more info
rem -------------get server day
curl http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem should return 6
rem
rem -------------set server day -- ineffective until coded right
curl -i -d 9 -H Content-Type:text/plain  http://localhost/cs637/%1%/proj2/proj2_server/rest/day/
rem should apparently succeed, but in fact does not set the curent day
rem
rem ---------------get server day again
curl http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem shows 6 again until you fix the code
rem
rem ---------------get product 1
rem product
curl http://localhost/cs637/%1/proj2/proj2_server/rest/products/1
rem returns product 1 in JSON
rem note file product.json
rem
rem ---------------post a product with code strat2
curl -i -d @product.json -H Content-Type:application/json  http://localhost/cs637/%1/proj2/proj2_server/rest/products/
rem shows HTTP 500 if rerun because of PK violation (duplicate product in DB)
