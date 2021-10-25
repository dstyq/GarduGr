var ping = require('ping');
var axios = require('axios');

const app = require('express')();
var bodyParser = require('body-parser')
// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))

// parse application/json
app.use(bodyParser.json())

const server = require('http').createServer(app);
const options = {
    cors: {
      origin: "*",
      methods: ["GET", "POST"]
    }
};

const io = require('socket.io')(server, options);

var dataId = [];

app.post('/checkStatus', (req, res) => {
    console.log(req.body)
    if(dataId.indexOf(req.body.id) != -1) {
        clearInterval(prevNowPlaying);
    }
    dataId.push(req.body.id)
    prevNowPlaying = setInterval(() => {
        checkStatus(req)
    }, 1000);
});

function checkStatus(req) {
    ping.promise.probe(req.body.host)
        .then(function (data) {
            io.emit('realtimeStatus', {
                id: req.body.id,
                status: data.alive
            });
    });
}


server.listen(1010, () => {
    console.log('listening on *:1010');
});

var hosts = ['192.168.1.1', 'google.com', 'localhost'];


io.on('connection', function(socket) {
    // Use socket to communicate with this particular client only, sending it it's own id
    socket.emit('welcome', { message: 'Welcome!', id: socket.id });

    socket.on('i am client', console.log);
});