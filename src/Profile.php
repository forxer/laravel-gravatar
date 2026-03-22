<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Exception;
use Gravatar\Profile as GravatarProfile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Laravel-specific Gravatar profile class.
 *
 * Extends the base Gravatar profile class from forxer/gravatar package
 * to provide Laravel-specific functionality and integration.
 *
 * Uses the Gravatar REST API v3 which returns JSON only.
 *
 * @see https://docs.gravatar.com/api/profiles/
 */
class Profile extends GravatarProfile
{
    /**
     * Fetch profile data from the Gravatar API v3.
     *
     * @param  int  $timeout  HTTP request timeout in seconds
     * @return array<string, mixed>|null Profile data or null on failure
     */
    public function getData(int $timeout = 5): ?array
    {
        try {
            $url = $this->url();

            $response = Http::timeout($timeout)->get($url);

            if (! $response->successful()) {
                Log::warning('Gravatar profile request unsuccessful', [
                    'email' => $this->email,
                    'url' => $url,
                    'status' => $response->status(),
                ]);

                return null;
            }

            $data = $response->json();

            if (! \is_array($data)) {
                return null;
            }

            return $data;
        } catch (Exception $exception) {
            Log::warning('Failed to fetch Gravatar profile data', [
                'email' => $this->email,
                'url' => $url ?? null,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }
}
