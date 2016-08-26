作者：大水
链接：https://www.zhihu.com/question/27418614/answer/36790033
来源：知乎
著作权归作者所有，转载请联系作者获得授权。

1、基础：一句话实现定义一个函数并立即调用
大家在JavaScript里经常这么搞，因为变量污染是个不可容忍的事儿。但是PHP里如何实现这样的功能？一个可行方法是：
call_user_func(function(){
        echo "hello,world";
});

2、上下文变量
在1的基础上，来个有意思的：用一个匿名函数当做匿名空间，同时调用外部上下文变量：
$context="hello,world";
call_user_func(function()use($context){echo $context;});
等下，有没有觉得这context的叫法有点像Django的感觉？嗯，完全可以利用这个方法可以包装出一个通用的视图方法，但是use不能和$this直接联用，怎么办？既然这个($this)不让用,就用那个($that)。参见第三条。



3、 use和$this

在2的基础之上，更强大的用法（use当前类对象的引用）。
class Contrller {

//...其他方法

public function view($template_name,$context=NULL,$isShow=true){
    ob_start();
    $that=$this;    //注意$this不能直接用于use
    call_user_func(
        //这里可以向视图文件传入参数
        function()use($that,$template_name,$context){    
            $view_path=$that->getViewPath($template_name);    
            include $view_path;
        }
    }
    $out=ob_get_contents();
    ob_end_clean();
    if($isShow){
        echo $out; 
    }else{
        return $out;
    }

}  

}
事实上，这个例子用的做作了，PHP5.3之后适用。经 @张明 同学提醒，自PHP5.4之后，可以无需使用use即可使用$this。
官方文档的参考链接PHP: Anonymous functions
Changelog 
Version Description 
5.4.0 $this can be used in anonymous functions. 
5.3.0 Anonymous functions become available.
这真是件大快人心的大好事！测试demo如下：
class A {

     public  $t;
     public function  __construct($t="hello,world"){
         $this->t=$t;
     }

     function test(){

         call_user_func(function(){
                 echo $this->t;
         });
     }


 }


 $a=new A();
 $a->test();
所以，对于高版本的PHP，就不用搞个$that了。
刚刚去搜了下相关问题，stackoverflow上这组问答非常值得参考，今天才发现，罪过罪过：
php - Using $this in anonymous function
又去翻了下文档，有了这个特性之后，类似JavaScript里apply之类的this劫持也可以实现了，这真是大快人心的事情。

4、碉堡了的特性：调用那个可调用的东西
调用一切可调用的东西，不只是你自定义的函数。
简单例子：把这个用于实现一个通用控制器。
class Contrller{ 


    //调用具体的action，
    public function __act($action){
        call_user_func(
            array($this,$action) 
        ); 
    }

}

class HelloContrller extends Controller{ 

    public function index(){
    }

    public function hello(){
    }

    public function dance(){
    }

}
经 @徐松 同学指出，这个例子也是有点做作，看一眼就好，因为$this->{$action}()的用法更简洁，也更符合直观的思维习惯。虽然这里题目要求是奇技淫巧，还是正常、直观、简洁些好。
再写一个路由（亲测不超过40行即可实现）基本上一个MVC框架的雏形就出来了。

5、利用闭包实现和Python类似的装饰器函数
 <?php

 //装饰器
 $dec=function($func) {
     $wrap=function ()use ($func) {
     echo "before calling you do sth\r\n";
     $func();
     echo "after calling you can do sth too\r\n ";
     };
     return $wrap;
 };

 //执行某功能的函数
 $hello=function (){
     echo "hello\r\n";
 };
 //装饰
 $hello=$dec($hello);



 //在其他地方调用经过装饰的原函数
 $hello(); 

/*output:
before calling you do sth
hello
after calling you can do sth too
*/ 
