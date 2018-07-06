<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('dropdown'))
{
/**
 *   A little function to turn an associative array into a dropdown array.
 *   Should probably be in the Helpers folder
 */
     function dropdown( $array, $key, $value )
     {
          $o   = array();
          foreach( $array as $a )
          {
               $o[ $a[$key] ] = $a[$value];
          }
          return $o;
     }
}
if ( ! function_exists('randomAlphaNum'))
{
     function randomAlphaNum($length)
     {
     
          $random= "";
          srand((double)microtime()*1000000);
          $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
          $char_list .= "abcdefghijklmnopqrstuvwxyz";
          $char_list .= "1234567890";
          // Add the special characters to $char_list if needed
        
          for($i = 0; $i < $length; $i++)  
          {    
             $random .= substr($char_list,(rand()%(strlen($char_list))), 1);  
          }  
          return $random;
     
     }
if( ! function_exists( 'create_array' ))
{
     function create_array( $array, $key, $value )
     {
          $o   = array();
          foreach( $array as $row )
          {
               $o[$row[$key]] = $row[$value];
          }
          return $o;
     }
}
if( ! function_exists( 'nest_array' ))
{
     function nest_array( $data )
     {
          foreach( $data as $d )
          {
               $thisref  = &$refs[ $d['id'] ];
               
               $thisref['parent_id']    = $d['parent_id'];
               $thisref['name']         = $d['name'];
               if( $d['parent_id'] == 0 )
               {
//                         if( in_array( $c['id'], $parents) ||  array_key_exists( $c['id'], $cat_count ) ) $list[ $c['id'] ]   = &$thisref;
                    $list[ $d['id'] ]   = &$thisref;
               }
               else
               {
//                         if( array_key_exists( $c['id'], $cat_count ) ) $refs[ $c['parent_id'] ]['children'][ $c['id'] ]  = &$thisref;
                    $refs[ $d['parent_id'] ]['children'][ $d['id'] ]  = &$thisref;
               }
          }
          return $list;
     }
}
if( ! function_exists( 'file_info' ) )
{
     function file_info( $filename )
     {
          $stat     = stat( $filename );
          $o   =array(
               'size'    => $stat[7],
               'time'    => $stat[9]
          );
          return $o;
     }
}
}

?>