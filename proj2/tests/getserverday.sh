# Usage getserverday username
# Assumes project deployed at /cs637/username/proj2/proj2_server on localhost
# Note: add -v to get more info
echo
echo -------------get server day
curl -i http://localhost/cs637/$1/proj2/proj2_server/rest/day/
echo
