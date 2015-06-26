var http = require('http');
http.createServer(function(req, res) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write('<h1>Node.js</h1>');
	for(var i in res) {
	    res.write('<hr>');
		res.write(i);
		res.write('<br>');
		//res.write(res[i].toString());
		console.info(res[i]);
	}
    res.end('<p>Hello World</p>');
}).listen(3000);
console.log("HTTP server is listening at port 3000.");