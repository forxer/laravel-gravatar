<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Gravatar\Image as GravatarImage;
use LaravelGravatar\Concerns\ImageHasPresets;

class Image extends GravatarImage
{
    use ImageHasPresets;

    /**
     * Configuration.
     *
     * @var array
     */
    private $config;

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
}
