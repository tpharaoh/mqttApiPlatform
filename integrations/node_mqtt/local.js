var mqtt = require('mqtt')
var client  = mqtt.connect('mqtt://127.0.0.1:1883',{})
console.log(client)
client.on('connect', function () {
    console.log('connected')
    client.publish('device/e9fb83f6-08ab-4f18-934c-21edbc1a13e0', '{"temperature":"32"}')

})

client.on('message', function (topic, message) {
    console.log('response.topic: ' + topic)
    console.log('response.body: ' + message.toString())
    client.end()
})
