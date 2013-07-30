child = exec('./phantomjs dumper.js',
    function (error, stdout, stderr) {
        console.log(stdout, stderr);      // Always empty
        var result = JSON.parse(stdout);
    }
);

/*
var http = require("http");

http.createServer(function(request, response){
    response.writeHead(200);
    response.write("Hello, this is doc");
    response.end();
}).listen(8080);

console.log('listening on port 8080...');

require('shelljs/global');
ls();
*/