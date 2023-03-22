<?php

namespace LaravelGravatar;

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
        return new Image($this->config, $email, $presetName);
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
}
