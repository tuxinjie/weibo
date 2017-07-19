<?php
//写入队列
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'LIST:TEST:R';
        $names = ['PHP','HTML','CSS','JavaScript','Node','Java','Ruby','Python'];
        // 从右往左压入队列
        $info = \Redis::rpush($key,$names);
        dd($info);
        return view('test');
    }
}


class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'LIST:TEST:R';
        $names = ['PHP','HTML','CSS','JavaScript','Node','Java','Ruby','Python'];
        // 获取队列内容(0到-1 所有 0到0是一位 0到1是两位)
        $info = \Redis::lrange($key,0,-1);
        dd($info);
        return view('test');
    }
}


//从左往右塞入队列连贯方法
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'LIST:TEST:L';
        $names = ['PHP','HTML','CSS','JavaScript','Node','Java','Ruby','Python'];
        // 从左往右存数据
        \Redis::lpush($key,$names);
        // 取出数据
        $info = \Redis::lrange($key,0,-1);
        dd($info);
        return view('test');
    }
}



//存数据
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'HASH:TEST';
        $names = ['id'=>'99',
                  'name'=>'AXiBa',
                  'age'=>'23',
                  'tel'=>'13995578699',
                  'addtime'=>'1231231233'];
        // 将数据写入hash
        $info = \Redis::hMset($key,$names);
        dd($info);
        return view('test');
    }
}


//取数据
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'HASH:TEST';
        $names = ['id'=>'99',
                  'name'=>'AXiBa',
                  'age'=>'23',
                  'tel'=>'13995578699',
                  'addtime'=>'1231231233'];
        // 取出hash里的数据
        $info = \Redis::hGetall($key);
        dd($info);
        return view('test');
    }
}


//取数据（去个别字段）
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'HASH:TEST';
        $names = ['id'=>'99',
                  'name'=>'AXiBa',
                  'age'=>'23',
                  'tel'=>'13995578699',
                  'addtime'=>'1231231233'];
        // 取出hash里的 某一个字段的数据
        $info = \Redis::hGet($key,'name');
        dd($info);
        return view('test');
    }
}


// 判断这个redis key是否存在
\Redis::exists($key)；


//写入一个无序集合（数据插入无顺序）
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'SET:TEST';
        $value = ['a','b','c','d','e'];
        $info = \Redis::sadd($key,$value);
         $info = \Redis::smembers($key);
        dd($info);
        return view('test');
    }
}


//取俩次集合的交集
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'SET:TEST';
        $key1 = 'SET:TEST:1';
        $value = ['a','b','c','d','e'];
        $value1 = ['a','b','c','1','2'];
        // 写入另一个集合
        \Redis::sadd($key1,$value1);
        \Redis::sadd($key,$value);
        // 交集
        $info = \Redis::sinter($key,$key1);
        dd($info);
        return view('test');
    }
}


//求两个集合的并集
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'SET:TEST';
        $key1 = 'SET:TEST:1';
        $value = ['a','b','c','d','e'];
        $value1 = ['a','b','c','1','2'];
        // 并集
        $info = \Redis::sunion($key,$key1);
        dd($info);
        return view('test');
    }
}


//求两个集合的差集
class PhotoController extends Controller  
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $key = 'SET:TEST';
        $key1 = 'SET:TEST:1';
        $value = ['a','b','c','d','e'];
        $value1 = ['a','b','c','1','2'];
        // 差集
        $info = \Redis::sdiff($key,$key1);
        dd($info);
        return view('test');
    }
}



