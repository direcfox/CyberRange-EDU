#!/bin/bash
set -e

mkdir -p /var/log/nginx
mkdir -p /var/log/vsftpd

rm -f /var/log/nginx/access.log /var/log/nginx/error.log
touch /var/log/nginx/access.log /var/log/nginx/error.log
touch /var/log/vsftpd/vsftpd.log

chown -R www-data:adm /var/log/nginx || true


if ! id ftpuser >/dev/null 2>&1; then
    useradd -d /srv/ftp -s /bin/bash ftpuser
    echo "ftpuser:ftp123" | chpasswd
    chown -R ftpuser:ftpuser /srv/ftp
fi

service nginx start
/usr/sbin/vsftpd /etc/vsftpd.conf
