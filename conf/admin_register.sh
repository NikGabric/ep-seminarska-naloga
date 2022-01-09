
# curl -k --header "Content-Type: application/json" \
#   --request POST \
#   -d '{"status": "active","role": "admin","name": "admin","surname": "admin","address": "/","email": "admin@test.si","username": "admin","password": "admin","password": "admin"}' \
#   --cert-type P12 \
#   --cert ./certs/admin.p12:ep \
#   https://localhost/ep/php/register/

curl -k --header "Content-Type: application/json" \
  --request POST \
  --data "status=active&role=admin&name=1&surname=1&address=&email=test1%40test.si&username=1&password=1&password=1" \
  --cert-type P12 \
  --cert ./certs/admin.p12:ep \
  https://localhost/ep/php/register/

