FROM kalilinux/kali-rolling
ENV DEBIAN_FRONTEND=noninteractive
RUN apt update && apt install -y nginx php-fpm php-mysqlnd default-mysql-client ftp hydra python3 python3-pip curl wget net-tools  iputils-ping dnsutils nmap vim && apt clean 

COPY nginx.conf /etc/nginx/sites-available/default

RUN mkdir -p /run/php /var/www/html

CMD ["sh", "-c", "PHP_FPM_SERVICE=$(ls /etc/init.d/ | grep 'php.*-fpm' | head -n 1) && service \"$PHP_FPM_SERVICE\" start && nginx -g 'daemon off;'"]

