控制反转 是面向对象编程中的一种设计原则，可以用来减低计算机代码之间的耦合度。其中最常见的方式叫做依赖注入（Dependency Injection, DI）, 还有一种叫"依赖查找"（Dependency Lookup）。通过控制反转，对象在被创建的时候，由一个调控系统内所有对象的外界实体，将其所依赖的对象的引用传递给它。也可以说，依赖被注入到对象中。
也就是说，我们需要一个调控系统，这个调控系统中我们存放一些对象的实体，或者对象的描述，在对象创建的时候将对象所依赖的对象的引用传递过去。 在Laravel中Service Container就是这个高效的调控系统，它是laravel的核心。 下面我们看一下laravel是如何实现自动依赖注入的。

laravel中的依赖注入#

现在我们看文档给的例子应该就不难理解了:

namespace App\Jobs;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class PurchasePodcast implements SelfHandling
{
/** * The mailer implementation.
*/
protected $mailer;

/**
 * Create a new instance.
 *
 * @param  Mailer  $mailer
 * @return void
 */
public function __construct(Mailer $mailer)
{
    $this->mailer = $mailer;
}

/**
 * Purchase a podcast.
 *
 * @return void
 */
public function handle()
{
    //
}
}
In this example, the PurchasePodcast job needs to send e-mails when a podcast is purchased. So, we will inject a service that is able to send e-mails. Since the service is injected, we are able to easily swap it out with another implementation. We are also able to easily "mock", or create a dummy implementation of the mailer when testing our application.
说到laravel中的依赖注入，我们不得不了解laravel的Service Container

服务容器 (Service Container)#

The Laravel service container is a powerful tool for managing class dependencies and performing dependency injection. Dependency injection is a fancy phrase that essentially means this: class dependencies are "injected" into the class via the constructor or, in some cases, "setter" methods.
从介绍不难看出服务容器就是控制反转的容器，它就是前文说到的调度系统。实现依赖注入的方式可以是在构造函数中或者setter方法中。

如果我们仔细研究了Service Container我们就会发现laravel的服务容器中只存储了对象的描述，而并不需要知道如何具体的去构造一个对象，因为它会根据php的反射服务去自动解析具体化一个对象。

反射#

在计算机科学中，反射是指计算机在运行时（Run time）可以访问、检测和修改它本身状态或行为的一种能力。用来比喻说，那种程序能够“观察”并且修改自己的行为。

支持反射的语言提供了一些在低级语言中难以实现的运行时特性。这些特性包括

作为一个第一类对象发现并修改源代码的结构（如代码块、类、方法、协议等）。
将跟class或function匹配的转换成class或function的调用或引用。
在运行时像对待源代码语句一样计算字符串。
创建一个新的语言字节码解释器来给编程结构一个新的意义或用途。
PHP实现的反射可以在官网文档中进行查看： 反射API

Example#

$reflector = new ReflectionClass('App\User');

if ($reflector->isInstantiable()) {
$user = $refector->newInstance(); //in other case you can send any arguments
}
laravel的服务容器的build方法中需要通过反射服务来解析依赖关系，比如说construct函数中需要传递的依赖参数有哪些? 它就需要用到如下方法：

$constructor = $reflector->getConstructor();

// If there are no constructors, that means there are no dependencies then
// we can just resolve the instances of the objects right away, without
// resolving any other types or dependencies out of these containers.
if (is_null($constructor)) {
array_pop($this->buildStack);

   return new $concrete;
}

$dependencies = $constructor->getParameters();
现在我们应该对laravel如何实现依赖的自动注入有点想法了吧？来整理一下疑问：

如何实现依赖的自动注入？ （控制反转，利用反射）
依赖注入需要哪些东东？ （整理依赖关系[ construct | setter ]，还要解析依赖传递引用）
怎么解析依赖？
你可能会问为什么要问怎么解析依赖？解析依赖肯定是要用到反射的啦，反射，你知道类名不就可以直接解析了吗？

其实。。。不是这样的。。。(@ο@)

很多时候我们为了提高代码的扩展性和维护性，在编写类时依赖的是接口或抽象类，而并不是一个具体的实现类。明白了吗？依赖解析的时候如果只解析到接口或抽象类，然后利用反射，那么这个依赖肯定是错误的。

那么我们就需要在调度系统中注入相关依赖的映射关系，然后在需要的时候正确的解析关系。 比如说， 喂， 我需要一个 A, 你别给我 B 啊。

$container->bind('a', function () {
return new B(); // just this for you
});

$a = $container->make('a');
总结#

依赖注入是控制反转的一种实现，实现代码解耦，便于单元测试。因为它并不需要了解自身所依赖的类，而只需要知道所依赖的类实现了自身所需要的方法就可以了。你需要我，你却不认识我/(ㄒoㄒ)/~~
控制反转提供一种调控系统，实现依赖解析的自动注入，一般配合容器提供依赖对象实例的引用。