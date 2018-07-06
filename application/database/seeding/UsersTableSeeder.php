<?php
    
$table  = 'users';
$insert = array(
                array(
                    'name'      => 'John Anderson',
                    'username'  => 'spenguinAdmin',
                    'email'     => 'info@soaringpenguin.com',
                    'pwhash'    => $CI->encryption->encrypt( 'zaft1g4dm1n' ),
                    'nonce'     => md5( time() ),
                    'userTypeId'=> 10,
                    'status'    => 1
                ),
                array(
                    'name'      => 'John Anderson',
                    'username'  => 'janderson',
                    'email'     => 'info@soaringpenguinpress.com',
                    'pwhash'    => $CI->encryption->encrypt( 'zaft1gpr355' ),
                    'nonce'     => md5( time() ),
                    'userTypeId'=> 4,
                    'status'    => 1
                )              
        );
