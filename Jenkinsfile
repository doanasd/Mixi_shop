version: '3.8'

services:
  web:
    image: doanasd/mixi_shop:latest
    container_name: mixi_app
    restart: always
    environment:
      - DB_PASSWORD=${DB_PASSWORD}
      - DB_HOST=mixishop-db-server.cpokqmmuq5tj.ap-southeast-1.rds.amazonaws.com
      - DB_USERNAME=admin
      - DB_NAME=mixi_shop
    volumes:
      - ./honeypot.log:/var/www/honeypot_access.log
    networks:
      - mixi_network

  waf:
    image: owasp/modsecurity-crs:nginx
    container_name: mixi_waf
    restart: always
    ports:
      - "80:8080"
    environment:
      - BACKEND=http://web:80
    volumes:
      - ./waf_logs:/var/log/nginx
    depends_on:
      - web
    networks:
      - mixi_network

networks:
  mixi_network:
    driver: bridge
