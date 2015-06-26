//requireModule.js

var myModule = require('./baseModule'); // 不写 .js 后缀。 和thinkPHP里面 $this->display('filename') 一样
myModule.setName('老王');

// 下面代码覆盖了
var yourModule = require('./baseModule'); // 不写 .js 后缀。 和thinkPHP里面 $this->display('filename') 一样
yourModule.setName('王再新');

myModule.sayHello();

// 下面代码， 用两个对象。 避免覆盖
var BaseSingleObject = require('./baseModuleToBeRequiredObject').BaseSingleObject;
var myBaseSingleObject = new BaseSingleObject();
myBaseSingleObject.setName('老王');
var yourBaseSingleObject = new BaseSingleObject();
yourBaseSingleObject.setName('王再新');
console.info(myBaseSingleObject.getName());

// 引入文件包含两个返回， 使用时， 基于返回的对象中的元素进行操作；
// exports.var1 = xxxxx; exports.var2 = xxxxx; 
var BaseSingleOneObject = require('./baseModuleToBeRequiredObject');
var myBaseSingleOneObject = new BaseSingleOneObject.BaseSingleObject2();
console.info(myBaseSingleOneObject.getName());

// 引入文件包含单一返回： module.exports = BaseSingleObject;
var BaseSingleModuleObject = require('./baseSingleModuleToBeRequiredObject');
var myBaseSingleModuleObject = new BaseSingleModuleObject();
console.info(myBaseSingleModuleObject.getName());