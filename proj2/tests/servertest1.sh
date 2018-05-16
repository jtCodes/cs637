# Usage servertest1.sh username
# Assumes project deployed at /cs637/username/proj2/proj2_server on localhost
# Note: add -v to get more info
echo
echo -------------set server day to 9
curl -i -d 9 -H Content-Type:text/plain  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
#should apparently succeed, but in fact does not work until coded right
echo
echo -------------get server day--should be 9
curl http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
# should return 9
echo
echo -------------set server day to 0 to reinitalize supply orders
curl -i -d 0 -H Content-Type:text/plain  http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
# should reinit system
echo
echo ---------------get server day again--should be 1 now
curl http://localhost:8080/cs637/$1/proj2/proj2_server/rest/day/
# should show day 1
echo
echo

