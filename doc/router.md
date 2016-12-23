###项目的路由默认需要设置重写，即把index.php去掉,nginx配置参考文档nginx.md。
```
如：
    https://domain.io/index.php/v1/Home/Index/run.action
    等价于
    https://domain.io//v1//Home/Index/run.action
```
