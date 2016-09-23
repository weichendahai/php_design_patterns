<?php
/*

个人理解:类似树形结构数据，可用此模式设计
比如菜单,目录结构遍历等

test1
├── composer.lock
├── dd.md
├── deploy
│   ├── a.sh
│   └── build.sh
├── error-output.txt
├── aaci
│   ├── diff_files_list.log
│   └── diff_log

组合模式（有时候又叫做部分-整体模式,或叫做 合成模式）:
    将对象组合成树形结构以表示“部分整体”的层次结构。组合模式使得用户对单个对象和组合对象的使用具有一致性。
    它使我们树型结构的问题中，模糊了简单元素和复杂元素的概念，客户程序可以像处理简单元素一样来处理复杂元素,
    从而使得客户程序与复杂元素的内部结构解耦,内部可以随意更改扩展

    从类图上看组合模式形成一种树形结构，由枝干和叶子继承Compont显然不符合里氏代换原则
    举个通俗的例子，原子是化学反应的基本微粒，它在化学反应中不可分割。
    现在有 C（碳）、H（氢）、O（氧）、N（氮）4种原子，它们可以随机组合成无数种分子，可以是蛋白质，
    也可以是脂肪，蛋白质和脂肪就是组合。由蛋白质和脂肪又可以一起被组合成肉、大豆等等。

三大角色：
    抽象结构（Component）角色：此角色实现所有类共有接口的默认行为，声明一个接口管理子部件。
    枝节点（Conposite:Protein/Fat）角色：用来存储子部件，实现与子部件有关的操作，如Add()等。
    叶子节点（leaf:C/H/O/N）角色：表示叶子对象，没有子节点。
*/

//代码实现
//header("Content-Type:text/html;Charset=utf-8");
//抽象结构角色
abstract class Component{
    private $name;
    abstract function getType();
    abstract function addComponent($component);
    abstract function removeComponent($component);
    abstract function getComponent($component);
}
//肉是根节点
class Meal extends Component{
    public $items = array();
    function __construct($name){
         $this->name = $name;
    }
    function getType(){
        return $this->name;
    }
    function addComponent($component){
        $this->items[] = $component; 
    }
    function removeComponent($component){
        if(array_search($component, $this->items)){
            unset($this->items[$key]);
        }
    }
    function getComponent($i){
        return $this->items[$i];
    }
}
//蛋白质是枝节点
class Protein extends Component{
    public $items = array();
    function __construct($name){
         $this->name = $name;
    }
    function getType(){
        return $this->name;
    }
    function addComponent($component){
        $this->items[] = $component; 
    }
    function removeComponent($component){
        if(array_search($component, $this->items)){
            unset($this->items[$key]);
        }
    }
    function getComponent($i){
        return $this->items[$i];
    }
}
//脂肪是枝节点
class Fat extends Component{
    public $items = array();
    function __construct($name){
         $this->name = $name;
    }
    function getType(){
        return $this->name;
    }
    function addComponent($component){
        $this->items[] = $component; 
    }
    function removeComponent($component){
        if(array_search($component, $this->items)){
            unset($this->items[$key]);
        }
    }
    function getComponent($i){
        return $this->items[$i];
    }
}
//C是叶子节点
class C extends Component{
    function __construct($name){
         $this->name = $name;
    }
    function getType(){
        return $this->name;
    }
    function addComponent($component){
        return false;
    }
    function removeComponent($component){
       return false;
    }
    function getComponent($component){
        return false;
    }
}
//N是叶子节点
class N extends Component{
    function __construct($name){
         $this->name = $name;
    }
    function getType(){
        return $this->name;
    }
    function addComponent($component){
        return false;
    }
    function removeComponent($component){
       return false;
    }
    function getComponent($component){
        return false;
    }
}
// 测试
$c = new C("碳元素");
$n = new N("氮元素");
$protein = new Protein("蛋白质");
$protein->addComponent($c);
$protein->addComponent($n);
$fat = new Fat("脂肪");
$fat->addComponent($c);
$fat->addComponent($n);
$meal = new Meal("猪肉");
$meal->addComponent($protein);
$meal->addComponent($fat);
print_r($meal->items);

//======================================

//安全式合成模式
interface Component {
    public function getComposite(); //返回自己的实例
    public function operation();
}
 
class Composite implements Component { // 树枝组件角色
    private $_composites;
    public function __construct() { $this->_composites = array(); }
    public function getComposite() { return $this; }
     public function operation() {
         foreach ($this->_composites as $composite) {
            $composite->operation();
        }
     }
 
    public function add(Component $component) {  //聚集管理方法 添加一个子对象
        $this->_composites[] = $component;
    }
 
    public function remove(Component $component) { // 聚集管理方法 删除一个子对象
        foreach ($this->_composites as $key => $row) {
            if ($component == $row) { unset($this->_composites[$key]); return TRUE; }
        } 
        return FALSE;
    }

    public function getChild() { // 聚集管理方法 返回所有的子对象
       return $this->_composites;
    }
 
}
 
class Leaf implements Component {
    private $_name; 
    public function __construct($name) { $this->_name = $name; }
    public function operation() {}
    public function getComposite() {return null;}
}
 
// client
$leaf1 = new Leaf('first');
$leaf2 = new Leaf('second');

$composite = new Composite();
$composite->add($leaf1);
$composite->add($leaf2);
$composite->operation();

$composite->remove($leaf2);
$composite->operation();



//透明式合成模式
interface Component { // 抽象组件角色
    public function getComposite(); // 返回自己的实例
    public function operation(); // 示例方法
    public function add(Component $component); // 聚集管理方法,添加一个子对象
    public function remove(Component $component); // 聚集管理方法 删除一个子对象
    public function getChild(); // 聚集管理方法 返回所有的子对象
}
 
class Composite implements Component { // 树枝组件角色
    private $_composites;
    public function __construct() { $this->_composites = array(); } 
    public function getComposite() { return $this; }
    public function operation() { // 示例方法，调用各个子对象的operation方法
        foreach ($this->_composites as $composite) {
            $composite->operation();
        }
    }
    public function add(Component $component) { // 聚集管理方法 添加一个子对象
        $this->_composites[] = $component;
    }
    public function remove(Component $component) { // 聚集管理方法 删除一个子对象
        foreach ($this->_composites as $key => $row) {
            if ($component == $row) { unset($this->_composites[$key]); return TRUE; }
        } 
        return FALSE;
    }
    public function getChild() { // 聚集管理方法 返回所有的子对象
       return $this->_composites;
    }
 
}
 
class Leaf implements Component {
    private $_name;
    public function __construct($name) {$this->_name = $name;}
    public function operation() {echo $this->_name."<br>";}
    public function getComposite() { return null; }
    public function add(Component $component) { return FALSE; }
    public function remove(Component $component) { return FALSE; }
    public function getChild() { return null; }
}
 
// client 
$leaf1 = new Leaf('first');
$leaf2 = new Leaf('second');

$composite = new Composite();
$composite->add($leaf1);
$composite->add($leaf2);
$composite->operation();

$composite->remove($leaf2);
$composite->operation();

?>
