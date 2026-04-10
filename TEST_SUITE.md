# Test Suite Documentation - Aplikasi Parkir

## Overview
Comprehensive test suite untuk aplikasi manajemen parkir yang mencakup:
- **135 Tests** dengan **211 Assertions**
- **4 Test Classes** di Unit/Models
- **5 Feature Test Classes**
- **100% Pass Rate** ✅

## Test Structure

### 1. Unit Tests (Models)
Lokasi: `tests/Unit/Models/`

#### UserModelTest.php
Menguji model User dan relationships-nya:
- ✅ User creation dengan password hashing
- ✅ User relationships (Kendaraan, Transaksi, LogAktivitas)
- ✅ Password hidden di array output
- ✅ Role validation (admin, petugas, owner)
- ✅ Status aktif casting ke boolean

#### KendaraanModelTest.php
Menguji model Kendaraan:
- ✅ Kendaraan creation dan data integrity
- ✅ Belongs to User relationship
- ✅ Has many Transaksi relationship
- ✅ Vehicle type validation (motor, mobil, lainnya)
- ✅ Plat nomor requirement

#### TransaksiModelTest.php
Menguji model Transaksi - transaksi parkir kendaraan:
- ✅ Transaksi creation dengan semua field
- ✅ Relationships (Kendaraan, Tarif, User, AreaParkir)
- ✅ Status tracking (masuk/keluar)
- ✅ DateTime casting untuk waktu
- ✅ Biaya total calculation
- ✅ Durasi jam tracking

#### TarifAndAreaParkirModelTest.php
Menguji model Tarif dan AreaParkir:
- ✅ Tarif creation untuk berbagai tipe kendaraan
- ✅ Tarif per jam dengan decimal casting
- ✅ Area Parkir dengan kapasitas dan terisi management
- ✅ Area Parkir relationships

#### LogAktivitasModelTest.php
Menguji model LogAktivitas - audit trail:
- ✅ Log creation dan assignment ke user
- ✅ Multiple activities tracking per user
- ✅ DateTime logging untuk waktu aktivitas

### 2. Feature Tests (Authentication & Authorization)
Lokasi: `tests/Feature/`

#### AuthenticationTest.php
Menguji sistem login dan logout:
- ✅ Login dengan valid credentials
- ✅ Prevent login dengan invalid password
- ✅ Prevent login untuk inactive user
- ✅ Role-based redirection (admin/petugas/owner)
- ✅ Activity logging pada login/logout
- ✅ Session invalidation pada logout
- ✅ Mandatory field validation (username, password)

#### AuthorizationTest.php
Menguji role-based access control:
- ✅ Admin dapat akses admin routes
- ✅ Petugas tidak dapat akses admin routes (403)
- ✅ Owner tidak dapat akses admin routes (403)
- ✅ Unauthenticated redirect ke login (302)
- ✅ Correct role-based dashboard redirects

#### AdminControllerTest.php
Menguji CRUD operations untuk admin:
- ✅ User CRUD (Create, Read, Update, Deactivate)
- ✅ Tarif CRUD (Create, Update, Delete)
- ✅ Area Parkir CRUD (Create, Update, Delete)
- ✅ Kendaraan CRUD (Create, Update, Delete)
- ✅ Route accessibility checks

#### ValidationTest.php
Menguji input validation:
- ✅ User validation (nama, username, password, role)
- ✅ Unique username validation
- ✅ Password min length (6 chars)
- ✅ Tarif validation (jenis kendaraan, tarif_per_jam)
- ✅ Area Parkir validation (nama_area, kapasitas)
- ✅ Kendaraan validation (plat_nomor, jenis_kendaraan, warna, pemilik)
- ✅ Required field validations
- ✅ Max length validations

#### BusinessLogicTest.php
Menguji business logic operasional:
- ✅ Vehicle entry transaction recording
- ✅ Vehicle exit transaction recording
- ✅ Biaya total calculation untuk 1 jam
- ✅ Biaya total calculation untuk multiple hours
- ✅ Different vehicle types have different rates
- ✅ Area capacity management
- ✅ Area terisi increment/decrement
- ✅ Multiple transactions per vehicle
- ✅ Multiple vehicles parking simultaneously
- ✅ Duration affecting fee calculation

## Running Tests

### Run All Tests
```bash
php artisan test --compact
```

### Run Specific Test File
```bash
php artisan test --compact tests/Feature/AuthenticationTest.php
```

### Run Specific Test Method
```bash
php artisan test --compact --filter=test_login_with_valid_credentials
```

### Run Tests with Coverage
```bash
php artisan test --coverage
```

### Run Unit Tests Only
```bash
php artisan test tests/Unit --compact
```

### Run Feature Tests Only
```bash
php artisan test tests/Feature --compact
```

## Test Coverage

| Category | Count | Status |
|----------|-------|--------|
| Model Unit Tests | 41 | ✅ Pass |
| Authentication Tests | 14 | ✅ Pass |
| Authorization Tests | 19 | ✅ Pass |
| Admin CRUD Tests | 28 | ✅ Pass |
| Validation Tests | 20 | ✅ Pass |
| Business Logic Tests | 13 | ✅ Pass |
| **Total** | **135** | **✅ 100%** |

## Key Features Tested

### Authentication & Security
- ✅ Login/Logout functionality
- ✅ Password hashing and validation
- ✅ Active user status check
- ✅ Session management
- ✅ Role-based access control

### Role-Based Access
- ✅ Admin dashboard access
- ✅ User management (CRUD)
- ✅ Tarif management (CRUD)
- ✅ Area Parkir management (CRUD)
- ✅ Kendaraan management (CRUD)

### Data Integrity
- ✅ Model relationships
- ✅ Foreign key constraints
- ✅ Unique constraints (username, plat_nomor)
- ✅ Type casting (password, datetime, boolean, decimal)

### Business Logic
- ✅ Parking transaction tracking
- ✅ Fee calculation based on duration
- ✅ Area capacity management
- ✅ Activity logging for audit trail
- ✅ Multiple transactions per vehicle

### Validation
- ✅ Required field validation
- ✅ Max length validation
- ✅ Type validation
- ✅ Enum/Option validation
- ✅ Unique value validation
- ✅ Min value validation

## Best Practices Implemented

1. **RefreshDatabase Trait**: Setiap test berjalan dengan database kosok, memastikan test isolation
2. **Descriptive Names**: Setiap test name jelas menggambarkan apa yang ditest
3. **Arrange-Act-Assert**: Struktur test yang konsisten
4. **Factory Usage**: Penggunaan factories untuk membuat test data
5. **Relationship Testing**: Memverifikasi relationships antar model
6. **Error Case Testing**: Testing untuk invalid inputs dan error conditions
7. **Role-Based Testing**: Comprehensive authorization testing untuk setiap role

## Test Maintenance

Untuk menambah test baru:

```bash
# Create new test file
php artisan make:test [TestName] --pest

# Run tests
php artisan test --compact
```

## Notes

- Semua test menggunakan Pest 4.4.6 PHP testing framework
- Database: SQLite (in-memory) untuk testing
- Laravel 13.4.0 compatibility
- PHP 8.4 support dengan strict typing dan attributes

---

**Status**: ✅ Production Ready | **Last Updated**: April 10, 2026
