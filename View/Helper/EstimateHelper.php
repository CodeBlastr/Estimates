<?php
/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * CakePHP Ratings Plugin
 *
 * Rating helper
 *
 * @package 	ratings
 * @subpackage 	ratings.views.helpers
 */
class EstimateHelper extends AppHelper {

/**
 * helpers variable
 *
 * @var array
 */
	public $helpers = array ('Html', 'Form', 'Js' => 'Jquery');



   public function services($type) {
    
       if ($type == 'LAWN MOWING' || $type == 'LEAF REMOVAL')  {
         return array(
               'Single Service' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    ),
               'Weekly Service' => array(
                                     'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'), 
               'Bi-monthly Service' => array(
                                     'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'),
               'Monthly Service' => array(
                                     'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre')                                                              
                                    );      
       }
       else if ($type == 'CORE AERATE AND OVER SEED' || $type == 'SEED' || $type == 'SOD')  {
         return array(
               'Single' => array('Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    ),
               'Weekly' => array('Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'), 
               'Bi-monthly' => array('Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'),
               'Monthly' => array('Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre')                                                              
                                    );      
       }
       else if ($type == 'CORE AERATION')  {
         return array(
               '--' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    )                                                             
                                    );      
       }
       else if ($type == 'FERTILIZER')  {
         return array(
          'Natural Fertilizer' => array('Town House',
                        '1/4 acre',
                        '1/3 acre',
                        '1/2 acre',
                        '3/4 acre',
                        '1 acre',
                        '2 acre'),
          'Organic Fertilizer' => array('Town House',
                        '1/4 acre',
                        '1/3 acre',
                        '1/2 acre',
                        '3/4 acre',
                        '1 acre',
                        '2 acre'));      
       }
       else if ($type == 'SOIL ENRICHMENT')  {
         return array(
               '--' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    )                                                             
                                    );      
       }
       else if ($type == 'PREVENTATIVE GRUB APPLICATION')  {
         return array(
               '--' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    )                                                             
                                    );      
       }
       else if ($type == 'PH BALANCING')  {
         return array(
               '--' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    )                                                             
                                    );      
       }
       else if ($type == 'WEED')  {
         return array(
               '--' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    )                                                             
                                    );      
       }
       else if ($type == 'TREE & SHRUB')  {
         return array(
               '--' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    )                                                             
                                    );      
       }
       else if ($type == 'FLEA & TICK')  {
         return array(
          'Single' => array('Town House',
                        '1/4 acre',
                        '1/3 acre',
                        '1/2 acre',
                        '3/4 acre',
                        '1 acre',
                        '2 acre'),
          'Monthly' => array('Town House',
                        '1/4 acre',
                        '1/3 acre',
                        '1/2 acre',
                        '3/4 acre',
                        '1 acre',
                        '2 acre'));      
       }
       else if ($type == 'PESTICIDE APPLICATION')  {
         return array(
               '--' => array(
                                    'Town House',
                                    '1/4 acre',
                                    '1/3 acre',
                                    '1/2 acre',
                                    '3/4 acre',
                                    '1 acre',
                                    '2 acre'
                                    )                                                             
                                    );      
       }
    }
}