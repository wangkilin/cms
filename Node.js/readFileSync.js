//readfilesync.js
var fs = require('fs');
var data = fs.readFileSync('readFile.txt', 'utf-8');
console.log(data);
console.log('end.');