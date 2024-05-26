<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Gravatar\Image as GravatarImage;
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
        if ($email !== null) {
            $this->setEmail($email);
        }

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
     * Get or set the preset name to be used.
     */
    public function preset(?string $presetName = null): self|string|null
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
     */
    public function setPreset(?string $presetName): self
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

        if ($presetValues === []) {
            return $this;
        }

        foreach ($presetValues as $k => $v) {
            if (! \in_array($k, $this->allowedSetterPresetKeys())) {
                throw new InvalidArgumentException(
                    sprintf('Gravatar image could not find method to use "%s" key', $k).
                    sprintf('Allowed preset keys are: "%s".', implode('", "', $this->allowedSetterPresetKeys()))
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
        }

        if (! isset($this->config['presets'][$this->presetName])) {
            throw new InvalidArgumentException(sprintf('Unable to retrieve Gravatar preset values, "%s" is probably a wrong preset name.', $this->presetName));
        }

        $presetValues = $this->config['presets'][$this->presetName];

        if (empty($presetValues) || ! \is_array($presetValues)) {
            throw new InvalidArgumentException(sprintf('Unable to retrieve Gravatar "%s" preset values.', $this->presetName));
        }

        return $presetValues;
    }

    private function allowedSetterPresetKeys(): array
    {
        return [
            'size',
            's',

            'default_image',
            'd',

            'max_rating',
            'r',

            'extension',
            'e',

            'force_default',
            'f',
        ];
    }
}
