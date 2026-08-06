<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptionService
{
    /**
     * Encrypt sensitive data using AES-256.
     */
    public function encrypt(string $value): string
    {
        return Crypt::encryptString($value);
    }

    /**
     * Decrypt encrypted data.
     */
    public function decrypt(string $encryptedValue): string
    {
        return Crypt::decryptString($encryptedValue);
    }
}