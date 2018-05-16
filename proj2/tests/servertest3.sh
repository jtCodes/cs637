# Usage servertest0.sh username
# Assumes project deployed at /cs637/username/proj2/proj2_server on localhost
# Note add -v to get more info
echo
# reinit system
echo -------------set server day to 0: reinit orders, sets day to 1
curl -i -d 0 -H Content-Type:text/plain  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
echo
echo ---------------get order 1: should fail with code 404
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders/1
echo
echo -------------send order as in spec to server: should succeed with code 201
curl -i -d @order.json -H Content-Type:application/json  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders/
echo
echo ---------------get all orders: should have one just inserted, not delivered
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders
echo
echo -------------set server day to 2
curl -i -d 3 -H Content-Type:text/plain http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
echo
echo -------------set server day to 3
curl -i -d 3 -H Content-Type:text/plain http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
echo
echo ---------------get all orders: should have same one, now delivered
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders
echo
echo -------------send another order to server: should succeed with code 201
echo -------------send second order to server: should succeed with code 201
curl -i -d @order.json -H Content-Type:application/json  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders/
echo
echo ---------------get all orders: should have two now, one delivered
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders
echo


