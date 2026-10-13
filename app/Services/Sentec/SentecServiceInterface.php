<?php

namespace App\Services\Sentec;

use App\Models\Property;

interface SentecServiceInterface
{
    /**
     * Check availability for a specific property via SENTEC.
     *
     * @return array{
     *     available: bool,
     *     property_id: string,
     *     check_in: string,
     *     check_out: string,
     *     nights: int,
     *     rate_per_night: float,
     *     total_rate: float,
     *     currency: string,
     *     is_mock: bool,
     *     message: string
     * }
     */
    public function checkAvailability(string $sentecPropertyId, string $checkIn, string $checkOut, int $guests = 2, int $rooms = 1): array;

    /**
     * Search available properties in SENTEC by date range and guests.
     *
     * @param  array<string, mixed>  $criteria
     * @return array<string, mixed>
     */
    public function searchAvailability(array $criteria): array;

    /**
     * Generate secure redirect URL to SENTEC booking engine.
     *
     * @param  array<string, mixed>  $params
     */
    public function generateBookingUrl(Property $property, array $params = []): string;
}
