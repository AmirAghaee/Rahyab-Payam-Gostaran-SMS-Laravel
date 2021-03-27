<p align="center">
    <h1 align="center">Rahyab Payam Gostaran SMS Package</h1>
    <br>
</p>

This package provide simple helpers for sending sms from [Rahyab Payam Gostran](http://rahyabcp.ir/) gateway.
<br>
You can download the api gateway document [here](https://smsonline.ir/files/WebService-Send.pdf).

> This is not an official package but there is no other package for this sms gateway!


<!-- TABLE OF CONTENTS -->    
## Table of Contents    
* [Install](#Install)  
* [Usage](#Usage)
* [Logging](#Logging)
* [License](#License)


## Install    
 The easiest way to install is by using Composer:
  
```php
composer require amiraghaee/rahyabsms
```

## Usage
To use the package, you need an password, username and shortcode.
To get that you should have a [smsonline](https://smsonline.ir/) account.
Register and get your authorization details.
<br>
Copy the following variables to your project .env file and fill the variables with your data.
```php
RAHYAB_SMS_USERNAME="your-account-username"
RAHYAB_SMS_PASSWORD="your-account-password"
RAHYAB_SMS_SHORTCODE="your-shortcode"
```

Use rahyabsms on top of your controller or wherever you want:
 ```php
 use AmirAghaee\rahyabsms;
 ```

## send simple sms
Then you can simply create an instance of rahyabsms and use send method to send a text message:
```php
Rahyabsms::send('09xxxxxxxxx','Hello World!');
```
#### parameters
 | Parameter | Required | Description | Type |
 | --- | --- | --- | --- |
 | number | yes | The number of the receiver of the message | string |
 | message | yes | Text to be sent | string |
 | recId | No | assign a ID to check status of delivery | string |

## check credit
You can check balance of your account with this method:
```php
Rahyabsms::getCredit();
```

## check expire
You can check expire of your account with this method:
```php
Rahyabsms::GetExpireDate();
```

## Logging
This package can automatically log sent SMS to the database.
<br>
To enable this, you must copy the following variables into your project .env file.
```php
RAHYAB_SMS_ENABLE_LOGS=true
```
Then run following command to create a table at the root of your project:
```php
php artisan migrate
```
<br>
For accessing to the model use following namespace:

```php
namespace AmirAghaee\rahyabsms\Models;
```

#### example:


```php
SmsLog::get();
```

## License
Freely distributable under the terms of the [MIT](https://opensource.org/licenses/MIT) license.    

