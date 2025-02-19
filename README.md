# Ideasoft E-commerce API

Bu proje, Ideasoft case için hazırlanmıştır.

Proje, bir e-ticaret platformu için API sunmaktadır. API, müşteri, ürün ve sipariş yönetimi yapılmasını sağlar. Ayrıca, siparişler üzerinde indirim uygulamaları yapılabilir.

## Teknolojiler

- PHP 8.2
- Laravel 11
- MySQL 8.0
- Docker

## Kurulum

1. Projeyi klonlayın:
```bash
git clone https://github.com/Kripteks/ideasoft-case.git
cd ideasoft-case
```

2. Gerekli paketleri yükleyin:
```bash
composer install
```

3. Ortam değişkenlerini ayarlayın:
```bash
cp .env.example .env
php artisan key:generate
```

4. Docker container'larını başlatın:
```bash
./vendor/bin/sail up -d
```

5. Veritabanı migration'larını çalıştırın:
```bash
./vendor/bin/sail artisan migrate
```

6. (Opsiyonel) Örnek verileri yükleyin:
```bash
./vendor/bin/sail artisan db:seed
```

## API Endpoints

### Siparişler

#### Sipariş Listesi
```bash
curl --location 'http://localhost/api/orders' \
--header 'Accept: application/json'
```

#### Yeni Sipariş Oluşturma
```bash
curl --location 'http://localhost/api/orders' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data '{
    "customer_id": 1,
    "items": [
        {
            "product_id": 1,
            "quantity": 2
        },
        {
            "product_id": 2,
            "quantity": 1
        }
    ]
}'
```

#### Sipariş Detayı Görüntüleme
```bash
curl --location 'http://localhost/api/orders/1' \
--header 'Accept: application/json'
```

#### Sipariş Silme
```bash
curl --location --request DELETE 'http://localhost/api/orders/1' \
--header 'Accept: application/json'
```

### İndirimler

#### Sipariş İndirimi Hesaplama
```bash
curl --location 'http://localhost/api/orders/discount/1' \
--header 'Accept: application/json'
```

## İndirim Kuralları

1. Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanır.
2. 2 ID'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilir.
3. 1 ID'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılır.

## Örnek Yanıtlar

### Başarılı Sipariş Oluşturma
```json
{
    "data": {
        "id": 1,
        "customer": {
            "id": 1,
            "name": "John Doe",
            "since": "2023-01-01",
            "revenue": "5000.00"
        },
        "items": [
            {
                "product": {
                    "id": 1,
                    "name": "Product 1",
                    "category": 1,
                    "price": "100.00",
                    "stock": 8
                },
                "quantity": 2,
                "unit_price": "100.00",
                "total": "200.00"
            }
        ],
        "total": "200.00"
    }
}
```

### İndirim Hesaplama
```json
{
    "orderId": 1,
    "totalDiscount": 20.00,
    "discountedTotal": 180.00,
    "discounts": [
        {
            "discountReason": "20% discount on cheapest item from category 1",
            "discountAmount": 20.00
        }
    ]
}
```
