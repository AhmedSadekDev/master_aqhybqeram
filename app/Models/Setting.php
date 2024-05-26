<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = "settings";

    protected $fillable = [
        'key',
        'value',
        'group_by',
    ];

    const FORM_INPUTS = [
        'standard' => [
            'title' => 'Standard Setting',
            'short_desc' => '',
            'icon' => 'bxs-widget',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'Website Name',
                        'name'          => 'website_name',
                        'type'          => 'text',
                        'placeholder'   => 'Enter Website Name',
                    ],
                    [
                        'label'         => 'Email',
                        'name'          => 'email',
                        'type'          => 'email',
                        'placeholder'   => 'Enter Email',
                    ],
                    [
                        'label'         => 'Phone',
                        'name'          => 'phone',
                        'type'          => 'text',
                        'placeholder'   => 'Enter Phone',
                    ],
                    [
                        'label'         => 'Whats App',
                        'name'          => 'whats_app',
                        'type'          => 'text',
                        'placeholder'   => 'Enter Whats App',
                    ],
                    [
                        'label'         => 'Logo',
                        'name'          => 'website_logo',
                        'type'          => 'image',
                        'placeholder'   => 'Enter Logo',
                    ],
                ],
            ],
        ],
        'Social' => [
            'title' => 'Social Setting',
            'short_desc' => '',
            'icon' => 'bxs-widget',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'Facebook URL',
                        'name'          => 'facebook',
                        'type'          => 'url',
                        'placeholder'   => 'Facebook URL',
                    ],
                    [
                        'label'         => 'Twitter URL',
                        'name'          => 'twitter',
                        'type'          => 'url',
                        'placeholder'   => 'Twitter URL',
                    ],
                    [
                        'label'         => 'Instagram URL',
                        'name'          => 'instagram',
                        'type'          => 'url',
                        'placeholder'   => 'Instagram URL',
                    ],
                    // [
                    //     'label'         => 'Snapchat URL',
                    //     'name'          => 'snapchat',
                    //     'type'          => 'url',
                    //     'placeholder'   => 'Snapchat URL',
                    // ],
                ],
            ],
        ],
        'payment_methods' => [
            'title' => 'Payment Methods',
            'short_desc' => '',
            'icon' => 'bxs-widget',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'Mads',
                        'name'          => 'mads',
                        'type'          => 'image',
                        'placeholder'   => 'mads',
                    ],
                    [
                        'label'         => 'Visa',
                        'name'          => 'visa',
                        'type'          => 'image',
                        'placeholder'   => 'Visa',
                    ],
                    [
                        'label'         => 'master',
                        'name'          => 'master',
                        'type'          => 'image',
                        'placeholder'   => 'master',
                    ],
                ],
            ],
        ],
        'server_key' => [
            'title' => 'Fire Base Server Key',
            'short_desc' => '',
            'icon' => 'bxs-widget',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'Fire Base Server Key',
                        'name'          => 'server_key',
                        'type'          => 'text',
                        'placeholder'   => 'Fire Base Server Key',
                    ],
                ],
            ],
        ],
    ];
}
