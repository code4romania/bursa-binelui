FROM node:14.16.0
WORKDIR /build

ENTRYPOINT ["tail", "-f", "/dev/null"]
