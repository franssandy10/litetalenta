var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis('redis://:P46UfraDUm5spUbRuQeFESwuWR4b87fU@119.81.220.24:6379/0')
/*var client = Redis.createClient(6379, 'http://119.81.220.24', 'P46UfraDUm5spUbRuQeFESwuWR4b87fU');
client.auth('P46UfraDUm5spUbRuQeFESwuWR4b87fU', function (err) {
    if (err) {
    	console.log(err)
    };
});

client.on('connect', function() {
    console.log('Connected to Redis');
});*/
var arrayUserId = {};
io.on('connection', function(socket){
  console.log("connect with id= "+socket.id);
  arrayUserId[socket.id] =socket.request._query['data'];

  redis.subscribe('notif',function(err,count){
    console.log('notif');
  });
  redis.subscribe('payroll', function(err, count) {
    console.log("payroll");
  });
  redis.subscribe('salary', function(err, count) {
    console.log("salary");
  });
  socket.on('disconnect',function(){
    console.log(socket.id+' Disconnected');
    delete arrayUserId[socket.id];
      console.log(arrayUserId);
  })
  console.log(arrayUserId);
});

redis.on('message', function(channel, message) {
  // console.log('Channel: '+channel+' Message Received: ' + message);
  message = JSON.parse(message);

  // send to with name events
  // console.log(message.user_access);
  userAccess=Object.keys(arrayUserId).filter(function(key) {
    return arrayUserId[key] == message.user_access;
  })
  console.log(message.employee);
  io.to(userAccess).emit(channel, message.employee);

});
http.listen(3000, function(){
    console.log('Listening on Port 3000');
});
