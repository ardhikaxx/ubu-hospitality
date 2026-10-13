<?php

namespace App\Services\Sentec;

use App\Models\Property;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentecReservationService implements SentecServiceInterface
{
    protected string $baseUrl;

    protected string $bookingUrl;

    protected ?string $apiKey;

    protected bool $mockMode;

    public function __construct()
    {
        $this->baseUrl = (string) config('services.sentec.base_url', env('SENTEC_BASE_URL', 'https://api.sentec.example.com'));
        $this->bookingUrl = (string) config('services.sentec.booking_url', env('SENTEC_BOOKING_URL', 'https://booking.ubuhospitality.com'));
        $this->apiKey = config('services.sentec.api_key', env('SENTEC_API_KEY'));
        $this->mockMode = (bool) config('services.sentec.mock_mode', env('SENTEC_MOCK_MODE', true));
    }

    /**
     * {@inheritDoc}
     */
    public function checkAvailability(string $sentecPropertyId, string $checkIn, string $checkOut, int $guests = 2, int $rooms = 1): array
    {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        $nights = max(1, $checkInDate->diffInDays($checkOutDate));

        // If in mock mode or credentials are not yet configured
        if ($this->mockMode || empty($this->apiKey)) {
            return $this->mockCheckAvailability($sentecPropertyId, $checkIn, $checkOut, $nights, $guests);
        }

        try {
            $response = Http::timeout(5)
                ->withHeaders([
                    'Authorization' => 'Bearer '.$this->apiKey,
                    'Accept' => 'application/json',
                ])
                ->get("{$this->baseUrl}/v1/properties/{$sentecPropertyId}/availability", [
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'guests' => $guests,
                    'rooms' => $rooms,
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'available' => (bool) ($data['available'] ?? false),
                    'property_id' => $sentecPropertyId,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'nights' => $nights,
                    'rate_per_night' => (float) ($data['rate_per_night'] ?? 0),
                    'total_rate' => (float) ($data['total_rate'] ?? 0),
                    'currency' => (string) ($data['currency'] ?? 'IDR'),
                    'is_mock' => false,
                    'message' => 'Tarif dan ketersediaan real-time terverifikasi dari SENTEC.',
                ];
            }

            Log::warning('SENTEC API returned non-success status', [
                'status' => $response->status(),
                'body' => $response->body(),
                'property_id' => $sentecPropertyId,
            ]);

            return [
                'available' => false,
                'property_id' => $sentecPropertyId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'nights' => $nights,
                'rate_per_night' => 0.0,
                'total_rate' => 0.0,
                'currency' => 'IDR',
                'is_mock' => false,
                'message' => 'Layanan reservasi SENTEC sementara sedang tidak dapat dihubungi. Silakan hubungi CS melalui WhatsApp.',
            ];
        } catch (Exception $e) {
            Log::error('SENTEC API connection error', [
                'error' => $e->getMessage(),
                'property_id' => $sentecPropertyId,
            ]);

            return [
                'available' => false,
                'property_id' => $sentecPropertyId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'nights' => $nights,
                'rate_per_night' => 0.0,
                'total_rate' => 0.0,
                'currency' => 'IDR',
                'is_mock' => false,
                'message' => 'Terjadi gangguan koneksi ke sistem SENTEC. Silakan coba kembali sesaat lagi.',
            ];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function searchAvailability(array $criteria): array
    {
        $checkIn = $criteria['check_in'] ?? Carbon::tomorrow()->toDateString();
        $checkOut = $criteria['check_out'] ?? Carbon::tomorrow()->addDay()->toDateString();
        $guests = (int) ($criteria['guests'] ?? 2);

        if ($this->mockMode || empty($this->apiKey)) {
            return [
                'status' => 'success',
                'is_mock' => true,
                'message' => 'Simulasi ketersediaan aktif (mode integrasi persiapan SENTEC).',
                'criteria' => $criteria,
            ];
        }

        try {
            $response = Http::timeout(6)
                ->withHeaders(['Authorization' => 'Bearer '.$this->apiKey])
                ->get("{$this->baseUrl}/v1/search/availability", $criteria);

            return $response->json();
        } catch (Exception $e) {
            Log::error('SENTEC search availability exception', ['error' => $e->getMessage()]);

            return [
                'status' => 'error',
                'is_mock' => false,
                'message' => 'Gagal mengambil ketersediaan dari SENTEC.',
            ];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function generateBookingUrl(Property $property, array $params = []): string
    {
        if (! empty($property->booking_engine_url)) {
            $base = $property->booking_engine_url;
        } else {
            $base = rtrim($this->bookingUrl, '/').'/property/'.($property->sentec_property_id ?: $property->slug);
        }

        $query = array_filter([
            'property_id' => $property->sentec_property_id,
            'check_in' => $params['check_in'] ?? null,
            'check_out' => $params['check_out'] ?? null,
            'guests' => $params['guests'] ?? null,
            'rooms' => $params['rooms'] ?? null,
            'promo_code' => $params['promo_code'] ?? null,
            'ref' => 'ubuhospitality.com',
        ]);

        return $base.(str_contains($base, '?') ? '&' : '?').http_build_query($query);
    }

    /**
     * Simulated mock availability response for development/testing.
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
    protected function mockCheckAvailability(string $sentecPropertyId, string $checkIn, string $checkOut, int $nights, int $guests): array
    {
        $property = Property::where('sentec_property_id', $sentecPropertyId)->first();
        $baseRate = $property ? (float) $property->starting_price_display : 1850000.0;

        return [
            'available' => true,
            'property_id' => $sentecPropertyId,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $nights,
            'rate_per_night' => $baseRate,
            'total_rate' => $baseRate * $nights,
            'currency' => 'IDR',
            'is_mock' => true,
            'message' => 'Simulasi ketersediaan (Mock Mode): Properti tersedia untuk tanggal yang dipilih.',
        ];
    }
}
