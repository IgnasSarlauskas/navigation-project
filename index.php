<?php
var_dump($_POST);

$form = [
    'attr' => [
        'action' => 'index.php',
        'class' => 'bg-black'
    ],
    'title' => 'Kalėdų norai',
    'fields' => [
        'first_name' => [
            'attr' => [
                'type' => 'text'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter Name',
                    'class' => 'input-text',
                    'id' => 'first-name'
                ]
            ],
            'label' => 'Vardas:',
//            'error' => 'Vardas per trumpas!',
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'validate' => [
                'validate_not_empty'
            ]
        ],
        'last_name' => [
            'attr' => [
                'type' => 'text'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter Surname',
                    'class' => 'input-text',
                    'id' => 'last-name'
                ]
            ],
            'label' => 'Pavardė:',
//            'error' => 'Paliktas tuščias laukas!'
        ],
        'age' => [
            'attr' => [
                'type' => 'text'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Select your age',
                    'class' => 'input-number',
                    'id' => 'age'
                ]
            ],
            'label' => 'Age:',
//            'error' => 'Paliktas tuščias laukas!',
            'validate' => [
                'validate_not_empty',
                'validate_is_number',
                'validate_is_positive',
                'validate_max_100',
            ]
        ],
        'number' => [
            'attr' => [
                'type' => 'number'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter Contact Number',
                    'class' => 'input-number',
                    'id' => 'contact-number'
                ]
            ],
            'label' => 'Kontaktinis numeris:',
//            'error' => 'Paliktas tuščias laukas!',
        ],
        'wish' => [
            'attr' => [
                'type' => 'select',
                'value' => 'tv'
            ],
            'extra' => [
                'attr' => [
                    'class' => 'input-select',
                    'id' => 'wish'
                ]
            ],
            'options' => [
                'car' => 'BMW',
                'tv' => 'Teliko',
                'socks' => 'Kojinių'
            ],
            'label' => 'Kalėdom noriu:',
        ]
    ],
    'buttons' => [
        'submit' => [
            'type' => 'submit',
            'value' => 'Siųsti'
        ],
        'reset' => [
            'type' => 'reset',
            'value' => 'Išvalyti'
        ]
    ],
    'message' => 'Formos Message!'
];

/**
 * Generates HTML attributes
 * @param array $attr
 * @return string
 */
function html_attr($attr) {
    $html_attr_array = [];

    foreach ($attr as $attribute_key => $attribute_value) {
        $html_attr_array[] = strtr('@key="@value"', [
            '@key' => $attribute_key,
            '@value' => $attribute_value
        ]);
    }

    return implode(' ', $html_attr_array);
}

/**
 * Generates safe input array using FILTER_SANITIZE_SPECIAL_CHARS and FILTER_SANITIZE_NUMBER_INT
 * @param array $form array
 * @return array
 */
function get_filtered_input($form) {
    $filter_parameters = [];
    foreach ($form['fields'] as $id => $value) {
        if (isset($value['filter'])) {
            $filter_parameters[$id] = $value['filter'];
        } else {
            $filter_parameters[$id] = FILTER_SANITIZE_SPECIAL_CHARS;
        }
    }
    return filter_input_array(INPUT_POST, $filter_parameters);
}

/**
 * if input field is empty, error occures above the empty input field 
 * @param $field_input, &$field
 * @return null | boolean
 */
function validate_not_empty($field_input, &$field) {
    if ($field_input === '') {
        $field['error'] = 'Paliktas tuscias laukelis';
    } else {
        return true;
    }
}

function validate_is_number($field_input, &$field) {
    if (!is_numeric($field_input) && !empty($field_input) ) {
        $field['error'] = 'Iveskite validu skaiciu';
    } else {
        return true;
    }
}

function validate_is_positive($field_input, &$field) {
    if ($field_input <= 0) {
        $field['error'] = 'Iveskite teigiama skaiciu';
    } else {
        return true;
    }
}

function validate_max_100($field_input, &$field) {
    if ($field_input >= 100) {
        $field['error'] = 'Ivestas per didelis skaicius';
    } else {
        return true;
    }
}

/**
 * function that validates form by checking if input field is empty then error occures above the empty input field 
 * @param $form
 * @return null 
 */
function validate_form(&$form) {
    $filtered_input = get_filtered_input($form);
    // All the iput info stays in the field after submitting
    foreach ($form['fields'] as $field_id => &$field) {
        $field_input = $filtered_input[$field_id];
        $field['attr']['value'] = $field_input;

        // calling function to check if the field is empty
        foreach ($field['validate'] ?? [] as $function_name) {
            $function_name($field_input, $field); // same as => validate_not_empty($field_input, $field);
        }
        unset($field);
    }
}

validate_form($form);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Form Templates</title>
        <link rel="stylesheet" href="includes/styles.css">
    </head>
    <body>
        <!--        atprintina nora arba varda jeigu (if ??) _POST mastyve yra noras arba vardas-->
        <h1><?php print $_POST['first_name'] ?? ''; ?></h1>        
        <h2><?php print $_POST['wish'] ?? ''; ?></h2>
        <?php require 'templates/form.tpl.php'; ?>
    </body>
</html>