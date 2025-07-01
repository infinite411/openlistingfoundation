
# 📦 UPI Class - Universal Property Identifier Generator & Validator

**Author:** Miguel Ramirez
**m6232936791@gmail.com  
**Standard:** Open Listing Foundation - UPI Standard v1.0  
**Date:** June 23, 2025  

---

## 📝 Overview

The **UPI** (Universal Property Identifier) class provides functionality to generate, validate, and parse UPIs in compliance with the Open Listing Foundation's UPI Standard v1.0.

The UPI establishes a globally unique, compact, and persistent identifier for real estate properties, supporting reliable property tracking and data exchange across platforms.

---

## ⚡ Features

✅ Generate standards-compliant UPIs  
✅ Validate UPI format and checksum  
✅ Parse UPI components (Country, Jurisdiction, Parcel, Hash)  
✅ Preserves leading zeros in Parcel Codes  
✅ Case-insensitive handling  
✅ Minimal, easy-to-integrate PHP class  

---

## 📚 UPI Structure

```
<Country Code>-<Jurisdiction Code>-<Parcel Code>-<Hash>
```

**Example:**  
```
US-AZ-50123-4C8D9E2B
```

**Field Definitions:**

| Field             | Description                              | Format                      | Required |
|-------------------|------------------------------------------|-----------------------------|----------|
| Country Code      | ISO 3166-1 Alpha-2 country code         | 2 characters (e.g., `US`)   | Yes      |
| Jurisdiction Code | State/province/county FIPS or abbreviation | 2-5 characters (e.g., `AZ`) | Yes      |
| Parcel Code       | Parcel/Assessor number (leading zeros preserved) | Up to 20 characters | Yes |
| Hash              | 8-character alphanumeric checksum (SHA-256 derived) | 8 characters | Yes |

---

## 💻 Usage

### 1. Generate a UPI

```php
require 'UPI.php';

try {
    $upi = UPI::generate("US", "AZ", "50123");
    echo $upi; // Example: US-AZ-50123-4C8D9E2B
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

---

### 2. Validate a UPI

```php
$upi = "US-AZ-50123-4C8D9E2B";

if (UPI::validate($upi)) {
    echo "UPI is valid.";
} else {
    echo "UPI is invalid.";
}
```

---

### 3. Parse UPI Components

```php
$components = UPI::parse("US-AZ-50123-4C8D9E2B");

if ($components) {
    print_r($components);
} else {
    echo "Invalid UPI.";
}
```

**Output Example:**

```
Array
(
    [countryCode] => US
    [jurisdictionCode] => AZ
    [parcelCode] => 50123
    [hash] => 4C8D9E2B
)
```

---

## 🛡️ Validation Rules

- Country Code: Exactly 2 letters (ISO standard)  
- Jurisdiction Code: 2 to 5 alphanumeric characters  
- Parcel Code: 1 to 20 alphanumeric characters (leading zeros preserved)  
- Hash: 8-character uppercase alphanumeric checksum derived from SHA-256 of the components  

---

## 🔧 Dependencies

- Pure PHP, no external libraries required  
- Compatible with PHP 7.0+  

---

## 🏗️ Future Enhancements (Optional)

- Checksum validation enhancements  
- Support for international jurisdiction extensions  
- Optional human-readable formats  
- Composer package version  

---

## 📝 License & Copyright

```
© 2025 Open Listing Foundation

This software implements the Open Listing Foundation's UPI Standard v1.0. 
Refer to the UPI Specification for legal use and compliance information.

This class is provided "AS IS" without warranties of any kind.
```

---

## 📬 Contact

Miguel Ramirez  
Email: [m6232936791@gmail.com](mailto:m6232936791@gmail.com)  

---

## 🌐 References

- [ISO 3166-1 Country Codes](https://www.iso.org/iso-3166-country-codes.html)  
- [US FIPS Jurisdiction Codes](https://www.census.gov/library/reference/code-lists.html)  
- [Open Listing Foundation - UPI Standard v1.0](#) *(Insert official link once available)*  
