#!/bin/bash

set -eo pipefail
shopt -s nullglob

groupadd -g 1000 sportgenius
useradd -u 1000 -g sportgenius -m sportgenius
usermod -p "*" sportgenius

chown -R mysql:mysql /var/lib/mysql/

exec "$@"