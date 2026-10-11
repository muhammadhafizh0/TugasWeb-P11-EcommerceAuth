# TugasWeb-P11-EcommerceAuth

Tugas Rutin 11 — E-Commerce DB + Secure Auth (Laravel 12 + Breeze).

**Muhammad Hafizh Maulana** · PSIK 25D · Ilmu Komputer, UNIMED

## Akun Uji

| Role | Email | Password |
|---|---|---|
| admin | admin@example.com | password |
| editor | editor@example.com | password |
| user | user@example.com | password |

## Menjalankan Project

```bash
composer install
npm install && npm run build
cp .env.example .env        # lalu atur DB_DATABASE=tugasweb_p11
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

---

# Bagian A — Database & Eloquent

## 1. Migrations 7 tabel e-commerce + FK constraints

Tabel: `categories`, `products`, `carts`, `cart_items`, `orders`, `order_items`, ditambah `users` (kolom `role`) dan `posts`.

![Daftar tabel di database tugasweb_p11](screenshots/01-daftar-tabel.png)

Foreign key pada `products.category_id` → `categories.id` (ON DELETE CASCADE).

![Relation view tabel products](screenshots/02-foreign-key.png)

## 2. Seeders + factories (50+ produk)

`CategorySeeder`, `ProductSeeder` (memakai `ProductFactory`), dan `UserSeeder` dipanggil dari `DatabaseSeeder`. Hasil: 6 kategori, **60 produk** (kolom *Rows* pada gambar tabel di atas), dan 3 user.

## 3. Model + relationships + scope

- `Product`: `category()`, `cartItems()`, `orderItems()`, scope `scopeInStock()`.
- `Order`: `user()`, `items()`, scope `scopePaidOrAbove()`.

![Model Product](screenshots/03-model-product.png)

![Model Order](screenshots/04-model-order.png)

## 4. Dokumentasi 5 query Tinker

**Query 1** — 5 produk termahal beserta kategorinya (eager loading).

```php
Product::with('category')->orderByDesc('price')->take(5)->get()->map(fn($p) => "$p->name | $p->price | {$p->category->name}")->all();
```
![Hasil Query 1](screenshots/05-tinker-query1.png)

**Query 2** — jumlah produk yang stoknya masih ada (scope `inStock`).

```php
Product::inStock()->count();
```
![Hasil Query 2](screenshots/06-tinker-query2.png)

**Query 3** — kategori dengan produk terbanyak.

```php
Category::withCount('products')->orderByDesc('products_count')->first()->only(['name','products_count']);
```
![Hasil Query 3](screenshots/07-tinker-query3.png)

**Query 4** — membuat order beserta item-nya untuk user biasa.

```php
$user = User::where('email', 'user@example.com')->first();
$order = $user->orders()->create(['total' => 0, 'status' => 'pending']);
$product = Product::inStock()->first();
$order->items()->create(['product_id' => $product->id, 'quantity' => 2, 'price' => $product->price]);
$order->update(['total' => $product->price * 2]);
```
![Hasil Query 4](screenshots/08-tinker-query4.png)

**Query 5** — order yang sudah dibayar atau lebih (scope `paidOrAbove`).

```php
Order::paidOrAbove()->with('items')->get()->map(fn($o) => ['order_id' => $o->id, 'status' => $o->status, 'item_count' => $o->items->sum('quantity')])->all();
```
![Hasil Query 5](screenshots/09-tinker-query5.png)

> Bonus: eager loading (`with()`) didemonstrasikan pada Query 1.

---

# Bagian B — Auth & Security

## 5. Install Breeze (login/register/logout)

![Halaman login](screenshots/10-login.png)

![Halaman register](screenshots/11-register.png)

## 6. Multi-role (admin/editor/user) + custom middleware

Tabel `users` memiliki kolom `role`. `RoleMiddleware` memeriksa role dan memakai `abort(403)` bila tidak sesuai.

![Tabel users dengan kolom role](screenshots/12-tabel-users-role.png)

![RoleMiddleware](screenshots/13-role-middleware.png)

## 7. PostPolicy untuk otorisasi edit/delete

- **admin**: boleh edit/hapus semua post.
- **editor**: hanya post miliknya sendiri.
- **user**: tidak boleh edit/hapus.

![PostPolicy](screenshots/14-post-policy.png)

## 8. Route protection + testing incognito 2 role

Route lihat/buat post dilindungi `auth`. Route edit/update/hapus dilindungi `auth` + `role:admin,editor`, lalu kepemilikan diperiksa `PostPolicy` lewat `authorize()` di controller.

![routes/web.php](screenshots/15-routes-web.png)

### a) Editor — buat, edit, hapus post sendiri

![Editor membuat post](screenshots/16-editor-buat-post.png)

![Post tersimpan, tombol Edit/Hapus tampil](screenshots/17-editor-post-tersimpan.png)

![Editor mengedit post](screenshots/18-editor-edit-post.png)

![Post berhasil diperbarui](screenshots/19-editor-hasil-edit.png)

![Konfirmasi hapus](screenshots/20-editor-konfirmasi-hapus.png)

![Post berhasil dihapus](screenshots/21-editor-post-dihapus.png)

### b) User biasa (incognito) — ditolak

![User melihat daftar post tanpa tombol Edit/Hapus](screenshots/22-user-daftar-post.png)

![Akses /posts/2/edit oleh user biasa: 403 Forbidden](screenshots/23-user-403-forbidden.png)

### c) Admin (incognito) — boleh mengelola post editor

![Admin melihat tombol Edit/Hapus pada post Editor](screenshots/24-admin-daftar-post.png)

![Admin membuka /posts/2/edit: form edit terbuka](screenshots/25-admin-edit-post-editor.png)

