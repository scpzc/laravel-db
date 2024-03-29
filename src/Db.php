<?php

/**
 * 数据库操作工具类，只能在Laravel中使用
 * author: panzhaochao
 * date: 2021-01-01 11:53
 */

namespace Scpzc\LaravelDb;


/**
 * @method static DbCore table(string $table)  要操作的数据表
 * @method static DbCore field($field = '')  要操作的字段
 * @method static DbCore where($where,$params = [])  要操作的条件
 * @method static array fetchRow($where = [], $params = [], $fields = '') 查询一条记录，可以使用原生
 * @method static array fetchAll($where = [], $params = [], $fields = '') 查询符合条件的所有记录，可以使用原生
 * @method static array fetchByPage($where = null, $params = [], $fields = '',$page = 1,$pageSize = 20) 分页查询，可以使用原生
 * @method static mixed fetchOne($where = [], $params = [], $fields = '') 获取单个值，可以使用原生
 * @method static mixed execute(string $sql = null, array $params = []) 执行原生SQL
 * @method static  startTrans() 开始事务
 * @method static  commit() 提交事务
 * @method static  rollBack()  回滚事务
 * @method static  getSql()  查询执行的SQL和参数
 */

class Db
{

    private static $connectPool = []; //存储数据连接对象数组

    /**
     * 要操作的库
     *
     * @param string $connectName
     *
     * @return object
     */
    public static function connect($connectName = '')
    {
        // 默认连接名称
        $defaultConnectName = config('database.default', 'mysql');
        // 连接名称
        $connectName = !empty($connectName)?$connectName:$defaultConnectName;
        // 判断是否已经实例化
        if (!isset(self::$connectPool[$connectName])) {
            // 没有实例化过，实例化，并存储
            self::$connectPool[$connectName] = new DbCore($connectName);
        }
        // 返回
        return self::$connectPool[$connectName];
    }


    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        return self::connect()->$method(...$args);
    }




}
