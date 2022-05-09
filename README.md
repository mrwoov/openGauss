# Php Connector with Opengauss



## 说明

该函数库是基于Opengauss底层使用的Postgre SQL数据库有关函数进行的面向对象的函数库二次封装。故使用该函数库前，请打开php.ini中有关postgre的相关函数。

```
* @author woov(吴未)<wooovi@qq.com> 
* @version 1.0
* @since 2022.05.04
```

##  连接openGauss数据库

```php
$conn = new gauss_class($host,$user,$pass,$dbname,$port);
```

连接是通过创建 gauss 基类的实例而建立的。连接成功返回其他gauss函数需要的资源**conn**，连接失败提示错误并返回false。

**参数说明**

| 名称   | 类型   | 说明                |
| ------ | ------ | ------------------- |
| host   | string | gauss数据库主机地址 |
| user   | string | 数据库用户名        |
| pass   | string | 数据库密码          |
| dbname | string | 数据库名            |
| port   | string | gauss数据库端口     |

## 关闭连接

```php
$conn = new gauss_class($host,$user,$pass,$dbname,$port);
//在此使用连接

//运行完成关闭连接
$conn = null;
```

连接数据成功后，返回一个 gauss类的实例给脚本，此连接在 gauss 对象的生存周期中保持活动。要想关闭连接，需要销毁对象以确保所有剩余到它的引用都被删除，可以赋一个 **`null`** 值给对象变量。如果不明确地这么做，PHP 在脚本结束时会自动关闭连接。关闭由所给资源$conn指到的Opengauss数据库的非持久连接。

## isbusy -获知连接是否为忙

```php
$isbusy = $conn->isbusy()
if ($isbusy){
    echo 'busy';
}
else{
    echo 'free';
}
```

当连接忙时，函数返回值为ture(bool)，否则为false

## query -执行查询

```php
$result = $conn -> query($sql);
```

**query()**在查询可以执行的返回查询结果资源号。如果查询失败或提供的连接无效则返回false。query()发送一条SQL语句到conn资源指定的openGauss数据库。

## getOne -获取单条数据

```php
$data = $conn -> getOne($sql);
```

## getAll -获取所有数据

```php
$data = $conn -> getAll($sql);
```

## numRows -获取行的数目

```php
$count = $conn -> numRow($result);
```

**numRow()**返回**result**中的行的数目。其中result参数是由query()函数返回的查询结果资源号。出错则返回-1。

## affectedRows -获取受影响的记录数目

```php
$count = $conn -> affectedRows($result)
```

**affectesRows()**返回**query()**中执行的INSERT,UPDATE和DELECT查询后受到影响的记录数目（包括实例/记录/行）。如果本函数没有影响到任何记录，则返回0。其中result参数是由query()函数返回的查询结果资源号。

## insert -新增单条数据

```php
$res = $conn -> insert($table,$data);
```

参数说明：

| 参数   | 类型   | 说明                               |
| ------ | ------ | ---------------------------------- |
| $table | string | 表名                               |
| $data  | list   | 由字段名当键，属性当键值的一维数组 |

**insert()**返回插入的结果，成功返回**`ture`**,否则返回**`false()`**(注意：返回类型为bool)。

示例：

```php
$data=array(
    'test_user' => 'woov',
    'test_pass' => '123456'
);
$res = $conn->insert('test',$data);
```

## update -更改单条数据

```php
$res = $conn -> update($table,$data,$where)
```

参数说明：

| 参数   | 类型   | 说明                               |
| ------ | ------ | ---------------------------------- |
| $table | string | 表名                               |
| $data  | list   | 由字段名当键，属性当键值的一维数组 |
| $where | string | where表达式，"字段名"="字段属性"   |

**update()**返回更改的结果，成功返回**`ture`**,否则返回**`false()`**(注意：返回类型为bool)。

示例：

```php
$tdata=array(
    'test_pass' => '123412356'
);
$where = "test_user = 'woov'";
$res = $conn->update('test',$tdata,$where);
```

## del -删除单条数据

```php
$res = $conn -> del($table,$where);
```

参数说明：

| 参数   | 类型   | 说明                             |
| ------ | ------ | -------------------------------- |
| $table | string | 表名                             |
| $where | string | where表达式，"字段名"="字段属性" |

**del()**返回删除的结果，成功返回**`ture`**,否则返回**`false`**(注意：返回类型为bool)

```php
$res = $conn->del("test","id = 1");
```

### connReset -重置连接

```php
$conn->connRest();
```

**connReset()**成功返回**`ture`**,否则返回**`false()`**(注意：返回类型为bool)。

## dbname -获取表名

```php
$res = $conn -> dbname();
```



## fetch_all - 从结果中提取所有行作为一个数组

```php
$data = $conn -> fetch_all($result);
```

**fetch_all()** 从结果资源中返回一个包含有所有的行（元组/记录）的数组。如果没有更多行可供提取，则返回 **`false`**。

## fetch_assoc -提取一行作为关联数组

```ph
$data = $conn -> fetch_assoc($result);
```

**fetch_assoc()** 它只返回一个关联数组。

## fetch_array  -提取一行作为数组

```php
$data = $conn -> fetch_array($result)
```

**fetch_array()**返回一个与所提取的行（元组/记录）相一致的数组。如果没有更多行可供提取，则返回 **`false`**。
