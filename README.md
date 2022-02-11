# Blog App
Blog Api ile
- Makale ekleme, listeleme,düzenleme ve silme işlemi<br>
- Kategori ekleme, listeleme,düzenleme ve silme işlemi<br>
- Kullanıcı kayıt, listeleme,login,logout işlemleri<br>
- Newsletter bültene kayıt ve mail gönderme işlemi<br>
- İstatistikler ile toplam makale, toplam bülten abone,toplam makale gösterim sayısı, bu hafta yayınlanan makaleler, bu ay abone olanların sayısı listelenmektedir.   <br>  
 Veritabanı oluşturulması için terminal ekranına;
 - **create blog-app database** <br> 
 komutu ile veritabanı oluşturulmalıdır.
 
 database/migrations klasör altında migration create table dosyaları bulunmaktadır.
 
 Kurulum için terminal ekranına<br>
 - **php artisan migrate** <br>
 komutu çalıştırılmalıdır.

 Tablolara örnek veriler girmek için;
 database/seeders klasör altında seeder dosyaları bulunmaktadır.
 
 Kurulum için terminal ekranına<br>
 - **php artisan db:seed** <br>
 komutu çalıştırılmalıdır.
 
 Authentication ve authorization işlemleri için;
 - **composer require laravel/passport** <br>
  Kütüphanesi indirilip 
 - **php artisan passport:install**

   komutu ile paket yüklenmelidir.
   
   Ortamdaki Bazı Bilgiler Düzenlenmelidir<br><br>
    **Veritabanı Bilgileri**
    - DB_CONNECTION=mysql
    - DB_HOST=localhost
    - DB_PORT=3306
    - DB_DATABASE=blog-app
    - DB_USERNAME=root
    - DB_PASSWORD=
 
    **Mail Bilgileri**
   - MAIL_MAILER=smtp
   - MAIL_HOST=smtp.gmail.com
   - MAIL_PORT=587
   - MAIL_USERNAME=mailadresiniz
   - MAIL_PASSWORD=şifreniz
   - MAIL_ENCRYPTION=tls
   - MAIL_FROM_ADDRESS=mailadresiniz
   - MAIL_FROM_NAME='Blog App'
   
   **Mail Kuyruk için env eklenmelidir**
   - QUEUE_CONNECTION=database
       
    **Redis cache için env eklenmelidir**

    - REDIS_CLIENT = predis
    - REDIS_HOST=127.0.0.1
    - REDIS_PASSWORD=null
    - REDIS_PORT=6379
    
    - CACHE_DRIVER=redis

    **Processes**
     - Auth
     - Articles
     - Category
     - Newsletter
     - Statistics
 
 Kurulumlar bittikten sonra cache temizlenmesi için aşağıdaki komutları çalıştırınız.
 - **php artisan route:cache**
 - **php artisan config:cache**
 
 **Authentication**
 
 - http://project.local/api/register --> kayıt ol
 - http://project.local/api/login --> giriş yap ve token oluştur
 
 Giriş yaptıktan sonra oluşan tokeni postman içinde {{token}} değişkene atayarak tüm request işlemlerini gerçekleştirebilisiniz.
 Tüm örnek requestler için 
 **/data/blog-app.postman_collection.json** bakınız.


 Newsletter kayıt olduktan sonra jobs çalıştırmak için;
 - php artisan queue:work

komutunu çalıştırınız.
