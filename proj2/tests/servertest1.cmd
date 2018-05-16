echo
rem test day handling
rem Usage servertest1 username
rem Assumes project is deployed at localhost/cs637/username/proj2/proj2_server
rem Note: add -v to get more info
rem -------------set server day to 9
curl -i -d 9 -H Content-Type:text/plain  http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem should apparently succeed, but does not set the current day until coded 
rem -------------get server day--should be 9
curl http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem should return 9
rem -------------set server day to 0 to reinitialize supply orders
curl -i -d 0 -H Content-Type:text/plain  http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem should reinit system
rem ---------------get server day again--should be 1 now
curl http://localhost/cs637/%1/proj2/proj2_server/rest/day/
rem should show day 1

