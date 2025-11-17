<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Exception;
use Gravatar\Image as GravatarImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Image extends GravatarImage
{
    protected ?string $presetName = null;

    public function __construct(
        private array $config,
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
        $url = null;

        try {
            // Apply preset before building URL
            $this->applyPreset();

            // Get the Gravatar URL
            $url = parent::url();

            // Download the image
            $response = Http::timeout($timeout)->get($url);

            if ($response->successful()) {
                $imageData = $response->body();

                // Gravatar always returns PNG images
                return 'data:image/png;base64,'.base64_encode($imageData);
            }

            // Log warning for unsuccessful response
            Log::warning('Gravatar request unsuccessful', [
                'email' => $this->email,
                'url' => $url,
                'status' => $response->status(),
            ]);

            return null;
        } catch (Exception $exception) {
            Log::warning('Failed to convert Gravatar to base64', [
                'email' => $this->email,
                'url' => $url,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get or set the preset name to be used.
     *
     * @return $this|string|null
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
     * @return $this
     */
    public function setPreset(?string $presetName): static
    {
        $this->presetName = $presetName;

        return $this;
    }

    /**
     * Apply preset to Gravatar image.
     *
     * @return $this
     *
     * @throws InvalidArgumentException
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
            if (! \in_array($k, $this->allowedSetterPresetKeys())) {
                throw new InvalidArgumentException(
                    \sprintf('Gravatar image could not find method to use "%s" key', $k).
                    \sprintf('Allowed preset keys are: "%s".', implode('", "', $this->allowedSetterPresetKeys()))
                );
            }

            if (\strlen((string) $k) === 1) {
                $this->{$k}($v);
            } else {
                $this->{Str::camel($k)}($v);
            }
        }

        return $this;
    }

    /**
     * Return preset values to use from configuration file.
     *
     * @throws InvalidArgumentException
     */
    private function presetValues(): array
    {
        if ($this->presetName === null) {
            if (empty($this->config['default_preset'])) {
                return [];
            }

            $this->presetName = $this->config['default_preset'];
        }

        if (empty($this->config['presets']) || ! \is_array($this->config['presets'])) {
            throw new InvalidArgumentException('Unable to retrieve Gravatar presets array configuration.');
        }

        if (! isset($this->config['presets'][$this->presetName])) {
            throw new InvalidArgumentException(\sprintf('Unable to retrieve Gravatar preset values, "%s" is probably a wrong preset name.', $this->presetName));
        }

        $presetValues = $this->config['presets'][$this->presetName];

        if (empty($presetValues) || ! \is_array($presetValues)) {
            throw new InvalidArgumentException(\sprintf('Unable to retrieve Gravatar "%s" preset values.', $this->presetName));
        }

        return $presetValues;
    }

    private function allowedSetterPresetKeys(): array
    {
        return [
            'size',
            'default_image',
            'max_rating',
            'extension',
            'force_default',
        ];
    }
}
