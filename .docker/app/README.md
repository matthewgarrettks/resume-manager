# Alpine 3.13

## Features

* s6-overlay
* php 7.4
* nginx
* nodejs 14
* yarn (no npm)
* ~~oci8 not supported in musl environment~~
* ldap extension
* sqlite3, mysql, postgres
* ssh client
* git

## Environment

* APP_ENV="dev"
* GIT_REPO=""
* GIT_USER=""
* GIT_TOKEN=""
* GIT_TAG="main"
* SKIP_DB_MIGRATE -- optional
* XDEBUG_ENABLE="0"|"1"
* IS_DEV="0"|"1" -- If set to 1 sets uid and gid to 1000 for app user
* IS_SYMFONY="0"|"1"

These are easily overridden in a `docker-compose` or `docker run -e`

## Usage

Make any customizations to the image startup by modifying scripts in /etc/cont-init.d.

GIT environment variables are used for automatically cloning the repository while the container is coming up.
