rem Usage (on Windows) servertest3 username
rem Assumes project is deployed at localhost/cs637/username/proj2/proj2_server
rem test delivery status determination
rem Note add -v to get more info
rem
rem reinit system
rem -------------set server day to 0: reinit orders
curl -i -d 0 -H Content-Type:text/plain  http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem
rem ---------------get order 1: should fail with code 404
curl -i http://localhost/cs637/%1/proj2/proj2_server/rest/orders/1
rem
rem -------------send order to server: should succeed with code 201
curl -i -d @order.json -H Content-Type:application/json  http://localhost/cs637/%1/proj2/proj2_server/rest/orders/
rem
rem ---------------get all orders: should have one just sent, not delivered
curl -i http://localhost/cs637/%1%/proj2/proj2_server/rest/orders
rem
rem -------------set server day to 2
curl -i -d 2 -H Content-Type:text/plain  http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem
rem -------------set server day to 3
curl -i -d 3 -H Content-Type:text/plain  http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem
rem ---------------get all orders: should have one, delivered
curl -i http://localhost/cs637/%1%/proj2/proj2_server/rest/orders
rem
rem -------------send second order to server: should succeed with code 201
curl -i -d @order.json -H Content-Type:application/json  http://localhost/cs637/%1/proj2/proj2_server/rest/orders/
rem  ---------------get all orders: should have two now, one delivered
curl -i http://localhost/cs637/%1%/proj2/proj2_server/rest/orders
rem


