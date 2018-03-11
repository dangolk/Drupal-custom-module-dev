<?php


/**
 * @file
 * Wind Farms installation.
 */

/**
 * Implements hook_install().
 */
function windfarms_install(){
    // Set default variables.
    variable_set('windfarms_gmap', 1);
    variable_set('windfarms_default_center_lat', 42.91455);
    variable_set('windfarms_default_center_long', -75.569851);
    variable_set('windfarms_default_gmap_zoom', 8);   
    
    // Get localization for installation as t() may be unavailable.
    $t = get_t();
    
    // Give user feedback.
    drupal_set_message($t('Wind Farms variables created.'));
    
    // Content type definition.
    $content_type = array(
        'type' => 'windfarm',
        'name' => $t('Wind Farm'),
        'description' => $t('A Wind Farm, including location.'),
        'title_label' => $t('Facility Name'),
        'base' => 'node_content',
        'custom' => TRUE,
    );
    
    // Set remaining definitions with defaults.
    $node_type = node_type_set_defaults($content_type);  
    
    
    // Save the content type.
    node_type_save($node_type);
    
    // Add a field for the body.
    node_add_body_field($node_type, $t('Description'));
    
    // Create Fields.
    $fields = array();
        
    $fields['windfarm_latitude'] = array(
        'field_name' => 'windfarm_latitude',
        'type' => 'number_float',
        'settings' => array(
            'max_length' => 20,
        )
    );
    
    $fields['windfarm_longitude'] = array(
        'field_name' => 'windfarm_longitude',
        'type' => 'number_float',
        'settings' => array(
            'max_length' => 20,
        )
    );
    
    $fields['windfarm_turbine_manufacturer'] = array(
        'field_name' => 'windfarm_turbine_manufacturer',
        'type' => 'text',
        'settings' => array(
            'max_length' => 60,
        )
    );
    
    $fields['windfarm_unit_count'] = array(
        'field_name' => 'windfarm_unit_count', 
        'type' => 'number_integer',
        'cardinality' => 1,
        'settings' => array(
            'max_length' => 5,
        )
    );
    
//    foreach ($fields as $field){
//        field_create_field($field);
//    }
    
    // Create Field Instances.
    $instances = array();
    
    $instances['windfarm_unit_count'] = array(
        'field_name' => 'windfarm_unit_count',
        'label' => $t('Number of Units'),
        'description' => $t('Number of individuals units at a given Facility'),
        'widget' => array(
            'type' => 'text_textfield',
        ),
        'required' => TRUE,
        'settings' => array(
            'text_processing' => 0,
        ),
    );
    
    
    $instances['windfarm_latitude'] = array(
        'field_name' => 'windfarm_latitude',
        'label' => $t('Latitude'),
        'description' => $t('Signed degrees format (DD.ddd)'),
        'widget' => array(
            'type' => 'text_textfield',
        ),
        'settings' => array(
            'text_processing' => 0,
        ),
        'display' => array(
            'default' => array(
                'type' => 'hidden',  
            ),            
        ),
    );
    
    $instances['windfarm_longitude'] = array(
        'field_name' => 'windfarm_longitude',
        'label' => $t('Longitude'),
        'description' => $t('Signed degrees format (DD.ddd)'),
        'widget' => array(
            'type' => 'text_textfield',
        ),
        'settings' => array(
            'text_processing' => 0,
        ),
        'display' => array(
            'default' => array(
                'type' => 'hidden',  
            ),            
        ),
    );
    
    $instances['windfarm_turbine_manufacturer'] = array(
        'field_name' => 'windfarm_turbine_manufacturer',
        'label' => $t('Turbine Manufacturer'),
        'description' => $t('The name of the turbine manufacturer'),
        'widget' => array(
            'type' => 'text_textfield',
        ),
        'display' => array(
            'default' => array(
                'label' => 'inline',
            ),            
        ),
    );
    
//    foreach ($instances as $instance){
//        $instance['entity_type'] = 'node';
//        $instance['bundle'] = 'windfarm';
//        field_create_instance($instance);
//    }
    
}

/**
 * Implements hook_uninstall().
 */

function windfarms_uninstall(){
    // Delete variables.
    variable_del('windfarms_gmap');
    variable_del('windfarms_default_center_lat');
    variable_del('windfarms_default_center_long');
    variable_del('windfarms_default_gmap_zoom');
    
    // Inform user of removal.
    $t = get_t();
    drupal_set_message($t('Wind Farms variables removed.')); 
}
