<?php
/*
观察者模式：
    观察者模式(Observer Pattern)：定义对象间的一种一对多依赖关系，使得每当一个对象状态发生改变时，
    其相关依赖对象皆得到通知并被自动更新。观察者模式又叫做发布-订阅（Publish/Subscribe）模式、
    模型-视图（Model/View）模式、源-监听器（Source/Listener）模式或从属者（Dependents）模式。
    观察者模式是一种对象行为型模式。

模式动机
    建立一种对象与对象之间的依赖关系，一个对象发生改变时将自动通知其他对象，
    其他对象将相应做出反应。在此，发生改变的对象称为观察目标，而被通知的对象称为观察者，
    一个观察目标可以对应多个观察者，而且这些观察者之间没有相互联系，可以根据需要增加和删除观察者，
    使得系统更易于扩展，这就是观察者模式的模式动机。

观察者模式包含如下角色：
    Subject: 目标
    ConcreteSubject: 具体目标
    Observer: 观察者
    ConcreteObserver: 具体观察者

适用性：
    当一个抽象模型有两个方面, 其中一个方面依赖于另一方面。将这二者封装在独立的对象中以使它们可以各自独立地改变和复用。
    当对一个对象的改变需要同时改变其它对象, 而不知道具体有多少对象有待改变。
    当一个对象必须通知其它对象，而它又不能假定其它对象是谁。换言之, 你不希望这些对象是紧密耦合的
*/

/*{{{*/
    //interface IObserver{
        //function onSendMsg( $sender, $args );
        //function getName();
    //}

    //interface IObservable{
        //function addObserver( $observer );
    //}

    //class UserList implements IObservable{
        //private $_observers = array();

        //public function sendMsg( $name ){
            //foreach( $this->_observers as $obs ){
                //$obs->onSendMsg( $this, $name );
            //}
        //}

        //public function addObserver( $observer ){
            //$this->_observers[]= $observer;
        //}

        //public function removeObserver($observer_name) {
            //foreach($this->_observers as $index => $observer) {
                //if ($observer->getName() === $observer_name) {
                    //array_splice($this->_observers, $index, 1);
                    //return;
                //}
            //}
        //}
    //}

    //class UserListLogger implements IObserver{
        //public function onSendMsg( $sender, $args ){
            //echo( "'$args' send to UserListLogger\n" );
        //}

        //public function getName(){
            //return 'UserListLogger';
        //}
    //}

    //class OtherObserver implements IObserver{
        //public function onSendMsg( $sender, $args ){
            //echo( "'$args' send to OtherObserver\n" );
        //}

        //public function getName(){
            //return 'OtherObserver';
        //}
    //}


    //$ul = new UserList();//被观察者
    //$ul->addObserver( new UserListLogger() );//增加观察者
    //$ul->addObserver( new OtherObserver() );//增加观察者
    //$ul->sendMsg( "Jack" );//发送消息到观察者

    //$ul->removeObserver('UserListLogger');//移除观察者
    //$ul->sendMsg("hello");//发送消息到观察者
/*}}}*/


//================================== =======================

//抽象的主题(抽象的被观察目标)
interface ISubject 
{/*{{{*/
    //增加一个观察者
    public function attach (IObserver $observer);
    //删除一个已经注册的观察者
    public function detach (IObserver $observer);
    //通知所有的观察者
    public function notifyObservers ();
}/*}}}*/

// 具体主题角色( 具体的被观察者 )
class ConcreteSubject implements ISubject
{/*{{{*/
    //定义一个观察者对象组
    private $_observers;
    public function __construct ()
    {
        $this->_observers = array();
    }
    //添加一个观察者到对象组  
    public function attach (IObserver $observer)
    {
        return array_push($this->_observers, $observer); 
    }

    //移除从对象组 一个观察者
    public function detach (IObserver $observer)
    {
        $index = array_search($observer, $this->_observers);
        if ($index === FALSE || ! array_key_exists($index, $this->_observers)) {
            return FALSE;
        } 

        unset($this->_observers[$index]);
        return TRUE;
    }

    //通知所有观察者
    public function notifyObservers ()
    {
        if (!is_array($this->_observers)) { return FALSE;  } 

        foreach ($this->_observers as $observer) { 
            $observer->update(); 
            $observer->sendMsg(); 
        } 
        return TRUE;
    }

    public function getObservers ()
    {
        return $this->_observers; 
    }
}/*}}}*/

//抽象的观察者
interface IObserver 
{/*{{{*/
    //跟新方法
    public function update ();

    //sendmsg
    public function sendMsg ();

    //获取名字 
    public function getName ();
}/*}}}*/

//具体观察者111
class ConcreteObserver1 implements IObserver
{/*{{{*/
    //跟新方法
    public function update ()
    {
        echo 'this is update 111'."\n";
    }

    //sendmsg
    public function sendMsg ()
    {
        echo 'this is sendMsg 111'."\n";
    }

    //获取名字 
    public function getName ()
    {
        echo 'this is getName 111'."\n";
    }
}/*}}}*/

//具体观察者22
class ConcreteObserver2 implements IObserver
{/*{{{*/
    //跟新方法
    public function update ()
    {
        echo 'this is update 22222'."\n";
    }

    //sendmsg
    public function sendMsg ()
    {
        echo 'this is sendMsg 2222'."\n";
    }

    //获取名字 
    public function getName ()
    {
        echo 'this is getName 2222'."\n";
    }
}/*}}}*/

//模仿调用
function main ()
{/*{{{*/
    //定义一个被观察者
    $concreteSubject = new ConcreteSubject(); 
    //添加观察者
    $observer1 = new ConcreteObserver1();
    //$concreteSubject->attach (new ConcreteObserver1());
    $concreteSubject->attach ($observer1);
    //添加观察者
    $observer2 = new ConcreteObserver2();
    //$concreteSubject->attach (new ConcreteObserver2());
    $concreteSubject->attach ($observer2);
    //当被观察者变化；想通知观察者时候
    $concreteSubject->notifyObservers();

    var_dump($concreteSubject->getObservers());
    //移除第二个观察者
    //$concreteSubject->detach ('ConcreteObserver2');
    $concreteSubject->detach ($observer2);
    //当被观察者变化；想通知观察者时候
    $concreteSubject->notifyObservers();
    
    var_dump($concreteSubject->getObservers());
}/*}}}*/

main();
?>
