<?php
declare(strict_types=1);

function calculateSubtotal(int $unitPrice, int $quantity): int
{
    return $unitPrice * $quantity;
}

function calculateTax(int $subtotal, float $rate): float
{
    return $subtotal * $rate;
}

function calculateTotal(int $subtotal, float $tax): float
{
    return $subtotal + $tax;
}

$unitPrice = 25;
$quantity = 3;
$subtotal = calculateSubtotal($unitPrice, $quantity);
$taxRate = 0.2;
$tax = calculateTax($subtotal, $taxRate);
$total = calculateTotal($subtotal, $tax);

echo sprintf("Subtotal: %d, tax: %.2f, total: %.2f\n", $subtotal, $tax, $total);
