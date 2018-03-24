# api-oauth2

Library yang memungkinkan module api menggunakan oauth2 autentikasi.

Module ini membutuhkan konfigurasi pada level aplikasi dengan nama `apiOauth2`
dengan bentuk seperti di bawah:

```php

return [
    '_name' => 'Phun',
    
    'apiOauth2' => [
        // lamanya token bisa digunakan dalam satuan detik
        'token_lifetime' => 3600,
        
        // Nama router yang digunakan untuk user login
        'loginRouter' => 'siteUserLogin'
    ]
];
```

## penggunaan

Buatkan public dan private key, dan simpan di `./etc/oauth2/`. Jalankan perintah
berikut di basepath aplikasi.

```bash
openssl genrsa -out etc/oauth2/privkey.pem 2048
openssl rsa -in etc/oauth2/privkey.pem -pubout -out etc/oauth2/pubkey.pem
```

## Lisensi

Module ini menggunakan library [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php).
Silahkan mengacu ke library tersebut untuk [lisensi](https://github.com/bshaffer/oauth2-server-php/blob/master/LICENSE).