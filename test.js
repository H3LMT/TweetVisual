/*var http = require('http');

http.createServer(function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.end('Hello World!');
    console.log("success");
}).listen(80);*/

/*var http = require('http');
var url = require('url');

http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/html'});
  var q = url.parse(req.url, true).query;
  var txt = q.year + " " + q.month;
  res.end(txt);
}).listen(8080);*/

/*var http = require('http');
var url = require('url');
var fs = require('fs');

http.createServer(function (req, res) {
  var q = url.parse(req.url, true);
  var filename = "." + q.pathname;
  console.log("success")
  fs.readFile(filename, function(err, data) {
    if (err) {
      res.writeHead(404, {'Content-Type': 'text/html'});
      return res.end("404 Not Found");
    }  
    console.log(q)
    console.log(filename)
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    res.write("testest");
    return res.end();
  });
}).listen(8080);*/

// Initialize the database
var MongoClient = require('mongodb').MongoClient;
var url = "mongodb://localhost:27017/mydb";

MongoClient.connect(url, function(err, db) {
  if (err) throw err;
  console.log("Database created!");
  db.close();
});

// set up requirements to use express
const express = require('express')
var bodyParser = require("body-parser");
const app = express()

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.get('/', (req, res) => res.send('Hello World!'))

app.get('/test.html', function (req, res) {
    res.sendFile(__dirname + "/" + "test.html"); // render test.html
})

app.post('/test.html', function (req, res) {
    // passes back the parameters sent over
    res.setHeader('Content-Type', 'application/json');
    res.send(JSON.stringify({
        name: req.body.name || null,
        city: req.body.city || null
    }));
})

app.listen(3000, () => console.log('Example app listening on port 3000!'))