# webman + pearadmin 后台管理系统

#### 介绍
webman + pearadmin 后台管理系统
使用php常驻内存框架 + pearadmin layui + think-orm + laravel-cache + laravel-redis 缓存实现的后台管理系统<br/>
支持阿里云、oss图片上传
已完成后台菜单管理、权限管理、角色管理
<br/>
使用composer 安装 : composer create-project le/wbadmin

####  V1.5.0
1. 新增异常handler,统一返回json
2. 统一success、error返回方法
3. constants移至admin模块下
4. 优化前端模板结构布局

####  V1.4.1
新增定时任务组件
修复不强制使用路由时中间件bug
env配置文件增加服务配置

####  V1.4
新增event组件
新增用户模块
前台新增用户注册、登陆接口
后台新增用户列表

####  V1.3
新增phpoffice/phpspreadsheet组件
新增请求记录导出xls(采用后端导出,也可以自己优化为前端导出)


##### V1.2
新增redis-queue队列
新增请求日志记录，由队列记录到mysql

##### V1.1
修改think-cache 为 laravel-cache


#### 软件架构
后端采用webman常驻内存框架
前端采用pearadmin layui版本
使用mysql5.7数据库
使用redis 缓存数据
php 建议使用php7.4 及以后版本

演示地址:
[点击访问演示地址https://wbadmin.itjiale.com](https://wbadmin.itjiale.com/admin)
admin
123456


#### 安装教程

1.  使用composer拉取代码 composer create-project le/wbadmin  
2.  导入sql文件(sql目录下)，修改根目录.env文件 配置mysql、redis信息
3.  系统session默认使用redis存储，并且存储时间较长，如果需要修改可以更改 config/session.php 文件

#### 使用说明

1.  根目录 php start.php start 调试模式启动 ， 加上 -d 为生产模式启动
2.  config/server.php 可以配置启动进程数量，建议为服务器核心数量 * 2

部分截图
![输入图片说明](https://foruda.gitee.com/images/1667264084231808647/1512e4d3_775530.png "屏幕截图")
![输入图片说明](https://foruda.gitee.com/images/1667264109444446081/95623ccb_775530.png "屏幕截图")
![输入图片说明](https://foruda.gitee.com/images/1667264119155116119/74aefcb7_775530.png "屏幕截图")
![输入图片说明](https://foruda.gitee.com/images/1667264126647705630/65bf4bea_775530.png "屏幕截图")
![输入图片说明](https://foruda.gitee.com/images/1667264138856851699/2851bbfd_775530.png "屏幕截图")
![输入图片说明](https://foruda.gitee.com/images/1667264154593931539/d4f0febd_775530.png "屏幕截图")
![输入图片说明](https://foruda.gitee.com/images/1667264161859469354/fb2b0778_775530.png "屏幕截图")


#### 参与贡献

1.  Le


#### 免责声明
1. 请您承诺秉着合法、合理的原则使用该后台框架，不利用该框架进行任何违法、侵害他人合法利益等恶意的行为，也不可运用于任何违反我国法律法规的 Web 平台，造成后果将由使用者承担，本团队不承担任何法律责任。
2. 任何单位或个人因下载使用该框架造成的任何意外、疏忽、合约毁坏、诽谤、版权或知识产权侵犯及其造成的损失 (包括但不限于直接、间接、附带或衍生的损失等)，将由使用者承担，本团队不承担任何法律责任。
3. 用户明确并同意本声明条款列举的全部内容，对使用该后台框架可能存在的风险和相关后果将完全由用户自行承担，本团队不承担任何法律责任。

