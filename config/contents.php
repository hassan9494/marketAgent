<?php
return [
    'about-us' => [
        'field_name' => [
            'title' => 'text',
            'short_description' => 'textarea',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_description.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '24x24'
        ]
    ],
    'feature' => [
        'field_name' => [
            'title' => 'text',
            'short_description' => 'textarea',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_description.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '28x28'
        ]
    ],
    'service' => [
        'field_name' => [
            'title' => 'text',
            'image' => 'file',
            'short_description' => 'textarea',
            'button_name' => 'text',
            'button_link' => 'url',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            'short_description.*' => 'required|max:2000',
            'button_name.*' => 'required',
            'button_link.*' => 'required',
        ],
        'size' => [
            'image' => '48x48'
        ]
    ],
    'counter' => [
        'field_name' => [
            'title' => 'text',
            'number_of_data' => 'text',
            'image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'number_of_data.*' => 'required|integer',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '50x50'
        ]
    ],
    'testimonial' => [
        'field_name' => [
            'name' => 'text',
            'designation' => 'text',
            'description' => 'textarea',
            'image' => 'file'
        ],
        'validation' => [
            'name.*' => 'required|max:100',
            'designation.*' => 'required|max:2000',
            'description.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '88x88'
        ]
    ],
    'blog' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea',
            'image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'description.*' => 'required|max:20000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '1176x661',
            'thumb' => '696x391'
        ]
    ],

    'faq' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea'
        ],
        'validation' => [
            'title.*' => 'required|max:190',
            'description.*' => 'required|max:10000'
        ]
    ],

    'how-it-work' => [
        'field_name' => [
            'title' => 'text',
            'icon' => 'icon',
            'short_description' => 'textarea',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'icon.*' => 'required|max:100',
            'short_description.*' => 'required|max:5000',
        ],
    ],

    'social' => [
        'field_name' => [
            'name' => 'text',
            'icon' => 'icon',
            'link' => 'url',
        ],
        'validation' => [
            'name.*' => 'required|max:100',
            'icon.*' => 'required|max:100',
            'link.*' => 'required|max:100'
        ],
    ],

    'support' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'description.*' => 'required|max:30000'
        ]
    ],


    'message' => [
        'required' => 'This field is required.',
        'min' => 'This field must be at least :min characters.',
        'max' => 'This field may not be greater than :max characters.',
        'image' => 'This field must be image.',
        'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
    ],

    'content_media' => [
        'image' => 'file',
        'thumbnail' => 'file',
        'youtube_link' => 'url',
        'button_link' => 'url',
        'link' => 'url',
        'icon' => 'icon'
    ]
];
