echo
rem post and get back orders
rem Usage servertest2 username
rem Note add -v to get more info
rem reinit system
rem -------------set server day to 0: reinit orders
curl -i -d 0 -H Content-Type:text/plain  http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem ---------------get order 1: should fail with code 404
curl -i http://localhost/cs637/%1%/proj2/proj2_server/rest/orders/1
rem ---------------get all orders: should return empty array
curl -i http://localhost/cs637/%1%/proj2/proj2_server/rest/orders/
rem -------------send order to server: should succeed with code 201
curl -i -d @order.json -H Content-Type:application/json  http://localhost/cs637/%1/proj2/proj2_server/rest/orders/
rem ---------------get all orders: should have one just inserted
curl http://localhost/cs637/%1%/proj2/proj2_server/rest/orders
rem


