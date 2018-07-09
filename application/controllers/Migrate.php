<?php

class Migrate extends CI_Controller
{

    protected $_config  = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Sp_migration');
    //    $this->load->library('migration');        
    //    $this->_config  = $this->config->load( 'migration' );
    }

    public function index()
    {
        $this->sp_migration->migrate( $this->_config );
        echo 'Migrations complete';
    }

    /**
     *  Take the migration back one batch run
     */
    public function rollback()
    {
        $batch  = $this->sp_migration->rollback( $this->_config );
        echo 'Migration Batch ' . $batch . ' rolled back';
    }

    /**
     *  Create a new migration file
     */
    public function create()
    {   exit( 'test2' );
        $data   = array();
        if( $this->input->post( 'submit') )
        {
            $this->form_validation->set_rules( 'filename', 'Filename', 'trim|required|alpha_dash');
            if( $this->form_validation->run() === TRUE )
            {   
                exit( $this->input->post( 'filename' ) );
                $filename   = $this->input->post( 'filename' );
                $filestr[]  = '<?php';
                $filestr[]  = '';
                $filestr[]  = 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');';
                $filestr[]  = '';
                $filestr[]  = 'class Migration_Add_users extends CI_Migration {';
                $filestr[]  = '';
                $filestr[]  = "\t" . 'public function up()';
                $filestr[]  = "\t" . '{';
                $filestr[]  = '';
                $filestr[]  = "\t" . '}';
                $filestr[]  = '';
                $filestr[]  = "\t" . 'public function down()';
                $filestr[]  = "\t" . '{';
                $filestr[]  = '';
                $filestr[]  = "\t" . '}';
                $filestr[]  = '}';
                $this->sp_migration->create( $filename, join( PHP_EOL, $filestr ) );
                $data['message']    = "File {$filename} created.";
            }
        }
        
        $this->load->view( 'migration/create', $data );
    }

}