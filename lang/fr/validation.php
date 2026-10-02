<?php

return [
    'required' => 'Le champ :attribute est obligatoire.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'password' => [
        'letters' => 'Le mot de passe doit contenir au moins une lettre.',
        'mixed' => 'Le mot de passe doit contenir au moins une lettre majuscule.',
        'numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
        'symbols' => 'Le mot de passe doit contenir au moins un symbole (ex: @, #, !).',
        'uncompromised' => 'Le mot de passe choisi a été compromis dans une fuite de données.',
    ],
    'attributes' => [
        'password' => 'mot de passe',
        'email' => 'adresse e-mail',
        'name' => 'nom',
    ],
];