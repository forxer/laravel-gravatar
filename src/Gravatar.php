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

    public static function create()
    {
        return app()->make('gravatar');
    }

    /**
     * Return the Gravatar image based on the provided email address.
     *
     * @param string|null $sEmail The email to get the gravatar for.
     * @param string $presetName The preset name to apply.
     * @return Image
     */
    public function image(?string $email = null, ?string $presetName = null): Image
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
     * @param null|string $presetName
     * @return Image
     * @throws InvalidArgumentException
     */
    private function applyPreset(Image $image, ?string $presetName = null): Image
    {
        if ($presetName === null) {
            return $image;
        }

        $presetValues = $this->presetValues($presetName);

        if (empty($presetValues)) {
            return $image;
        }

        foreach ($presetValues as $k => $v) {
            if (! in_array($k, $this->allowedSetterPresetKeys())) {
                throw new InvalidArgumentException(
                    "Gravatar image could not find method to use \"$k\" key".
                    "Allowed preset keys are: ".implode(',', $this->allowedSetterPresetKeys()).'.'
                );
            }

            if (strlen($k) === 1) {
                $image->{$k}($v);
            } else {
                $image->{Str::camel($k)}($v);
            }
        }

        return $image;
    }

    /**
     * Return preset values to use from configuration file.
     *
     * @param string $presetName
     * @return array
     * @throws InvalidArgumentException
     */
    private function presetValues(?string $presetName = null): array
    {
        if ($presetName === null) {
            if (empty($this->config['default_preset'])) {
                return [];
            }

            $presetName = $this->config['default_preset'];
        }

        if (empty($this->config['presets']) || ! is_array($this->config['presets'])) {
            throw new InvalidArgumentException('Unable to retrieve Gravatar presets array configuration.');
        } elseif (! isset($this->config['presets'][$presetName])) {
            throw new InvalidArgumentException("Unable to retrieve Gravatar preset values, \"{$presetName}\" is probably a wrong preset name.");
        }

        $presetValues = $this->config['presets'][$presetName];

        if (empty($presetValues) || ! is_array($presetValues)) {
            throw new InvalidArgumentException("Unable to retrieve Gravatar \"{$presetName}\" preset values.");
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
