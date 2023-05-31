# 轻量级DB

## 1.基本写法
### 1.1查询
```phpregexp
$count = Db::table('user')->count($where,$params); #查询记录数
$userInfo = Db::table('user')->fetchRow($where,$params,$fields); #查询单条
$userList = Db::table('user')->fetchAll($where,$params,$fields); #查询多条
$username = Db::table('user')->fetchOne($where,$params,$fields); #查询单列
$result = Db::table('user')->fetchByPage($where,$params,$fields,$page,$pageSize); #查询分页
```
以上语句支持原生写法，如：查询单条
```phpregexp
$userInfo = Db::fetchRow('SELECT username * FROM user_id=:user_id',['user_id'=>1]);
```
排序order
```phpregexp
$order = 'id desc,age asc';  #支持字符串和数组
$order = ['id'=>'desc','age'=>'asc']; 
$userList = Db::table('user')->order($order)->fetchAll($where,$params,$fields);
```
限制条数limit
```phpregexp
$userList = Db::table('user')->limit($offset,$limit)->fetchAll($where,$params,$fields);
```
### 1.2新增
```phpregexp
$data = ['username'=>'张三','age'=>10];
$id = Db::table('user')->insert($data); #返回自增ID，只支持单条
```
### 1.3修改
```phpregexp
$data = ['username'=>'张三','age'=>10];
$where = ['user_id'=>1];
$result = Db::table('user')->update($data,$where); #返回修改记录数，失败返回false，修改0条返回0
```
### 1.4删除
```phpregexp
$result = Db::table('user')->delete($where); #返回删除记录数
```
### 1.5原生增删改
```phpregexp
Db::table('user')->execute($sql,$params);
```
### 1.6原生查询

```
Db::table('user')->fetchAll($sql,$params);
Db::table('user')->fetchByPage($sql,$params,null,$page,$pageSize);
```

### 1.7选择不同的数据库

```phpregexp
Db::connect('log')->table('user')->insert($data);
```

## 2.where写法
### 2.1 数组查询
```phpregexp
$where = ['user_id'=>1];
$where = [['user_id','=',1]];
$where = [
    ['user_id','>',1],
    ['user_id','<',10],
];
$where = [
    ['user_id','in',[1,2]],
    ['user_id','not in',[3,4]],
];
```
### 2.2 绑定参数
```phpregexp
$where = "user_id = :user_id and age > :age";
$params = ['user_id'=>1,'age'=>10];
```
### 2.3 直接使用原生+绑定参数
```phpregexp
$sql = "SELECT username FROM user WHERE user_id = :user_id";
$params = ['user_id'=>1];
```

## 3.输出SQL语句
### 3.1调式sql语句
```phpregexp
Db::table('user')->debug()->fetchRow($where); #SQL语句不会执行，会直接在控制台输出SQL语句
```

## 4.left join等复杂查询，使用原生
对于两表以上的联表查询，使用原生写法

```php
$sql = "SELECT ...
                 FROM jm_circle c LEFT JOIN jm_circle_category cc ON c.category_id = cc.id
                 WHERE $where ORDER BY $orderBy";
        $data = Db::fetchByPage($sql,$params,null,$input['page'],$input['page_size']);
        $data = Db::fetchAll($sql,$params);
```

## 5.事务
```phpregexp
Db::startTrans()  #开始事务
Db::commit()  #提交事务
Db::rollBack()  #回滚事务
```