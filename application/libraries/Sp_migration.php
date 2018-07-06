<?php
/**
 *  An extension of the CI3 Migration Class, which is woeful.
 *  This will be considerably more automated,
 *  including creating the migrations table on initialisation
 *  and providing a form for generating the up/down files
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sp_migration
{
	/**
	 * Whether the library is enabled
	 *
	 * @var bool
	 */
	protected $_migration_enabled = FALSE;

	/**
	 * Path to migration classes
	 *
	 * @var string
	 */
	protected $_migration_path = NULL;

	/**
	 * Current migration version
	 *
	 * @var mixed
	 */
	protected $_migration_version = 0;

	/**
	 * Database table with migration info
	 *
	 * @var string
	 */
	protected $_migration_table = 'migrations';

	/**
	 * Whether to automatically run migrations
	 *
	 * @var	bool
	 */
	protected $_migration_auto_latest = FALSE;

	/**
	 * Migration basename regex
	 *
	 * @var bool
	 */
	protected $_migration_regex = NULL;

	/**
	 * Error message
	 *
	 * @var string
	 */
	protected $_error_string = '';

	/**
	 * Initialize Migration Class
	 *
	 * @param	array	$config
	 * @return	void
	 */    
    
    
    function __construct( $config = array() )
    {
		log_message('debug', 'Migrations class initialized');
        
        $this->config->load( 'migration' );
        
        $this->_migration_path  = $this->config->item( 'migration_path' );
        $this->_migration_enabled   = $this->config->item( 'migration_enabled' );
        $this->_migration_table = $this->config->item( 'migration_table' );
       

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE)
		{
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path !== '' OR $this->_migration_path = APPPATH.'migrations/';

		// Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, '/').'/';

		// Load migration language
		$this->lang->load('migration');

		// They'll probably be using dbforge
		$this->load->dbforge();
        
		// Make sure the migration table name was set.
		if (empty($this->_migration_table))
		{
			show_error('Migrations configuration file (migration.php) must have "migration_table" set.');
		}

		// Migration basename regex
/*		$this->_migration_regex = ($this->_migration_type === 'timestamp')
			? '/^\d{14}_(\w+)$/'
			: '/^\d{3}_(\w+)$/';*/
            
		// If the migrations table is missing, make it
		if ( ! $this->db->table_exists($this->_migration_table))
		{
            $this->dbforge->add_field( array(
                    'migration'  => array(
                        'type'  => 'VARCHAR',
                        'constraint'    => 200
                    ),
                    'batch'     => array(
                        'type'  => 'INT',
                        'unsigned'  => TRUE
                    ),
                    'version'   => array(       // Put here to keep Core Migration from complaining
                        'type' => 'BIGINT',
                        'constraint' => 20
                    )
            ));

			$this->dbforge->create_table($this->_migration_table, TRUE);
		}            
    }
    
    /**
     *  Run the migrations
     */
    public function migrate()
    {
        $migrations = $this->find_migrations();
        $method     = 'up';
        $batch      = $this->_get_last_batch() + 1;
        
        foreach( $migrations as $file )
        {
            include_once( $file );
            $name   = basename( $file, '.php' );
			$class  = 'Migration_'.ucfirst( strtolower( $this->_get_migration_name( $name ) ) );
            $instance = new $class();
            if ( ! is_callable(array($instance, $method)))
            {
                $this->_error_string = sprintf($this->lang->line('migration_missing_'.$method.'_method'), $class);
                return FALSE;
            }

            log_message( 'debug', 'Migrating '.$method.' up.' );
            call_user_func( array( $instance, $method ) );
            $this->_write_migration( $name, $batch );
        }
    }
    
    /**
     *  Rollback the last batch of migrations
     */
    public function rollback()
    {
        $batchNo    = $this->_get_last_batch();
        $migrations = $this->_get_current_migrations( $batchNo );
        $method     = 'down';
        foreach( $migrations as $file )
        {
            include_once( $this->_migration_path . $file . '.php' );
    //        $name   = basename( $file, '.php' );
			$class  = 'Migration_'.ucfirst( strtolower( $this->_get_migration_name( $file ) ) );
            $instance = new $class();
            if ( ! is_callable(array($instance, $method)))
            {
                $this->_error_string = sprintf($this->lang->line('migration_missing_'.$method.'_method'), $class);
                return FALSE;
            }

            log_message( 'debug', 'Migrating '.$method.' down.' );
            call_user_func( array( $instance, $method ) );
            $this->_delete_migration( $file );
        }        
    }
    
    public function create( $filename, $filestr )
    {
        $prepend    = date( 'Ymd' ) . '_';
        $fopen      = fopen( $this->_migration_path . $prepend . $filename . '.php', 'w' );
        fwrite( $fopen, $filestr );
        fclose( $fopen );
        
    }
	// --------------------------------------------------------------------

	/**
	 * Retrieves list of available migration scripts
	 *
	 * @return	array	list of migration file paths sorted by version
	 */
	public function find_migrations()
	{
		$migrations = array();
        
        $current_migrations = $this->_get_current_migrations();
        
		// Load all *.php files in the migrations path
		foreach (glob( $this->_migration_path . '*.php' ) as $file )
		{   
			$name = basename($file, '.php');
            if( in_array( $name, $current_migrations ) ) continue;
            $migrations[] = $file;
			// Filter out non-migration files
/*			if (preg_match($this->_migration_regex, $name))
			{
				$migrations[] = $file;
			}*/
		}

		return $migrations;
	}    
    
    /**
     *  Get the highest batch number from the table
     */
    protected function _get_last_batch()
    {
		$row = $this->db->select_max('batch')->get($this->_migration_table)->row();
		return $row ? $row->batch : '0';        
    }
    
    /**
     *  Get an array of the current migrations
     */
    protected function _get_current_migrations( $batchNo = NULL )
    {
        $this->db->select( 'migration' );
        if( !is_null( $batchNo ) ) $this->db->where( 'batch', $batchNo );
        $query  = $this->db->get( $this->_migration_table );
        $o      = array();
        foreach( $query->result_array() as $_row )
        {   
            $o[]    = $_row['migration'];
        }
        return $o;
    }
    
	/**
	 * Extracts the migration class name from a filename
	 *
	 * @param	string	$migration
	 * @return	string	text portion of a migration filename
	 */
	protected function _get_migration_name($migration)
	{
		$parts = explode('_', $migration);
		array_shift($parts);
		return implode('_', $parts);
	}
    
    /**
     *  Add migration file name to db
     */
    protected function _write_migration( $name, $batch )
    {
        $insert = array(
            'migration' => $name,
            'batch'     => $batch
        );
        $this->db->insert( $this->_migration_table, $insert );
    }
    
    /**
     *  Delete migration file name from db
     */
    protected function _delete_migration( $name )
    {
        $this->db->like( 'migration', $name, 'after' );
        $this->db->delete( $this->_migration_table );
    }
    
	// --------------------------------------------------------------------

	/**
	 * Enable the use of CI super-global
	 *
	 * @param	string	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}    
    

}
