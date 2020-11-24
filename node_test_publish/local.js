var mqtt = require('mqtt')
var client  = mqtt.connect('mqtt://127.0.0.1:1883',{})
console.log(client)
client.on('connect', function () {
    console.log('connected')
//    client.subscribe('v1/devices/me/attributes/response/+')
    client.publish('device/thermostat', '{"temperature":"29"}')
})

client.on('message', function (topic, message) {
    console.log('response.topic: ' + topic)
    console.log('response.body: ' + message.toString())
    client.end()
})
