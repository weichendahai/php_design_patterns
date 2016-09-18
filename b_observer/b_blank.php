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

/*
模仿一个真实例子
银行柜台有一个排队叫号，同时多块小屏幕显示当前呼叫号码，同时音响进行号码呼叫;
当特殊情况下；银行管理人员可更新某一个小屏幕的显示
*/

//================================== =======================

//抽象的主题(抽象的被观察目标)
abstract class Subject 
{/*{{{*/
    //增加一个观察者
    //public function attach (IObserver $observer);
    //删除一个已经注册的观察者
    //public function detach (IObserver $observer);
    //通知所有的观察者
    //public function notifyObservers ();
    //定义一个观察者对象组
    private $_observers;
    public function __construct ()
    {
        $this->_observers = array();
    }
    //添加一个观察者到对象组  
    public function attach (Observer $observer)
    {
        $this->_observers[] = $observer;
        return $this->_observers;
        //return array_push($this->_observers, $observer); 
    }

    //移除从对象组 一个观察者
    public function detach (Observer $observer)
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
        } 
        return TRUE;
    }

    public function getObservers ()
    {
        return $this->_observers; 
    }
}/*}}}*/

// 具体主题角色( 具体的被观察者 ) 银行柜台
class BlankCounter extends Subject
{/*{{{*/
    //当前柜台名字
    private $name = '';
    //当前柜台呼叫号码
    private $bizNo = '';

    public function __construct ($name)
    {
        $this->name = $name;
    }

    public function setBizNo ($bizNo)
    {
        $this->bizNo = $bizNo;
    }

    public function getBizNo ($bizNo)
    {
        return $this->bizNo;
    }

    public function getSubjectInfo()
    {
        return  "请" + $this->bizNo . "号到" . $this->name . "号柜台办理业务"; 
    }
}/*}}}*/

// 具体主题角色( 具体的被观察者 ) 银行管理人员
class BlankManager extends Subject
{/*{{{*/
    //当前柜台名字
    private $name = '';

    public function __construct ($name)
    {
        $this->name = $name;
    }

    public function getSubjectInfo()
    {
        return  "$this->name . 发布最新紧急公告"; 
    }
}/*}}}*/

//抽象的观察者
abstract class Observer 
{/*{{{*/
    //更新信息
    public abstract function update();
}/*}}}*/

//具体观察者111  小屏幕观察者
class smallScreen extends Observer
{/*{{{*/
    // 观察者名称
    private $name = '';
    //  被观察者名称;抽象主题
    private $subject = null;
    public function __construct ($name, $subject)
    {
        $this->name     = $name;
        $this->subject  = $subject;
    }
    //跟新方法
    public function update ()
    {
        echo $this->name . ":" . $this->subject->getSubjectInfo() . "\n";
        //echo 'this is update 111'."\n";
    }
}/*}}}*/

//具体观察者22   音响观察者
class Speaker extends Observer
{/*{{{*/
    // 观察者名称
    private $name = '';
    //  被观察者名称;抽象主题
    private $subject = '';
    public function __construct ($name, $subject)
    {
        $this->name     = $name;
        $this->subject  = $subject;
    }
    //跟新方法
    public function update ()
    {
        echo $this->name . ":" . $this->subject->getSubjectInfo() . "\n";
    }
}/*}}}*/

//模仿调用
function main ()
{/*{{{*/
    //定义一个被观察者(主题1)
    $concreteSubject = new BlankCounter('1号柜台'); 
    //添加观察者
    $observer1 = new smallScreen('1号屏幕', $concreteSubject);
    $observer2 = new smallScreen('2号屏幕', $concreteSubject);
    $observer3 = new Speaker('100号音响', $concreteSubject);
    $concreteSubject->attach ($observer1);
    $concreteSubject->attach ($observer2);
    $concreteSubject->attach ($observer3);
    //当被观察者变化；想通知观察者时候 //9号办理业务
    $concreteSubject->setBizNo("9");
    $concreteSubject->notifyObservers();

    //定义一个被观察者(主题2)
    $subject2 = new BlankManager('银行大厅'); 
    $observer7 = new smallScreen('7号屏幕', $subject2);
    $observer8 = new smallScreen('8号屏幕', $subject2);
    $observer101 = new Speaker('101号音响', $subject2);
    $subject2->attach ($observer7);
    $subject2->attach ($observer8);
    $subject2->attach ($observer101);
    //当被观察者变化；想通知观察者时候 //9号办理业务
    $subject2->notifyObservers();

    //移除第二个观察者
    $concreteSubject->detach ($observer2);
    //当被观察者变化；想通知观察者时候
    $concreteSubject->notifyObservers();
    var_dump($concreteSubject->getObservers());

}/*}}}*/

main();
?>
