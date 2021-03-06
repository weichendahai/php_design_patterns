<?php

//个人理解:
//比如一个web请求上来，多个对象处理,处理完成；递交给下一个处理者处理

/*
  责任链重写这个方法
  public void test(int i, Request request){
        if(i==1){
            Handler1.response(request);
        }else if(i == 2){
            Handler2.response(request);
        }else if(i == 3){
            Handler3.response(request);
        }else if(i == 4){
            Handler4.response(request);
        }else{
            Handler5.response(request);
        }
    }
*/


//职责链模式（又叫责任链模式）:
//包含了一些命令对象和一些处理对象，每个处理对象决定它能处理那些命令对象，
//它也知道应该把自己不能处理的命令对象交下一个处理对象，
//该模式还描述了往该链添加新的处理对象的方法。

//角色：          
//抽象处理者(Manager)：定义出一个处理请求的接口。如果需要，接口可以定义出一个方法，以设定和返回对下家的引用。这个角色通常由一个抽象类或接口实现。
//具体处理者(CommonManager)：具体处理者接到请求后，可以选择将请求处理掉，或者将请求传给下家。
							//由于具体处理者持有对下家的引用，因此，如果需要，具体处理者可以访问下家。
// 适用场景：          
 //    1、有多个对象可以处理同一个请求，具体哪个对象处理该请求由运行时刻自动确定。
 //    2、在不明确指定接收者的情况下，向多个对象中的一个提交一个请求。
	// 3、可动态指定一组对象处理请求。
// 简单的总结责任链模式,可以归纳为：
// 	用一系列类(classes)试图处理一个请求request,这些类之间是一个松散的耦合,唯一共同点是在他们之间传递request. 也就是说，来了一个请求，A类先处理，如果没有处理，就传递到B类处理，如果没有处理，就传递到C类处理，就这样象一个链条(chain)一样传递下去。

/*{{{*/
abstract class Responsibility { // 抽象责任角色
    protected $next; // 下一个责任角色
 
    public function setNext(Responsibility $l) {
        $this->next = $l;
        return $this;
    }
    abstract public function operate(); // 操作方法
}
 
class ResponsibilityA extends Responsibility {
    public function __construct() {}
    public function operate(){
        if (false == is_null($this->next)) {
            $this->next->operate();
            echo 'Res_A start'."\n";
        }
    }
}

class ResponsibilityB extends Responsibility {
    public function __construct() {}
    public function operate(){
        echo 'Res_B start'."\n";;

        if (false == is_null($this->next)) {
            $this->next->operate();
        }
    }
}
 
$res_a = new ResponsibilityA();
$res_b = new ResponsibilityB();

$res_a->setNext($res_b);
$res_a->operate();
/*}}}*/

//====================================== 请假 

/*{{{*/
//模拟一个request请求对象；不是模式必须角色
class Request
{/*{{{*/
    public $name;
    public $requestContent;
    public $reason;
    public $num;

    function __construct ($name, $requestContent, $reason, $num)
    {
		$this->name = $name;
		$this->requestContent = $requestContent;
		$this->num = $num;
		$this->reason = $reason;
    }
}/*}}}*/


//抽象处理类，定义处理者具有的公共属性和具体处理类需要实现的接口
abstract class AbstractManager 
{/*{{{*/
    protected $name; //姓名
    protected $position; //职位
    protected $head; //上司
    public function __construct($name,$position){
        $this->name = $name;
        $this->position = $position;
    }

    //设置上司
    public function setHead (AbstractManager $head)
    {
        $this->head = $head;
    }
    //抽象的处理请求的方法
    public abstract function handleRequest (Request $request);
}/*}}}*/

//具体处理类,（经理，可以处理不大雨7天的假期和不多余1000元的加薪）
class Director extends AbstractManager
{/*{{{*/
    public function __construct ($name, $position)
    {
        parent::__construct ($name, $position);
    }

    //处理请求的具体方法
    public function handleRequest (Request $request)
    {
       if (($request->requestContent == '请假' && $request->num < 7) || ($request->requestContent == '加薪' && $request->num < 1000)) {
           return $request->name . '的' . $request->requestContent . '请求已被' . $this->name . '批准';
       } else {
           if (isset($this->head)) {
               return $this->head->handleRequest($request);
           }
       }
    }
}/*}}}*/

//具体处理类,（总监，可以处理不大雨15天的假期和不多余2000元的加薪）
class Majordomo extends AbstractManager
{/*{{{*/
    public function __construct ($name, $position)
    {
        parent::__construct ($name, $position);
    }

    //处理请求的具体方法
    public function handleRequest (Request $request)
    {
       if (($request->requestContent == '请假' && $request->num < 15) || ($request->requestContent == '加薪' && $request->num < 2000)) {
           return $request->name . '的' . $request->requestContent . '请求已被' . $this->name . '批准';
       } else {
           if (isset($this->head)) {
               return $this->head->handleRequest($request);
           }
       }
    }
}/*}}}*/

//具体处理类，总经理,可以处理请假和加薪请求
class GeneralManager extends AbstractManager
{/*{{{*/
    public function __construct ($name, $position)
    {
        parent::__construct ($name, $position);
    }

    //处理请求的具体方法
    public function handleRequest (Request $request)
    {
       if (($request->requestContent == '请假' && $request->num < 30) || ($request->requestContent == '加薪' && $request->num < 5000)) {
           return $request->name . '的' . $request->requestContent . '请求已被' . $this->name . '批准';
       } else {
            //最后审核人
            return $request->name."的".$request->requestContent."请求已被".$this->name."否决！";
       }
    }
}/*}}}*/

//调用
function main()
{/*{{{*/

    $generalManagerWang = new GeneralManager('王五','总经理');
    $majordomoLi        = new Majordomo('李四','总监');
    $directZhang        = new Director('张三','经理');

    //这只上级关系
    $majordomoLi->setHead($generalManagerWang);
    $directZhang->setHead($majordomoLi);

    $request = new Request("员工甲","请假","如果你有问题，可以随时找我，良辰就喜欢对自以为是的人出手",100);
    $result = $directZhang->handleRequest($request);  //员工甲的请假请求已被王五否决！
    echo $result . "\n";

    $request = new Request("员工乙","请假","如果你有问题，可以随时找我，良辰就喜欢对自以为是的人出手",28);
    $result = $directZhang->handleRequest($request);  //员工乙的请假请求已被王五批准！
    echo $result . "\n";

    $request = new Request("员工丙","请假","如果你有问题，可以随时找我，良辰就喜欢对自以为是的人出手",3);
    $result = $directZhang->handleRequest($request);  //员工丙的请假请求已被张三批准！
    echo $result . "\n";
}/*}}}*/

main();
/*}}}*/

//====================================== log

/*{{{*/
abstract class AbstractLogger 
{/*{{{*/
   public static $DEBUG = 1;
   public static $INFO  = 2;
   public static $ERROR = 3;

   protected  $level;
    function __construct($level) 
    {
        $this->level = $level;
    }

   //责任链中的下一个元素
   protected $nextLogger;

   public function setNextLogger(AbstractLogger $nextLogger)
   {
      $this->nextLogger = $nextLogger;
   }

   public function logMessage( $level,  $message)
   {
      if($this->level <= $level) {
         $this->write($message);
      }
      if($this->nextLogger != null) {
         $this->nextLogger->logMessage($level, $message);
      }
   }

   abstract protected function write ($message);
	
}/*}}}*/

class DebugLogger extends AbstractLogger
{/*{{{*/
    function __construct($level) 
    {
        parent::__construct($level);
    }

   protected function write( $message) {		
     echo "Debug Console::Logger: $message \n";
   }
}/*}}}*/

class InfoLogger extends AbstractLogger
{/*{{{*/
    function __construct($level) 
    {
        parent::__construct($level);
    }

   protected function write( $message) {		
     echo "info Console::Logger: $message \n";
   }
}/*}}}*/

class ErrorLogger extends AbstractLogger
{/*{{{*/
    function __construct($level) 
    {
        parent::__construct($level);
    }

   protected function write( $message) {		
     echo "Error Console::Logger: $message \n";
   }
}/*}}}*/

function main2 ()
{/*{{{*/
    $debugLogger    = new DebugLogger(AbstractLogger::$DEBUG);
    $infoLogger     = new InfoLogger(AbstractLogger::$INFO);
    $errorLogger    = new ErrorLogger(AbstractLogger::$ERROR);
    $debugLogger->setNextLogger ($infoLogger);
    $infoLogger->setNextLogger ($errorLogger);

    //取优先级最低的进行开始
    $loggerChain = $debugLogger;
    $loggerChain->logMessage(AbstractLogger::$DEBUG, "This is an debug level information. 111");
    $loggerChain->logMessage(AbstractLogger::$INFO,  "This is an information. 2222");
    $loggerChain->logMessage(AbstractLogger::$ERROR, "This is an error information. 333");
}/*}}}*/

main2();

//输出
//Debug Console::Logger: This is an debug level information. 111
//Debug Console::Logger: This is an information. 2222
//info Console::Logger: This is an information. 2222
//Debug Console::Logger: This is an error information. 333
//info Console::Logger: This is an error information. 333
//Error Console::Logger: This is an error information. 333
/*}}}*/
?>
