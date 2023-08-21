# pdbcacher

FROM yarnpkg/node-yarn:node7

ENV MONGODB_URI=mongodb://localhost:27017/portdb
ENV SERVICE_DIR=/opt/pdbcacher

WORKDIR ${SERVICE_DIR}

COPY pdbcacher/ ./
RUN yarn install

CMD ["yarn", "start"]
# portdb

FROM yarnpkg/node-yarn:node7

ENV MONGODB_URI=mongodb://localhost:27017/portdb
ENV SERVICE_DIR=/opt/portdb

WORKDIR ${SERVICE_DIR}

COPY portdb/ ./
RUN yarn install

EXPOSE 8000
CMD ["yarn", "start"]
# website

FROM php:alpine

ENV SERVICE_DIR=/opt/website

WORKDIR ${SERVICE_DIR}

COPY website/ ./

EXPOSE 8080
CMD ["php", "-S", "127.0.0.1:8080", "-t", "/opt/website"]
