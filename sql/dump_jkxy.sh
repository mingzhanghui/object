#!/bin/bash
cat > ~/.my.cnf <<EOF
[mysql]
user=root
password=root
host=localhost
database=jkxy
socket=/opt/lampp/var/mysql/mysql.sock
EOF

cat > jkxy.sql <<EOF
CREATE DATABASE IF NOT EXISTS jkxy;
USE jkxy;
EOF

/opt/lampp/bin/mysqldump -uroot -hlocalhost -proot jkxy >> jkxy.sql

