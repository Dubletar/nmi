#!/bin/sh

./bin/console assets:install --symlink --relative
./bin/console cache:clear --no-warmup --env=prod
./bin/console cache:clear --no-warmup --env=dev
./bin/console assetic:dump --env=prod --no-debug
./bin/console assetic:dump --env=dev
