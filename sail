#!/usr/bin/env bash

# Minimal Sail wrapper so contributors can run `./sail ...`
# without installing PHP on the host.

set -euo pipefail

if [ -f vendor/bin/sail ]; then
  exec bash vendor/bin/sail "$@"
fi

# Bootstrap composer/vendor via the Sail PHP+Composer image.
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php81-composer:latest \
  composer install --no-interaction --prefer-dist

exec bash vendor/bin/sail "$@"
