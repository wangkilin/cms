var http = require('http');
var port = 81;
http.createServer(function(req, res) {
    res.writeHead(200, {'Content-Type': 'text/html; charset=utf-8'});
    res.write('<h1>欢迎进入Node.js开发</h1>');
	for(var i in res) {
	    //res.write('<hr>');
		//res.write(i);
		//res.write('<br>');
		//res.write(res[i].toString());
		//console.info(res[i]);
		//sleep(10);
	}
	setTimeout(function () {
	    console.info(Math.random());
	    //res.end('<p>Hello World!</p>');
	}, 10000);
	res.end('<p>Hello World!</p>');
    
}).listen(port);
console.log("HTTP server is listening at port " + port);