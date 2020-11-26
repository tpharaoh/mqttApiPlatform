var mqtt = require('mqtt')
var client  = mqtt.connect('mqtt://188.166.121.39:1883',{username: '248335085DEEEAE8',clientId:"mqttjs01"+Math.random()})
// var client  = mqtt.connect('mqtt://161.35.144.181:1883',{username: '248335085DEEEAE8'})
console.log(client)
client.on('connect', function () {
    console.log('connected')
//    client.subscribe('v1/devices/me/atts/response/+')
    for(let i=0; i<=600; i++) {
        console.log(i)
        client.publish('device/v1/devices/me/telemetry','{"cKeys1":"atdt1,a2tt2","temperature":"0.'+i+'","sharedKeys":"sshared1,sharsed2"}')
        // client.publish('device/thermostat', '{"temperature":"'+i+'"}')
    }
})
//v1/devices/me/telemetry
client.on('message', function (topic, message) {
    console.log('response.topic: ' + topic)
    console.log('response.body: ' + message.toString())
    client.end()
})

