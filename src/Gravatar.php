<?php

namespace forxer\LaravelGravatar;

use Illuminate\Contracts\Foundation\Application;
use forxer\Gravatar\Image;
use forxer\Gravatar\Profile;

class Gravatar
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    /**
     * Configuration.
     *
     * @var array
     */
    private $config;

    /**
     * Gravatar service constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param array $config
     */
    public function __construct(Application $app, array $config)
    {
        $this->app = $app;

        $this->config = $config;
    }

    /**
     * Return the Gravatar image based on the provided email address.
     *
     * @param string $sEmail The email to get the gravatar for.
     * @param string $presetName The preset name to apply.
     * @return \forxer\Gravatar\Image
     */
    public function image($email, $presetName = null)
    {
        $image = (new Image())
            ->setEmail($email);

        $this->applyPreset($image, $presetName);

        return $image;
    }

    /**
     * Alias for the "image" method.
     *
     * @param string $sEmail The email to get the gravatar for.
     * @param string $presetName The preset name to apply.
     * @return \forxer\Gravatar\Image
     */
    public function avatar($email, $presetName = null)
    {
        return $this->image($email, $presetName);
    }

    /**
     * Return the Gravatar profile URL based on the provided email address.
     *
     * @param string $sEmail The email to get the Gravatar profile for.
     * @param string $sFormat The profile format to use.
     * @return \forxer\Gravatar\Profile
     */
    public function profile($sEmail, $sFormat = null)
    {
        return (new Profile())
            ->setEmail($sEmail)
            ->setFormat($sFormat);
    }

    /**
     * Apply preset to Gravatar image.
     *
     * @param \forxer\Gravatar\Image $image
     * @param string $presetName
     */
    private function applyPreset(Image $image, $presetName = null)
    {
        foreach ($this->getPresetValues($presetName) as $k => $v) {
            switch ($k) {
                case 'size':
                    $image->setSize($v);
                    break;
                case 'default':
                    $image->setDefaultImage($v);
                    break;
                case 'force_default':
                    $image->setForceDefault($v);
                    break;
                case 'max_rating':
                    $image->setMaxRating($v);
                    break;
                case 'extension':
                    $image->setExtension($v);
                    break;
            }
        }
    }

    /**
     * Return preset values to use.
     *
     * @param string $presetName
     * @throws \InvalidArgumentException
     * @return array
     */
    private function getPresetValues($presetName = null)
    {
        if (null === $presetName) {
            if (empty($this->config['default_preset'])) {
                return [];
            }

            $presetName = $this->config['default_preset'];
        }

        if (empty($this->config['presets']) || !is_array($this->config['presets'])) {
            throw new \InvalidArgumentException("Unable to retrieve Gravatar presets array configuration.");
        }
        elseif (!isset($this->config["presets.{$presetName}"])) {
            throw new \InvalidArgumentException("Unable to retrieve Gravatar preset values, \"{$presetName}\" is probably a wrong preset name.");
        }

        $presetValues = $this->config["presets.{$presetName}"];

        if (!is_array($presetValues) || empty($presetValues)) {
            throw new \InvalidArgumentException("Unable to retrieve Gravatar preset values, \"{$presetName}\" is probably a wrong preset name.");
        }

        return $presetValues;
    }
}
