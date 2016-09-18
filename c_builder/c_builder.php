<?php

//建造者模式：
// 将一个复杂对象的构造与它的表示分离，使同样的构建过程可以创建不同的表示的设计模式;
// 目的：
// 消除其他对象复杂的创建过程
// 建造者模式包含如下角色：
//     1.产品角色，产品角色定义自身的组成属性
//    2.抽象建造者，抽象建造者定义了产品的创建过程以及如何返回一个产品
//    3.具体建造者，具体建造者实现了抽象建造者创建产品过程的方法，给产品的具体属性进行赋值定义
//    4.指挥者，指挥者负责与调用客户端交互，决定创建什么样的产品
// 优点：
//       建造者模式可以很好的将一个对象的实现与相关的“业务”逻辑分离开来，从而可以在不改变事件逻辑的前提下,使增加(或改变)实现变得非常容易。
// 缺点：
//       建造者接口的修改会导致所有执行类的修改。
// 适用场景：
// 1、 需要生成的产品对象有复杂的内部结构。
// 2、 需要生成的产品对象的属性相互依赖，建造者模式可以强迫生成顺序。
// 3、 在对象创建过程中会使用到系统中的一些其它对象，这些对象在产品对象的创建过 程中不易得到。
// 使用建造者模式主要有以下效果：
// 1、 建造者模式的使用使得产品的内部表象可以独立的变化。使用建造者模式可以使客 户端不必知道产品内部组成的细节。
// 2、 每一个Builder都相对独立，而与其它的Builder无关。
// 3、 模式所建造的最终产品更易于控制。

class Product { // 产品本身
    private $_parts; 
    public function __construct() { $this->_parts = array(); } 
    public function add($part) { return array_push($this->_parts, $part); }
}
 
abstract class Builder { // 建造者抽象类
    public abstract function buildPart1();
    public abstract function buildPart2();
    public abstract function getResult();
}
 
class ConcreteBuilder extends Builder { // 具体建造者
    private $_product;
    public function __construct() { $this->_product = new Product(); }
    public function buildPart1() { $this->_product->add("Part1"); }
    public function buildPart2() { $this->_product->add("Part2"); }
    public function getResult() { return $this->_product; }
}
 
class Director { //导演者
    public function __construct(Builder $builder) {
        $builder->buildPart1();
        $builder->buildPart2();
    }
}

// client 
//$buidler = new ConcreteBuilder();
//$director = new Director($buidler);
//$product = $buidler->getResult();
//var_dump($product);

//产品本身
class Result
{/*{{{*/

    private $_htmlHead;
    private $_htmlBody;

    public function setHead ($head) 
    {
         $this->_htmlHead = $head;
    }

    public function setBody ($body) 
    {
         $this->_htmlBody = $body;
    }

    public function parseResult ()
    {
        return $this->_htmlHead."\n".$this->_htmlBody;
    }
}/*}}}*/

//抽象建造者
abstract class RenderResult 
{/*{{{*/
   public abstract function setHtmlHead ($head); 
   public abstract function setHtmlBody ($body); 
   public abstract function getResult ();
}/*}}}*/

//具体的建造者1
class RenderHtmlResult extends RenderResult 
{/*{{{*/
    private $_result;
    public function __construct ()
    {
        $this->_result = new Result();
    }

    public function setHtmlHead ($head)
    {
        $this->_result->setHead ($head) ;
    }

    public function setHtmlBody ($body)
    {
       $this->_result->setBody ($body); 
    }

    public function getResult()
    {
        return $this->_result;    
    }
}/*}}}*/

//具体的建造者2
class RenderJsonResult extends RenderResult 
{/*{{{*/
    private $_result;
    public function __construct ()
    {
        $this->_result = new Result();
    }

    public function setHtmlHead ($head)
    {
        $this->_result->setHead ($head) ;
    }

    public function setHtmlBody ($body)
    {
       $this->_result->setBody ($body); 
    }

    public function getResult()
    {
        return $this->_result;    
    }
}/*}}}*/

//指挥者(导演者)
class DirectRender 
{/*{{{*/
    //private $renderResult; 
    public function __construct ()    
    {
        //$this->renderResult = new RenderResult();
    }

    public function getJsonObject(RenderResult $renderResult)    
    {
       $renderResult->setHtmlHead('head json');
       $renderResult->setHtmlBody('body json');
       $retObj = $renderResult->getResult();
       return $retObj;
    }

    public function getHtmlObject(RenderResult $renderResult)    
    {
       $renderResult->setHtmlHead('head html');
       $renderResult->setHtmlBody('body html');
       $retObj = $renderResult->getResult();
       return $retObj;
    }
    //public function __construct (renderresult $renderresult)    
    //{
       //$renderresult->sethtmlhead();  
       //$renderresult->sethtmlbody();  
    //}

}/*}}}*/

//$r = new Result();
//var_dump($r);
//$r->_htmlHead = 'a';
//var_dump($r);

function main()
{/*{{{*/
   $renderJson = new RenderJsonResult(); 
   $direct = new DirectRender();
   //$result = $renderJson->getResult();
   $result = $direct->getJsonObject($renderJson);
   var_dump($result->parseResult());
   var_dump($result);


   $renderHtml = new RenderHtmlResult(); 
   $direct = new DirectRender();
   $result = $direct->getHtmlObject($renderHtml);

   var_dump($result->parseResult());
   var_dump($result);
}/*}}}*/

main();
?>
