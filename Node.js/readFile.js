//readfile.js
var readFileCallBack = function (err, data)
{
    if (err) {
        console.error(err);
    } else {
        console.log(data);
    }
}
var fs = require('fs');
fs.readFile('readFile.txt', 'utf-8', function(err, data) { // function可以采用callback形式
    if (err) {
        console.error(err);
    } else {
        console.log(data);
    }
});
fs.readFile('readFile.txt', 'utf-8', readFileCallBack);

console.log('end.');