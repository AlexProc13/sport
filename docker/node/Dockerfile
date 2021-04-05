FROM node:15

ARG uid
ARG gid

RUN groupmod -g $uid node \
  && usermod -u $uid -g $gid node

USER node

EXPOSE 3000
