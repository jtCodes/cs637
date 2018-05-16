# Usage servertest0.sh username
# Assumes project deployed at /cs637/username/proj2/proj2_server on localhost
# Example: servertest0.sh eoneil     to access deployed provided projects
# servertest0: provided capabilities
# Note: add -v to get more info
echo
echo -------------get server day
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
# should return 6
echo
echo -------------set server day -- ineffective until coded right
curl -i -d 9 -H Content-Type:text/plain  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
#should apparently succeed, but in fact does not set the current server day
echo
echo ---------------get server day again
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
# shows 6 again until you fix the code
echo
echo ---------------get product 1
# product
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/products/1
# returns product 1 in JSON
# note file product.json
echo
echo ---------------post a product with code strat2
curl -i -d @product.json -H Content-Type:application/json  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/products/
echo ---------------if code 500, probably unique constraint violation on product code
