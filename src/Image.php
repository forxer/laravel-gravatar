<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Exception;
use Gravatar\Enum\DefaultImage;
use Gravatar\Enum\Extension;
use Gravatar\Enum\Rating;
use Gravatar\Image as GravatarImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Laravel-specific Gravatar image class.
 *
 * Extends the base Gravatar image class from forxer/gravatar package
 * to provide Laravel-specific functionality including:
 * - Configuration presets
 * - Base64 conversion with Laravel's HTTP client
 * - Integration with Laravel's logging system
 *
 * @see https://docs.gravatar.com/api/avatars/
 */
class Image extends GravatarImage
{
    /**
     * Allowed preset configuration keys.
     *
     * @var array<int, string>
     */
    private const array ALLOWED_PRESET_KEYS = [
        'size',
        'default_image',
        'max_rating',
        'extension',
        'force_default',
        'initials',
        'initials_name',
    ];

    public private(set) ?string $presetName = null;

    /**
     * Create a new Gravatar Image instance.
     *
     * @param  array<string, mixed>  $config  Configuration array from Laravel config
     * @param  string|null  $email  The email address to generate the Gravatar for
     * @param  string|null  $presetName  Optional preset name to apply
     */
    public function __construct(
        public readonly array $config,
        ?string $email = null,
        ?string $presetName = null,
    ) {
        parent::__construct($email);

        if ($presetName !== null) {
            $this->setPreset($presetName);
        }
    }

    /**
     * Build the avatar URL based on the provided settings.
     *
     * Applies preset configuration before building the URL.
     *
     * @return string The complete Gravatar image URL
     */
    public function url(): string
    {
        $this->applyPreset();

        return parent::url();
    }

    /**
     * Convert the Gravatar image to base64 encoded string.
     *
     * @param  int  $timeout  HTTP request timeout in seconds
     * @return string|null Base64 encoded image data URL or null on failure
     */
    public function toBase64(int $timeout = 5): ?string
    {
        try {
            // Apply preset before building URL
            $this->applyPreset();

            // Get the Gravatar URL
            $url = parent::url();

            // Download the image
            $response = Http::timeout($timeout)->get($url);

            if (! $response->successful()) {
                Log::warning('Gravatar request unsuccessful', [
                    'email' => $this->email,
                    'url' => $url,
                    'status' => $response->status(),
                ]);

                return null;
            }

            $imageData = $response->body();

            // Gravatar always returns PNG images
            return 'data:image/png;base64,'.base64_encode($imageData);
        } catch (Exception $exception) {
            Log::warning('Failed to convert Gravatar to base64', [
                'email' => $this->email,
                'url' => $url ?? null,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get or set the preset name to be used.
     *
     * When called with a preset name, applies that preset and returns the instance for chaining.
     * When called without arguments, returns the current preset name or null if none is set.
     *
     * @param  string|null  $presetName  The name of the preset to apply
     * @return ($presetName is null ? string|null : static)
     */
    public function preset(?string $presetName = null): static|string|null
    {
        if ($presetName === null) {
            return $this->getPreset();
        }

        return $this->setPreset($presetName);
    }

    /**
     * Get the preset name to be used.
     */
    public function getPreset(): ?string
    {
        return $this->presetName;
    }

    /**
     * Set the preset name to be used.
     *
     * @param  string|null  $presetName  The name of the preset to apply, or null to clear
     * @return static Returns the instance for method chaining
     */
    public function setPreset(?string $presetName): static
    {
        $this->presetName = $presetName;

        return $this;
    }

    /**
     * Apply preset configuration to Gravatar image.
     *
     * @return static Returns the instance for method chaining
     *
     * @throws InvalidArgumentException When preset keys are invalid or preset is not found
     */
    private function applyPreset(): static
    {
        if ($this->presetName === null) {
            return $this;
        }

        $presetValues = $this->presetValues();

        if ($presetValues === []) {
            return $this;
        }

        foreach ($presetValues as $k => $v) {
            if (! \in_array($k, self::ALLOWED_PRESET_KEYS)) {
                throw new InvalidArgumentException(
                    \sprintf('Gravatar image could not find method to use "%s" key', $k).
                    \sprintf('Allowed preset keys are: "%s".', implode('", "', self::ALLOWED_PRESET_KEYS))
                );
            }

            // Validate enum values before applying
            $this->validatePresetValue($k, $v);

            if (\strlen((string) $k) === 1) {
                $this->{$k}($v);
            } else {
                $this->{Str::camel($k)}($v);
            }
        }

        return $this;
    }

    /**
     * Validate preset value using enums for type safety.
     *
     * @param  string  $key  The preset key
     * @param  mixed  $value  The value to validate
     *
     * @throws InvalidArgumentException When value is invalid for the given key
     */
    private function validatePresetValue(string $key, mixed $value): void
    {
        // Skip validation for null values and non-string values
        if ($value === null || ! \is_string($value)) {
            return;
        }

        $error = match ($key) {
            'extension' => \in_array($value, Extension::values())
                ? null
                : \sprintf('Invalid extension "%s". Valid values: %s', $value, implode(', ', Extension::values())),
            'max_rating' => \in_array($value, Rating::values())
                ? null
                : \sprintf('Invalid rating "%s". Valid values: %s', $value, implode(', ', Rating::values())),
            'default_image' => ! \in_array($value, DefaultImage::values()) && ! filter_var($value, FILTER_VALIDATE_URL)
                ? \sprintf('Invalid default image "%s". Valid values: %s or a valid URL', $value, implode(', ', DefaultImage::values()))
                : null,
            default => null,
        };

        if ($error !== null) {
            throw new InvalidArgumentException($error);
        }
    }

    /**
     * Return preset values to use from configuration file.
     *
     * @return array<string, mixed> Associative array of preset configuration values
     *
     * @throws InvalidArgumentException When preset configuration is missing or invalid
     */
    private function presetValues(): array
    {
        // Resolve preset name from default config if not set
        if ($this->presetName === null) {
            if (empty($this->config['default_preset'])) {
                return [];
            }

            $this->presetName = $this->config['default_preset'];
        }

        // Validate presets configuration exists
        if (empty($this->config['presets']) || ! \is_array($this->config['presets'])) {
            throw new InvalidArgumentException('Unable to retrieve Gravatar presets array configuration.');
        }

        // Validate preset exists
        if (! isset($this->config['presets'][$this->presetName])) {
            throw new InvalidArgumentException(
                \sprintf('Unable to retrieve Gravatar preset values, "%s" is probably a wrong preset name.', $this->presetName)
            );
        }

        $presetValues = $this->config['presets'][$this->presetName];

        // Validate preset values
        if (empty($presetValues) || ! \is_array($presetValues)) {
            throw new InvalidArgumentException(
                \sprintf('Unable to retrieve Gravatar "%s" preset values.', $this->presetName)
            );
        }

        return $presetValues;
    }
}
