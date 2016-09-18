<?php
/*
单例模式:
    单例模式(Singleton Pattern)：单例模式确保某一个类只有一个实例，而且自行实例化并向整个系统提供这个实例，这个类称为单例类，它提供全局访问的方法。
    单例模式的要点有三个：一是某个类只能有一个实例；二是它必须自行创建这个实例；三是它必须自行向整个系统提供这个实例。单例模式是一种对象创建型模式。单例模式又名单件模式或单态模式。
角色：
    Singleton：单例
模式分析：
    单例模式的目的是保证一个类仅有一个实例，并提供一个访问它的全局访问点。单例模式包含的角色只有一个，就是单例类——Singleton。单例类拥有一个私有构造函数，确保用户无法通过new关键字直接实例化它。除此之外，该模式中包含一个静态私有成员变量与静态公有的工厂方法，该工厂方法负责检验实例的存在性并实例化自己，然后存储在静态成员变量中，以确保只有一个实例被创建。
在单例模式的实现过程中，需要注意如下三点：
    1.单例类的构造函数为私有；
    2.提供一个自身的静态私有成员变量；
    3.提供一个公有的静态工厂方法。
*/



class Db {
    //提供一个自身的静态私有成员变量
    private static $conn; 
    // 2.提供一个自身的静态私有
    private function __construct()
    {
        $this->$conn = mysql_connect('localhost','root','');
    }
    //3. 提供一个公有的静态工厂方法。
    public static function getInstance()
    {
        if ( !self::$conn instanceof self ) {
           $self->$conn = new self(); 
        }
        return $conn;
    }

    //3. 提供一个公有的静态工厂方法。(另外一种写法)
    public static function getInstance2()
    {
        if (null === static::$conn) {
            static::$conn = new static();
        }
        return static::$conn;
    }

    //防止对象被复制
    public function __clone(){
        trigger_error('Clone is not allowed !');
    }
}

function main ()
{
    //只能这样取得实例，不能new 和 clone
    $db = Db::getInstance();
}

main();

?>
