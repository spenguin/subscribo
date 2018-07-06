<?php
$table  = 'tags';
$insert = array(
                array(
                    'name'  => 'Usertypes',
                    'slug'  => 'usertypes',
                    'description'   => 'User Types'
                ),
                array(
                    'name'  => 'Admin',
                    'slug'  => 'admin',
                    'parentId'  => 1,
                    'description'   => 'Administration type'
                ),
                array(
                    'name'  => 'Publisher',
                    'slug'  => 'publisher',
                    'parentId'  => 1,
                    'description'   => 'Publisher type'
                ),
                array(
                    'name'  => 'Subscriber',
                    'slug'  => 'subscriber',
                    'parentId'  => 1,
                    'description'   => 'Subscriber type'
                ),                
                array(
                    'name'  => 'Assettypes',
                    'slug'  => 'assettypes',
                    'parentId'  => 0,
                    'description'   => 'Asset Types'
                ),
                array(
                    'name'  => 'Logo',
                    'slug'  => 'logo',
                    'parentId'  => 5,
                    'description'   => 'Publishing Company Logo'
                ),
                array(
                    'name'  => 'Regions',
                    'slug'  => 'regions',
                    'parentId'  => 0,
                    'description'   => 'Comic shop regions'
                ),
                array(
                    'name'  => 'PostTypes',
                    'slug'  => 'posttypes',
                    'parentId'  => 0,
                    'description'   => 'Post Types'
                ),
                array(
                    'name'  => 'Shops',
                    'slug'  => 'shops',
                    'parentId'  => 8,
                    'description'   => 'Comic shops'
                ),
                array(
                    'name'  => 'SuperAdmin',
                    'slug'  => 'superadmin',
                    'parentId'  => 1,
                    'description'   => 'Highest user level'
                )
            );