FROM node:20

RUN useradd -m alex && usermod -a -G node alex

RUN npm install -g npm@10.3.*

WORKDIR /lexusalex-tech/frontend

USER node