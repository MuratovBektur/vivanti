FROM node:18

WORKDIR /app

ENV NODE_ENV=prod

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build