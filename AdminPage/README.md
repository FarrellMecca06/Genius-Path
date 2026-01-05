# Admin Panel - Standalone/Independent

## Deskripsi

Folder **AdminPage** sekarang merupakan **sistem admin yang sepenuhnya independen** dan tidak terhubung dengan aplikasi utama atau WordPress.

## Perubahan Utama

### 1. **Database Configuration**
- ✅ Admin memiliki `config.php` sendiri di folder `AdminPage/`
- ✅ Database credentials disimpan lokal (tidak bergantung pada `php/credentials.php`)
- ✅ Session management independen dengan helper functions

### 2. **Authentication**
- ✅ Admin login di `admin_login.php` (sepenuhnya terpisah dari user login)
- ✅ Session variable: `$_SESSION['admin_id']` dan `$_SESSION['admin_full_name']`
- ✅ Tidak ada sharing session dengan user biasa

### 3. **Header & Footer**
- ✅ `AdminHeader.php` - Header khusus admin yang independen
- ✅ `AdminFooter.php` - Footer khusus admin
- ✅ Tidak import dari `php/header.php` atau `php/footer.php`

### 4. **Styling**
- ✅ `style.css` - Stylesheet admin yang standalone (bukan link ke `php/style.css`)
- ✅ Semua style didefine langsung tanpa dependency eksternal

### 5. **Logout**
- ✅ `logout.php` - Logout khusus admin yang menghancurkan session admin

### 6. **Helper Functions**
Di `AdminPage/config.php`:
```php
redirect($url)          // Header redirect independen
get_current_url()       // Get current URL
base_url()              // Get base URL untuk admin panel
```

## File Structure

```
AdminPage/
├── config.php                 # Database & session config (INDEPENDEN)
├── style.css                  # Admin stylesheet (INDEPENDEN)
├── admin_login.php            # Admin login page
├── AdminHeader.php            # Admin header template
├── AdminFooter.php            # Admin footer template
├── AdminDashboard.php         # Admin dashboard
├── AdminUsers.php             # User management
├── AdminCarrers.php           # Career management
├── AdminTest.php              # Test/Questions management
├── index.php                  # Admin landing page
├── logout.php                 # Admin logout
└── manage-*.php               # Additional management pages
```

## Keamanan

✅ Admin tidak bisa mengakses resources user regular
✅ User regular tidak bisa mengakses admin panel
✅ Session admin terpisah sepenuhnya dari session user
✅ Redirect otomatis jika session tidak valid

## Cara Akses

### Admin Login
```
http://localhost/WAD-Project/wordpress/wp-content/themes/Genius-Path/AdminPage/admin_login.php
```

### Admin Dashboard
```
http://localhost/WAD-Project/wordpress/wp-content/themes/Genius-Path/AdminPage/AdminDashboard.php
```

## Catatan Penting

⚠️ **Gunakan database yang sama** - Admin dan User masih menggunakan database yang sama (`geniuspath`) tetapi dengan table yang berbeda (`admins` vs `users`)

⚠️ **Tidak ada WordPress dependency** - Admin panel sudah sepenuhnya independen dari WordPress functions seperti `wp_redirect()`, `home_url()`, etc.

⚠️ **Testing** - Pastikan test terhadap:
- Login admin vs login user (tidak boleh tercampur)
- Logout admin benar-benar menghapus session
- Redirect otomatis ke login jika session invalid

## Benefit

✅ **Keamanan** - Admin system sepenuhnya terisolasi
✅ **Maintainability** - Perubahan user app tidak akan mempengaruhi admin
✅ **Scalability** - Admin panel bisa di-deploy ke server terpisah di masa depan
✅ **Independence** - Tidak bergantung pada WordPress ecosystem
