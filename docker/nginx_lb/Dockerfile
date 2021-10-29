FROM nginx:1.17-alpine

RUN apk update \
    && apk add openssl

RUN openssl req -x509 -nodes -days 365 -subj "/C=FR/ST=FR/O=HEYLIOT, Inc./CN=*.heyliot.local" -addext "subjectAltName=DNS:*.heyliot.local" -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt;

# WORKDIR /var/www

# CMD ["nginx"]

# EXPOSE 80 443