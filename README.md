# mqttApiPlatform

Credit where credit due...
Inspired by https://devgiants.fr and some of the code from there
**requirements**
* for production, we will use UUID from Symfony 5.2 on device ID
* PHP 7.x
* Api Platform

**Included:**
> Api Platform
>
> Symfony 5
>
> docker (postgress, mosquitto/emqx and mercure)


**TODO**
* move messaging to event
* move trigger to event
* add push notification Interace
* move tokens to parameterBag
* makerFile for app and portal

**Documentation Needed**
* NGINX cluster setup
* how to do the push notifications (incl. Apple/Android steps)
* how to do emqx cluster
* how to publish
* how to set triggers
* how to scope
* how can you use same tool with app
* how to use with Raspberry PI
* how to use with custom code
* how to use API if you can't use MQTT


**Supported Providers**
* Nexmo (SMS)

Planned Support
* Apple (Push)
* Android (Push)
* Vodafone (SMS)
* Telefonica (SMS)

**Comercial**
* hosting support
* create your own cluster with SSL, on AWS, Digital Ocean