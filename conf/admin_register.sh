
curl -k --header "Content-Type: application/json" \
  --request POST \
  -d '{"status": "active","role": "admin","name": "admin","surname": "admin","address": "","email": "admin@test.si","username": "admin","password": "admin","password": "admin"}' \
  --cert-type P12 \
  --cert ./certs/admin.p12:ep \
  https://localhost/ep/php/register/