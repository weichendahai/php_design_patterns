<?php

//工厂模式
/*
* 工厂方法模式：
* 一个抽象产品类，可以派生出多个具体产品类。 
* 一个抽象工厂类，可以派生出多个具体工厂类。 
* 每个具体工厂类只能创建一个具体产品类的实例。
*/

//抽象的产品类
abstract class Render
{/*{{{*/
}/*}}}*/

//抽象产品类，派生出多个具体产品类
class RenderHtml extends Render
{/*{{{*/
    public function render($text)
    {
        return '<html><head><title>testTitle</title></head><body>'. $text .'</body></html>';
    }
}/*}}}*/

//抽象产品类，派生出多个具体产品类
class RenderJson extends Render
{/*{{{*/
    public function render($text)
    {
        return '{'.$text.'}';
    }
}/*}}}*/

//一个抽象工厂类，可以派生出多个具体工厂类。 
interface IRenderResult
{/*{{{*/
   public function createResultClass($type);     
}/*}}}*/

//每个具体工厂类只能创建一个具体产品类的实例。
class RenderResultHtml implements IRenderResult 
{/*{{{*/
   public function createResultClass()
   {
        return new RenderHtml();
        break;
   }
}/*}}}*/

//每个具体工厂类只能创建一个具体产品类的实例。
class RenderResultJson implements IRenderResult 
{/*{{{*/
   public function createResultClass()
   {
        return new RenderJson();
        break;
   }
}/*}}}*/

function main()
{/*{{{*/
    $htmlFactory = new RenderResultHtml(); 
    $htmlProtect = $htmlFactory->createResultClass();
    $ret = $htmlProtect->render('我要渲染为html');
    echo "$ret \n";

    $jsonFactory = new RenderResultJson(); 
    $jsonProduce = $jsonFactory->createResultClass();
    $ret = $jsonProduce->render('我要渲染为json');
    echo "$ret \n";
}/*}}}*/

main();

?>
