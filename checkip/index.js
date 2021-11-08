var ping = require("ping");
var axios = require("axios");
const { Pool } = require("pg");
var sql = require("mssql");

const app = require("express")();
var bodyParser = require("body-parser");
const { response } = require("express");
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
    database: "cctv",
    password: "root",
    port: 5432,
});
pool.connect();

// Config Database SQL Server
var config = {
    user: 'sa',
    password: 'Bod33|en17?ha!',
    server: 'localhost', 
    port: 49677,
    database: 'AxTrax1' ,
    synchronize: true,
    trustServerCertificate: true
};

const io = require("socket.io")(server, options);

var dataCctv = [];
var dataAccessDoor = [];
var dataAccessDoorStatus = [];
var parentLocation = [];
var accessDoorCount = 0;
let dataNvr = []
app.post("/checkStatus", (req, res) => {
    getLocation();
});

function getLocation() {
    pool.query(`SELECT cctvs.id AS cctv_id, locations.id AS location_id, locations.name AS location_name,locations.parent_id AS parent_id, cctvs.link AS host FROM locations LEFT JOIN cctvs ON locations.id = cctvs.location_id`, (error, results) => {
        if (error) {
            throw error;
        }
    
        dataCctv = results.rows

        dataCctv.map((loc) => {
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

    pool.query(`SELECT access_doors.id AS access_door_id, locations.id AS location_id, locations.name AS location_name,locations.parent_id AS parent_id, access_doors.link AS host FROM locations LEFT JOIN access_doors ON locations.id = access_doors.location_id`, (error, results) => {
        if (error) {
            throw error;
        }
    
        dataAccessDoor = results.rows

        dataAccessDoor.map((loc) => {
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

async function checkStatus() {
    // CCTV
    if (dataCctv.length > 0) {
        dataCctv.map(async (location) => {
            if (location.parent_id && location.host) {
                let link =  location.host.split("//");
                let newlink = link[link.length - 1].split("/");
                // let newlinkWithNoPort = newlink[newlink.length - 1].split(":");
                let host = newlink[0]

                try {
                    
                    let data = await ping.promise.probe(host);
                    io.emit("realtimeStatus", {
                        id: location.location_id,
                        role: 'child',
                        parent_id: location.parent_id,
                        status: data.alive,
                    });

                    let index = dataNvr.findIndex((i) => {
                        return i.location_id == location.location_id 
                    })

                    let insert = true;
                    if (index >= 0) {
                        if (dataNvr[index].status != data.alive) {
                            dataNvr[index].status = data.alive
                        } else {
                            insert = false
                        }
                    } else {
                        dataNvr.push({
                            location_id: location.location_id,
                            status: data.alive
                        })
                    }

                    // insert notif nvr
                   if (insert) {
                    pool.query("INSERT INTO history_notifications (type, datetime, location, status) values ('nvr', '" + formatDate(Date.now()) + "', '" + location.location_id + "', '" + data.alive + "')", (err, res) => {
                        if (err) {
                            console.log("ERROR INSERT history_notifications NVR", err.stack)
                        } else {
                            io.emit("notifNvr", {
                                nvr: location,
                                status: data.alive
                            });

                            console.log("SUCCESS INSERT history_notifications NVR", location.location_id)
                        }
                    })
                   }

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
                } catch (error) {
                    console.log("ERROR GET LAST DATA NVR HISTORY", error);
                }
            }
        })
    }

    // Access Door
    if (dataAccessDoor.length > 0) {
        dataAccessDoor.map(async (location) => {
            if (location.parent_id && location.host) {
                let link =  location.host.split("//");
                let newlink = link[link.length - 1].split("/");
                // let newlinkWithNoPort = newlink[newlink.length - 1].split(":");
                let host = newlink[0]

                try {
                    
                    let data = await ping.promise.probe(host);

                    let index = dataAccessDoorStatus.findIndex((i) => {
                        return i.location_id == location.location_id 
                    })

                    let insert = true;
                    if (index >= 0) {
                        if (dataAccessDoorStatus[index].status != data.alive) {
                            dataAccessDoorStatus[index].status = data.alive
                        } else {
                            insert = false
                        }
                    } else {
                        dataAccessDoorStatus.push({
                            location_id: location.location_id,
                            status: data.alive
                        })
                    }

                    // insert notif nvr
                   if (insert) {
                    pool.query("INSERT INTO history_notifications (type, datetime, location, status) values ('access_door', '" + formatDate(Date.now()) + "', '" + location.location_id + "', '" + data.alive + "')", (err, res) => {
                        if (err) {
                            console.log("ERROR INSERT history_notifications ACCESS DOOR STATUS", err.stack)
                        } else {
                            // io.emit("notifAccessDoor", {
                            //     access_door: location,
                            //     status: data.alive
                            // });

                            console.log("SUCCESS INSERT history_notifications ACCESS DOOR STATUS", location.location_id)
                        }
                    })
                   }
                } catch (error) {
                    console.log("ERROR GET LAST DATA ACCESS DOOR STATUS HISTORY", error);
                }
            }
        })
    }
}

// Count Access Door Rows
pool.query(`SELECT access_door_count FROM config_apps WHERE id=1 LIMIT 1`, (error, results) => {
    if (error) {
        throw error;
    }
    accessDoorCount = results.rows[0].access_door_count
});

function checkAccessDoor() {
    // connect to your database
    sql.connect(config, function (err) {
        
        if (err) console.log(err);

        // create Request object
        var request = new sql.Request();
        
        setInterval(() => {
            let accesDoorFromSql = [];
            request.query('select * from tblEvents', function (err, data) {
            
                if (err){
                    console.log(err);
                } else {
                    accesDoorFromSql = data.recordset
                    if (accessDoorCount < accesDoorFromSql.length) {
                        // Update table accessdoorcount di table config_apps
                        pool.query("UPDATE config_apps SET access_door_count = " + accesDoorFromSql.length + " where id = 1", (err, res) => {
                            if (err) {
                                console.log("ERROR UPDATE config_apps", err.stack)
                            } else {
                                console.log("SUCCESS UPDATE config_app")
                            }
                        })

                        // Get Image
                        let image = "";
                        let dataDoor = accesDoorFromSql[accesDoorFromSql.length - 1]
                        request.query('select * from tblCameraSnapshot WHERE idEvent=' + dataDoor.IdAutoEvents, function (err, data) {
                            if (data.recordsets.length != 0) {
                                image = data.recordsets[0].tSnapLocation
                            }
                        })
                        // insert notif accessdoor
                        pool.query("INSERT INTO history_notifications (type, datetime, location, picture) values ('access_door', '" + formatDate(dataDoor.dtEventReal) + "', '" + dataDoor.tDesc + "', '" + image + "')", (err, res) => {
                            if (err) {
                                console.log("ERROR INSERT history_notifications ACCESS DOOR", err.stack)
                            } else {
                                console.log("SUCCESS INSERT history_notifications ACCESS DOOR")
                            }
                        })

                        
                        accessDoorCount = accesDoorFromSql.length
                        io.emit("notifAccessDoor", {
                            accessDoor: accesDoorFromSql[accesDoorFromSql.length - 1]
                        });
                    } else {
                        console.log('tidak ada perubahan');
                    }
                }
            });
        }, 5000);
    });
}

checkAccessDoor();

function formatDate(dates) {
    let date_ob = new Date(dates);

    // adjust 0 before single digit date
    let date = ("0" + date_ob.getDate()).slice(-2);

    // current month
    let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);

    // current year
    let year = date_ob.getFullYear();

    // current hours
    let hours = date_ob.getHours();
    if (hours.toString().length < 2) {
        hours = `0${hours}`
    }

    // current minutes
    let minutes = date_ob.getMinutes();

    // current seconds
    let seconds = date_ob.getSeconds();

    // prints date & time in YYYY-MM-DD HH:MM:SS format
    return year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds;
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
