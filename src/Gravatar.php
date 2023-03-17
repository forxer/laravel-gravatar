<?php

namespace LaravelGravatar;

use Gravatar\Image;
use Gravatar\Profile;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Gravatar
{
    /**
     * Configuration.
     *
     * @var array
     */
    private $config;

    /**
     * Gravatar service constructor.
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Return the Gravatar image based on the provided email address.
     *
     * @param string $sEmail The email to get the gravatar for.
     * @param string $presetName The preset name to apply.
     * @return Image
     */
    public function image($email, $presetName = null): Image
    {
        $image = new Image($email);

        $image = $this->applyPreset($image, $presetName);

        return $image;
    }

    /**
     * Alias for the "image" method.
     *
     * @param string|null $email The email to get the gravatar for.
     * @param string|null $presetName The preset name to apply.
     * @return Image
     */
    public function avatar(?string $email = null, ?string $presetName = null): Image
    {
        return $this->image($email, $presetName);
    }

    /**
     * Return the Gravatar profile URL based on the provided email address.
     *
     * @param string|null $email The email to get the Gravatar profile for.
     * @param string|null $format The profile format to use.
     * @return Profile
     */
    public function profile(?string $email = null, ?string $format = null): Profile
    {
        return (new Profile($email))
            ->setFormat($format);
    }

    /**
     * Apply preset to Gravatar image.
     *
     * @param Image $image
     * @param null|array $presetName
     * @return Image
     * @throws InvalidArgumentException
     */
    private function applyPreset(Image $image, ?array $presetName = null): Image
    {
        foreach ($this->getPresetValues($presetName) as $k => $v) {
            $setter = 'set'.ucfirst(Str::camel($k));

            if (! method_exists($image, $setter)) {
                throw new InvalidArgumentException("Gravatar image [{$setter}] method does not exists.");
            }

            $image->{$setter}($v);
        }

        return $image;
    }

    /**
     * Return preset values to use.
     *
     * @param string $presetName
     * @return array
     * @throws InvalidArgumentException
     */
    private function getPresetValues(?string $presetName = null): array
    {
        if ($presetName === null) {
            if (empty($this->config['default_preset'])) {
                return [];
            }

            $presetName = $this->config['default_preset'];
        }

        if (empty($this->config['presets']) || ! is_array($this->config['presets'])) {
            throw new InvalidArgumentException("Unable to retrieve Gravatar presets array configuration.");
        }
        elseif (! isset($this->config['presets'][$presetName])) {
            throw new InvalidArgumentException("Unable to retrieve Gravatar preset values, \"{$presetName}\" is probably a wrong preset name.");
        }

        $presetValues = $this->config['presets'][$presetName];

        if (empty($presetValues) || ! is_array($presetValues)) {
            throw new InvalidArgumentException("Unable to retrieve Gravatar \"{$presetName}\" preset values.");
        }

        return $presetValues;
    }
}
