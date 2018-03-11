<?php

/**
 * @file
 * Custom functionality for a wind farm database.
 */
 
 /**
 * Implements hook_help().
 */
 function windfarm_help($path, $arg){
    switch ($path) {
        case 'admin/help#windfarms':
            {
                $ret_val = '<h3>' . t('About') . '</h3>';
                $ret_val .= '<p>' . t('The Wind Farms module makes it easy to manage a database of wind farms.') . '</p>';
                return $ret_val; 
                break;
            }
        }
 }

/**
 * Implements hook_permission().
 */
 function windfarms_permission(){
    return array(
        'administer wind farms' => array(
        'title' => t('Administer Wind Farms'),
        'description' => t('Perform Administrative tasks on Wind Farms functionality'),
    )
    );
 }
 
 /**
 * Implements hook_menu().
 */
 function windfarms_menu(){
     $items = array();
    // Admin configuration group.     
     $items['admin/config/windfarms'] = array(
         'title' => 'Wind Farms',
         'description' => 'Administer Wind Farms', 
         'access arguments' => array('administer wind farms'),
     );
     
    // Admin configuration - Settings.
    $items['admin/config/windfarms/manage'] = array(
        'title' => 'Wind Farms Settings',
        'description' => 'Manage Wind Farm settings and configurations.',
        'access arguments' => array('administer wind farms'),
        'page callback' => 'drupal_get_form',
        'page arguments' => array('windfarms_admin_settings_form'),
    );
     
    return $items;
 }

/**
 * Implements hook_form().
 */
 function windfarms_admin_settings_form($node, &$form_state){
     $form = array();
     
     $form['overview'] = array(
         '#markup' => t('This interface allows administrators to manage general Wind Farm Settings'), 
         '#prefix' => '<p>', 
         '#suffix' => '</p>',          
     );
     
     $form['windfarms_gmap'] = array(
         '#title' => t('Enable Google Maps'),
         '#description' => t('When enabled, Google Maps will be rendered if latitude and longitude are known.'),
         '#type' => 'checkbox',
         '#default' => variable_get('windfarms_gmap'),
     );
     
     $form['default_center'] = array(
         '#title' => t('Map center'),
         '#description' => t('Location of the center of the map of wind farms.'),
         '#type' => 'fieldset',
         '#collapsible' => TRUE,
         '#collapsed' => FALSE
     );
     
     $form['default_center']['windfarms_default_center_lat'] = array(
        '#title' => t('Latitude'),
        '#description' => t('Signed degrees fromat (DDD.dddd)'),
        '#type' => 'textfield',
        '#default_value' => variable_get('windfarms_default_center_lat'),
        '#required' => TRUE,
     );
     
     $form['default_center']['windfarms_default_center_long'] = array(
        '#title' => t('Longitude'),
        '#description' => t('Signed degrees fromat (DDD.dddd)'),
        '#type' => 'textfield',
        '#default_value' => variable_get('windfarms_default_center_long'),
        '#required' => TRUE,
     );
         
     $options = range(0, 20, 1);
     $options[0] = t('0 - Furthest');
     $options[20] = t('20 - Furthest');
     
     $form['windfarms_default_gmap_zoom'] = array(
         '#title' => t('Google Map Zoom'),
         '#description' => t('Default level of zoom, between 0 and 20.'),
         '#type' => 'select',
         '#options' => $options,
         '#default_value' => variable_get('windfarms_default_gmap_zoom'),
         '#required' => TRUE,
     );
     
     return system_settings_form($form);
     
//     $form['submit'] = array(
//        '#type' => 'submit',
//        '#value' => t('Save'),
//     );
         
//     return $form;
 }

/**
 * Validate Wind Farm admin settings.
 */
function windfarms_admin_settings_form_validate($form, &$form_state){
//  dpm($form_state['values']);
    
    // Regular expression for validating signed degrees.
    $signed_degree_regex = '/^[+]?\d+(\.\d+)?$/';
    
    // Shorthand for long array names.
    $lat = $form_state['values']['windfarms_default_center_lat'];
    $long = $form_state['values']['windfarms_default_center_long'];
    
    if(!preg_match($signed_degree_regex, $lat)) {
        form_set_error('windfarms_default_center_lat', t('Invalid latitude; must be a signed degree (DD.dddd).'));
    }
    
    if(!preg_match($signed_degree_regex, $long)) {
        form_set_error('windfarms_default_center_long', t('Invalid longitude; must be a signed degree (DD.dddd).'));
    }
    
    // Validate latitude and longitude values.
    if(!((-180 <= $lat) && ($lat <= 180))){
        form_set_error('windfarms_default_center_lat', t('Latitude must be between -180 and +180'));
    }
    
    if(!((-180 <= $long) && ($long <= 180))){
        form_set_error('windfarms_default_center_long', t('Longitude must be between -180 and +180'));
    }
    
}

/**
 * Process a validated Wind Farm admin setting submission.
 */
//function windfarms_admin_settings_form_submit($form, &$form_state){
//    // Rebuild the form
//    $form_state['rebuild'] = TRUE;
//    
//    // Save Wind Farm setting variables.
//    variable_set('windfarms_gmap', $form_state['values']['windfarms_gmap']);
//    variable_set('windfarms_default_center_lat', $form_state['values']['windfarms_default_center_lat']);
//    variable_set('windfarms_default_center_long', $form_state['values']['windfarms_default_center_long']);
//    variable_set('windfarms_default_gmap_zoom', $form_state['values']['windfarms_default_gmap_zoom']);
//    
//    drupal_set_message(t('Wind Farm settings saved.'));
//}
// 