FROM nginx:1.23.3-alpine-perl as base

WORKDIR /srv
COPY public public
COPY ${PWD}/.docker/env/local/nginx.conf /etc/nginx/nginx.conf