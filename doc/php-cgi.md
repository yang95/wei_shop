# php-cgi的启动方式
> spawn-fcgi -a 127.0.0.1 -p 9000 -C 5 -f /usr/bin/php-cgi
# php-fpm 的启动方式
> php5-fpm 
## 查看是否启动成功： 
> netstat -lnt | grep 9000  
## 或者使用如下命令，查看是否9000端口被php-fpm占用： 
> netstat -tunpl | grep 9000
 