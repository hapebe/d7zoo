#!/bin/bash
source ./.mysql-conf
TIMESTAMP=$(date +%Y-%m-%d-%H-%M)
mysqldump --databases $MYSQL_DB --quote-names --disable-keys --extended-insert=FALSE --user=$MYSQL_USER --password=$MYSQL_PASS > "./sites/default/files/bak/${TIMESTAMP}_${MYSQL_DB}_dump.sql"
# | xz -c > "./sites/default/files/bak/${TIMESTAMP}_${MYSQL_DB}_dump.sql.xz"
