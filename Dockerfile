FROM python:3.10-rc-alpine3.14

ARG USERNAME
ARG USER_UID=1000
ARG USER_GID=${USER_UID}

RUN apk update && \
    apk add --no-cache sudo tzdata git openssh

RUN addgroup -g ${USER_GID} ${USERNAME} && \
    adduser -D -u ${USER_UID} -s /bin/sh ${USERNAME} -G wheel ${USERNAME} && \
    echo '%wheel ALL=(ALL) NOPASSWD: ALL' >> /etc/sudoers

WORKDIR /usr/src/app

COPY requirements.txt ./

RUN pip install --no-cache-dir -r requirements.txt
