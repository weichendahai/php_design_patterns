# Php_Design_Patterns #
学习理解设计模式，记录PHP关于23种设计模式的使用,欢迎star  

设计模式分为：创建型模式， 结构型模式，行为型模式等23种设计模式。 

### 一、五种创建型模式如下：
工厂方法模式factory_method   
抽象工厂模式abstract_factory  
单例模式singleton  
建造者模式builder   
原型模式prototype   

### 二、七种结构型模式如下：
适配器模式adapter    
桥接模式bridge    暂时不看
合成模式composite   类似树形结构数据，可用此模式设计;最终获得树形结构
装饰器模式decorator    暂时不看
门面模式facade    暂时不看
代理模式proxy    暂时不看
享元模式flyweight   暂时不看

### 三、十一行为型模式如下：
策略模式strategy
模板方法模式template_method  一个操作中的算法的骨架，而将步骤延迟到子类中
观察者模式observer    一个对象变化时，通知观察她的对象；（银行呼号，屏幕显示
迭代器模式decorator   很简单；就是对象数组迭代遍历
责任链模式responsibility_chain  一条链条；一个一个判断；看符合什么条件；然后运行
命令模式command  暂时不看
备忘录模式memento 暂时不看 (有一个游戏玩家生命值的案例)
状态模式state     暂时不看
访问者模式visitor 暂时不看
中介者模式mediator 暂时不看
解释器模式interpreter  暂时不看

### 设计模式六大原则： 
开放封闭原则：一个软件实体如类、模块和函数应该对扩展开放，对修改关闭。  
里氏替换原则：所有引用基类的地方必须能透明地使用其子类的对象.  
依赖倒置原则：高层模块不应该依赖低层模块，二者都应该依赖其抽象；抽象不应该依赖细节；细节应该依赖抽象。  
单一职责原则：不要存在多于一个导致类变更的原因。通俗的说，即一个类只负责一项职责。  
接口隔离原则：客户端不应该依赖它不需要的接口；一个类对另一个类的依赖应该建立在最小的接口上。  
迪米特法则：一个对象应该对其他对象保持最少的了解。  # php_design_patterns

### 备注参考：
如何看懂uml
http://design-patterns.readthedocs.io/zh_CN/latest/read_uml.html
https://github.com/yunkaiyueming/php_design_patterns
