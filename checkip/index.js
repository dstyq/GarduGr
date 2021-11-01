var ping = require("ping");
var axios = require("axios");
const { Pool } = require("pg");

const app = require("express")();
var bodyParser = require("body-parser");
// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }));

// parse application/json
app.use(bodyParser.json());

const server = require("http").createServer(app);
const options = {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
};

// Config Database Postgresql
const pool = new Pool({
    user: "postgres",
    host: "localhost",
    database: "cctv_monitoring",
    password: "root",
    port: 5432,
});
pool.connect();

const io = require("socket.io")(server, options);

var dataLocation = [];
var parentLocation = [];

app.post("/checkStatus", (req, res) => {
    getLocation();
});

function getLocation() {
    pool.query(`SELECT cctvs.id AS cctv_id, locations.id AS location_id, locations.parent_id AS parent_id, cctvs.link AS host FROM locations LEFT JOIN cctvs ON locations.id = cctvs.location_id`, (error, results) => {
        if (error) {
            throw error;
        }
    
        dataLocation = results.rows

        dataLocation.map((loc) => {
            if (loc.parent_id != null) {
                if (typeof parentLocation[loc.parent_id] == 'undefined') {
                    parentLocation[loc.parent_id] = [{
                        id: loc.location_id,
                        status: false
                    }]
                } else {
                    parentLocation[loc.parent_id].push({
                        id: loc.location_id,
                        status: false
                    })
                }
            }
        })
    });
}

getLocation();
function checkStatus() {
    if (dataLocation.length > 0) {
        dataLocation.map((location) => {
            if (location.parent_id) {
                let link =  location.host.split("//");
                let newlink = link[link.length - 1].split("/");
                // let newlinkWithNoPort = newlink[newlink.length - 1].split(":");
                let host = newlink[0]

                ping.promise.probe(host).then(function (data) {
                    io.emit("realtimeStatus", {
                        id: location.location_id,
                        role: 'child',
                        parent_id: location.parent_id,
                        status: data.alive,
                    });

                    parentLocation[location.parent_id].map((loc, index) => {
                        if (loc.id == location.location_id) {
                            parentLocation[location.parent_id][index].status = data.alive
                        }
                    })

                    if (parentLocation[location.parent_id].every(checkStatusChild)) {
                        io.emit("realtimeStatus", {
                            id: location.parent_id,
                            role: 'parent',
                            status: true,
                        });
                    } else {
                        io.emit("realtimeStatus", {
                            id: location.parent_id,
                            role: 'parent',
                            status: false,
                        });
                    }
                });
            }
        })
    }
}

function checkStatusChild(loc) {
    return loc.status == true;
}

setInterval(() => {
    checkStatus()
}, 1000);

server.listen(1010, () => {
    console.log("listening on *:1010");
});

io.on("connection", function (socket) {
    // Use socket to communicate with this particular client only, sending it it's own id
    socket.emit("welcome", { message: "Welcome!", id: socket.id });

    socket.on("i am client", console.log);
});
