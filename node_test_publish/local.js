var mqtt = require('mqtt')
var client  = mqtt.connect('mqtt://127.0.0.1:1883',{})
console.log(client)
client.on('connect', function () {
    console.log('connected')
//    client.subscribe('v1/devices/me/attributes/response/+')
    client.publish('device/thermostat', '{"temperature":"29"}')
    client.publish('v1/devices/me/telemetry', '{"202.Name":"LV  ","202.m3":"057036.700","202.Type":"LV","202.Itime":0,"202.Ftime":4,"Ch":202}')

    client.publish('v1/devices/me/telemetry', '{"imei":"868333030216093","imsi":"244125009136972","csq":05,"opt":"0x10000001","txtime":60,"sScale":10,"mScale":100,"cycletime":2388,"alarmtime":0}')
    client.publish('v1/devices/me/telemetry', '{"Addr":"kotikot","Sn":"24B2F7035DEEEADC","Host":"Taitotie 305","FLOW":0,"LEAK":0,"LFLOW":0,"LLEAK":0}')
    client.publish('/device/{serial}/{channel}', '{"0.Name":"MAIN","0.m3":0.350,"0.Type":"LV","0.Itime":0,"0.Ftime":0,"Ch":0}')
    client.publish('/device/{serial}/{channel}', '{"1.Name":"????","1.m3":0.000,"1.Type":"KV","1.Itime":0,"1.Ftime":0,"Ch":1}')
    client.publish('/device/{serial}/{channel}', '{"6.Name":"????","6.m3":0.050,"6.Type":"KV","6.Itime":1,"6.Ftime":55,"Ch":6}')
    client.publish('/device/{serial}/{channel}', '{"7.Name":"????","7.m3":0.120,"7.Type":"LV","7.Itime":1,"7.Ftime":1,"Ch":7}')
    client.publish('/device/{serial}/{channel}', '{"201.Name":"KOTI","201.m3":0.100,"201.Type":"KV","201.Itime":1,"201.Ftime":48,"Ch":201}')
    client.publish('/device/{serial}/{channel}', '{"202.Name":"LV  ","202.m3":1.000,"202.Type":"LV","202.Itime":0,"202.Ftime":2,"Ch":202}')
})

client.on('message', function (topic, message) {
    console.log('response.topic: ' + topic)
    console.log('response.body: ' + message.toString())
    client.end()
})
