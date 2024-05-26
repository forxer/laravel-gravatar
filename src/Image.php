<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Gravatar\Image as GravatarImage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Image extends GravatarImage
{
    /**
     * Preset name in use.
     */
    protected ?string $presetName;

    /**
     * Configuration.
     */
    private array $config;

    /**
     * Construct Image instance
     *
     * @return void
     */
    public function __construct(array $config, ?string $email = null, ?string $presetName = null)
    {
        $this->config = $config;

        if ($email !== null) {
            $this->setEmail($email);
        }

        if ($presetName !== null) {
            $this->setPreset($presetName);
        }
    }

    /**
     * Build the avatar URL based on the provided settings.
     *
     * @return string The URL to the gravatar.
     */
    public function url(): string
    {
        $this->applyPreset();

        return parent::url();
    }

    /**
     * Get or set the preset name to be used.
     *
     * @param  string|null  $email
     */
    public function preset(?string $presetName = null): Image|string|null
    {
        if ($presetName === null) {
            return $this->getPreset();
        }

        return $this->setPreset($presetName);
    }

    /**
     * Get the preset name to be used.
     *
     * @return int The current avatar size in use.
     */
    public function getPreset(): ?string
    {
        return $this->presetName;
    }

    /**
     * Set the preset name to be used.
     */
    public function setPreset(?string $presetName): Image
    {
        $this->presetName = $presetName;

        return $this;
    }

    /**
     * Apply preset to Gravatar image.
     *
     * @throws InvalidArgumentException
     */
    private function applyPreset(): Image
    {
        if ($this->presetName === null) {
            return $this;
        }

        $presetValues = $this->presetValues();

        if (empty($presetValues)) {
            return $this;
        }

        foreach ($presetValues as $k => $v) {
            if (! \in_array($k, $this->allowedSetterPresetKeys())) {
                throw new InvalidArgumentException(
                    "Gravatar image could not find method to use \"$k\" key".
                    'Allowed preset keys are: '.implode(',', $this->allowedSetterPresetKeys()).'.'
                );
            }

            if (\strlen($k) === 1) {
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
        } elseif (! isset($this->config['presets'][$this->presetName])) {
            throw new InvalidArgumentException("Unable to retrieve Gravatar preset values, \"{$this->presetName}\" is probably a wrong preset name.");
        }

        $presetValues = $this->config['presets'][$this->presetName];

        if (empty($presetValues) || ! \is_array($presetValues)) {
            throw new InvalidArgumentException("Unable to retrieve Gravatar \"{$this->presetName}\" preset values.");
        }

        return $presetValues;
    }

    private function allowedSetterPresetKeys()
    {
        return [
            'size', 's',
            'default_image', 'd',
            'max_rating', 'r',
            'extension', 'e',
            'force_default', 'f',
        ];
    }
}
