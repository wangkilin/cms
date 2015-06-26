//baseModule.js
var gName;
// 注意是exports.*** 。 类似php的 return 
exports.setName = function(name) {
    gName = name;
};
exports.sayHello = function() {
    console.log('Hello ' + gName);
};