<?php
//队列与哈希的组合使用 - 实现数据关系化
public function index()
    {
        //
        $where = ['status'=>'1'];
        $obj = \DB::table('data_admin_login')->where($where)->get();
        $array = $this->objectToArray($obj);
        dd($array);
    }

//写入
 public function index()
    {
        //
        $where = ['status'=>'1'];
        $obj = \DB::table('data_admin_login')->where($where)->get();
        $array = $this->objectToArray($obj);
        // 定义Redis的key
        $listKey = 'LIST:TEST:ADMIN';
        $hashKey = 'HASH:TEST:ADMIN:';
        // 遍历时写入Redis list为索引 hash为数据
        foreach($array as $v){
            \Redis::rpush($listKey,$v['guid']);
            \Redis::hMset($hashKey.$v['guid'],$v);
        }

        return '缓存写入成功';
    }


//取数据
 public function index()
    {
        //
        // 定义Redis的key
        $listKey = 'LIST:TEST:ADMIN';
        $hashKey = 'HASH:TEST:ADMIN:';
        // 取出admin队列的唯一识别id数组
        $list = \Redis::lrange($listKey,0,-1);
        $array = null;
        foreach($list as $v){
            // 取出哈希里的数据写入大数组中
            $array[] = \Redis::hGetall($hashKey.$v);
        }
        dd($array);
    }


 //完整的例子
 public function index()
    {
        //

        // 定义Redis的key
        $listKey = 'LIST:TEST:ADMIN';
        $hashKey = 'HASH:TEST:ADMIN:';

        // 查看key是否存在？
        if(empty(\Redis::exists($listKey))){
            // 如果Redis不存在 读数据库然后写入redis
            $where = ['status'=>'1'];
            $obj = \DB::table('data_admin_login')->where($where)->get();
            $array = $this->objectToArray($obj);
            // 遍历时写入Redis list为索引 hash为数据
            foreach($array as $v){
                \Redis::rpush($listKey,$v['guid']);
                \Redis::hMset($hashKey.$v['guid'],$v);
            }
            return $array;
        }
        // 如果redis存在 直接读redis的数据

        // 取出admin队列的唯一识别id数组
        $list = \Redis::lrange($listKey,0,-1);
        $array = null;
        foreach($list as $v){
            $array[] = \Redis::hGetall($hashKey.$v);
        }
        return $array;

    }