<?php

/**
 * Universal Property Identifier (UPI) Generator and Validator
 * Open Listing Foundation - UPI Standard v1.0
 * Author: Miguel Ramirez
 * m6232936791@gmail.com
 * Date: 2025-06-23
 */

class UPI
{
    /**
     * Generate a UPI based on the provided components.
     * 
     * @param string $countryCode ISO 3166-1 Alpha-2 country code (2 characters)
     * @param string $jurisdictionCode FIPS or standard jurisdiction code (2-5 characters)
     * @param string $parcelCode Parcel or assessor number, up to 20 characters (leading zeros preserved)
     * @return string Generated UPI
     * @throws Exception If any input is invalid
     */
    public static function generate(string $countryCode, string $jurisdictionCode, string $parcelCode): string
    {
        // Basic validation
        self::validateComponents($countryCode, $jurisdictionCode, $parcelCode);

        $countryCode = strtoupper($countryCode);
        $jurisdictionCode = strtoupper($jurisdictionCode);
        $parcelCode = strtoupper($parcelCode);

        // Concatenate for hashing
        $hashInput = $countryCode . $jurisdictionCode . $parcelCode;

        // Generate SHA-256 hash, take first 8 characters
        $hash = strtoupper(substr(hash('sha256', $hashInput), 0, 8));

        // Build UPI
        return "{$countryCode}-{$jurisdictionCode}-{$parcelCode}-{$hash}";
    }

    /**
     * Validate an existing UPI for proper format and checksum.
     * 
     * @param string $upi The UPI string to validate
     * @return bool True if valid, False otherwise
     */
    public static function validate(string $upi): bool
    {
        $pattern = '/^([A-Z]{2})-([A-Z0-9]{2,5})-([A-Z0-9]{1,20})-([A-Z0-9]{8})$/i';

        if (!preg_match($pattern, $upi, $matches)) {
            return false;
        }

        $countryCode = strtoupper($matches[1]);
        $jurisdictionCode = strtoupper($matches[2]);
        $parcelCode = strtoupper($matches[3]);
        $providedHash = strtoupper($matches[4]);

        // Recalculate hash
        $hashInput = $countryCode . $jurisdictionCode . $parcelCode;
        $expectedHash = strtoupper(substr(hash('sha256', $hashInput), 0, 8));

        return $providedHash === $expectedHash;
    }

    /**
     * Extract components from a valid UPI.
     * 
     * @param string $upi
     * @return array|null Associative array with components or null if invalid
     */
    public static function parse(string $upi): ?array
    {
        $pattern = '/^([A-Z]{2})-([A-Z0-9]{2,5})-([A-Z0-9]{1,20})-([A-Z0-9]{8})$/i';

        if (!preg_match($pattern, $upi, $matches)) {
            return null;
        }

        return [
            'countryCode' => strtoupper($matches[1]),
            'jurisdictionCode' => strtoupper($matches[2]),
            'parcelCode' => strtoupper($matches[3]),
            'hash' => strtoupper($matches[4]),
        ];
    }

    /**
     * Internal validation for UPI components.
     */
    private static function validateComponents(string $countryCode, string $jurisdictionCode, string $parcelCode): void
    {
        if (strlen($countryCode) !== 2) {
            throw new Exception("Country code must be exactly 2 characters.");
        }

        if (strlen($jurisdictionCode) < 2 || strlen($jurisdictionCode) > 5) {
            throw new Exception("Jurisdiction code must be between 2 and 5 characters.");
        }

        if (strlen($parcelCode) < 1 || strlen($parcelCode) > 20) {
            throw new Exception("Parcel code must be between 1 and 20 characters.");
        }
    }
}


/*
Sample Usage

try {
    // Generate a UPI
    $upi = UPI::generate("US", "AZ", "50123");
    echo "Generated UPI: $upi\n";

    // Validate the UPI
    if (UPI::validate($upi)) {
        echo "UPI is valid.\n";
    } else {
        echo "UPI is invalid.\n";
    }

    // Parse UPI components
    $components = UPI::parse($upi);
    if ($components) {
        print_r($components);
    } else {
        echo "Failed to parse UPI.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
*/

?>
