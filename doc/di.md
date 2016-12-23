没有你我就活不下去，那么，你就是我的依赖。 说白了就是：

不是我自身的，却是我需要的，都是我所依赖的。一切需要外部提供的，都是需要进行依赖注入的。
我们用代码来描述一下：

class Boy {
protected $girl;

public function __construct(Girl $girl) {
$this->girl = $girl;
}
}

class Girl {
...
}

$boy = new Boy(); // Error; Boy must have girlfriend!

// so 必须要给他一个女朋友才行
$girl = new Girl();

$boy = new Boy($girl); // Right! So Happy!
从上述代码我们可以看到Boy强依赖Girl必须在构造时注入Girl的实例才行。

那么为什么要有依赖注入这个概念，依赖注入到底解决了什么问题？

我们将上述代码修正一下我们初学时都写过的代码:

class Boy {
protected $girl;

public function __construct() {
$this->girl = new Girl();
}
}
这种方式与前面的方式有什么不同呢？

我们会发现Boy的女朋友被我们硬编码到Boy的身体里去了。。。 每次Boy重生自己想换个类型的女朋友都要把自己扒光才行。。。 (⊙o⊙)…

某天Boy特别喜欢一个LoliGirl ,非常想让她做自己的女朋友。。。怎么办？ 重生自己。。。扒开自己。。。把Girl扔了。。。把 LoliGirl塞进去。。。

class LoliGirl {

}

class Boy {
protected $girl;

public function __construct() {
// $this->girl = new Girl(); // sorry...
$this->girl = new LoliGirl();
}
}
某天 Boy迷恋上了御姐.... (⊙o⊙)… Boy 好烦。。。

是不是感觉不太好？每次遇到真心相待的人却要这么的折磨自己。。。

Boy说，我要变的强大一点。我不想被改来改去的！

好吧，我们让Boy强大一点：

interface Girl {
// Boy need knows that I have some abilities.
}

class LoliGril implement Girl {
// I will implement Girl's abilities.
}

class Vixen implement Girl {
// Vixen definitely is a girl, do not doubt it.
}

class Boy {
protected $girl;

public function __construct(Girl $girl) {
$this->girl = $girl;
}
}

$loliGirl = new LoliGirl();
$vixen = new Vixen();

$boy = new Boy($loliGirl);
$boy = new Boy($vixen);
Boy很高兴，终于可以不用扒开自己就可以体验不同的人生了。。。So Happy!

小结#

因为大多数应用程序都是由两个或者更多的类通过彼此合作来实现业务逻辑，这使得每个对象都需要获取与其合作的对象（也就是它所依赖的对象）的引用。如果这个获取过程要靠自身实现，那么将导致代码高度耦合并且难以维护和调试。
所以才有了依赖注入的概念，依赖注入解决了以下问题：

依赖之间的解耦
单元测试，方便Mock 