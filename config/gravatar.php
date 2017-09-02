<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Avatar Preset
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default avatar preset (see below)
    | that should be used by Laravel Gravatar.
    |
    | You can disable the default preset by setting it to null.
    |
    */

    'default_preset' => null,
//  'default_preset' => 'gravatar',

    /*
    |--------------------------------------------------------------------------
    | Avatar Presets
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many avatar preset as you wish.
    |
    */

    'presets' => [

        /*
        |--------------------------------------------------------------------------
        | Gravatar Defaults
        |--------------------------------------------------------------------------
        |
        | Here is an example of a preset using Gravatar's default values.
        |
        */

        'gravatar' => [

            /*
            |--------------------------------------------------------------------------
            | Gravatar image size
            |--------------------------------------------------------------------------
            |
            | By default, images are presented at 80px by 80px if no size
            | parameter is supplied. You may request a specific image size,
            | which will be dynamically delivered from Gravatar.
            |
            | You may request images anywhere from 1px up to 2048px,
            | however note that many users have lower resolution images,
            | so requesting larger sizes may result in pixelation/low-quality images.
            |
            | An avatar size should be an integer representing the size in pixels.
            |
            */

            'size' => 80,

            /*
            |--------------------------------------------------------------------------
            | Default Gravatar image
            |--------------------------------------------------------------------------
            |
            | Here you can define the default image to be used when an email address
            | has no matching Gravatar image or when the gravatar specified exceeds
            | your maximum allowed content rating.
            |
            | If you'd prefer to use your own default image, then you can easily do so
            | by supplying the URL to an image. In addition to allowing you to use your
            | own image, Gravatar has a number of built in options which you can also
            | use as defaults. Most of these work by taking the requested email hash
            | and using it to generate a themed image that is unique to that email address.
            |
            | Possible values:
            | - null value to fallback to the default Gravatar
            | - a string represanting the URL of your own default image
            | - '404': do not load any image if none is associated with the email hash, instead return an HTTP 404 (File Not Found) response
            | - 'mm': (mystery-man) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash)
            | - 'identicon': a geometric pattern based on an email hash
            | - 'monsterid': a generated 'monster' with different colors, faces, etc
            | - 'wavatar': generated faces with differing features and backgrounds
            | - 'retro': awesome generated, 8-bit arcade-style pixelated faces
            | - 'blank': a transparent PNG image
            */

            'default_image' => null,

            /*
            |--------------------------------------------------------------------------
            | Force to always use the default image
            |--------------------------------------------------------------------------
            |
            | If for some reason you wanted to force the default image
            | to always be load, put it to true.
            |
            */

            'force_default' => false,

            /*
            |--------------------------------------------------------------------------
            | Gravatar image max rating
            |--------------------------------------------------------------------------
            |
            | Gravatar allows users to self-rate their images so that they can
            | indicate if an image is appropriate for a certain audience.
            | By default, only 'g' rated images are displayed unless you indicate
            | that you would like to see higher ratings.
            |
            | You may specify one of the following ratings to request images up to and including that rating:
            |
            | 'g': suitable for display on all websites with any audience type.
            | 'pg': may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
            | 'r': may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
            | 'x': may contain hardcore sexual imagery or extremely disturbing violence.
            |
            */

            'max_rating' => 'g',

            /*
            |--------------------------------------------------------------------------
            | Gravatar image file-type extension
            |--------------------------------------------------------------------------
            |
            | If you require a file-type extension (some places do) then you may also specify it.
            |
            */

            'extension' => null,
        ],

        /*
        |--------------------------------------------------------------------------
        | Another Preset
        |--------------------------------------------------------------------------
        |
        | Here is another example of a preset.
        |
        */

        'another_preset' => [

            'size' => 120,

            'default_image' => 'mm',

            'force_default' => false,

            'max_rating' => 'r',

            'extension' => 'jpg',

         ],

    ],

];
