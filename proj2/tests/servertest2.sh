#!/bin/sh
# Usage servertest2.sh username
# Note add -v to get more info
echo
# reinit system
echo -------------set server day to 0: reinit orders
curl -i -d 0 -H Content-Type:text/plain  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
echo
echo ---------------get order 1: should fail with code 404
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders/1
echo
echo ---------------get all orders: should return empty array
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders/
echo
echo -------------send order as in spec to server: should succeed with code 201
curl -i -d @order.json -H Content-Type:application/json  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders/
echo
echo ---------------get all orders: should have one just inserted
curl -i http://localhost:8080/cs637/$1/proj2/proj2_server/rest/orders
echo

