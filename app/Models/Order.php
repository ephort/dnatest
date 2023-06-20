<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoicePath(): string
    {
        return storage_path('invoices/' . $this->id . '.pdf');
    }

    public static function verify(string $phone, string $password): bool
    {
        $order = static::where('phone', $phone)->first();

        if (! $order) {
            return false;
        }

        return \Hash::check($password, $order->password);
    }
}
