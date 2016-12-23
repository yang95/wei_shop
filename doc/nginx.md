## 配置https和http共存
```
server {
            listen 80 default backlog=2048;
            listen 443 ssl ;
            server_name 111cn.net;
            root /var/www/html;
            #ssl on;
            ssl_certificate /usr/local/Tengine/sslcrt/111cn.net.crt;
            ssl_certificate_key /usr/local/Tengine/sslcrt/111cn.net.key;
}
```
## nginx 测试环境配置
```
server {
        listen       8080;
        server_name tan.io;
        root   "C:\Users\lyang\PhpstormProjects\wei_shop";
        location / {
            index  index.html index.htm index.php;
            #autoindex  on;。
            #url重写
            try_files $uri $uri/ /index.php?$query_string;
        }
        location ~ \.php(.*)$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO  $fastcgi_path_info;
            fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
            include        fastcgi_params;
        }  
} 


```