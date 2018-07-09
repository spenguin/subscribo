<?php

class Themes extends CI_Loader
{
	// --------------------------------------------------------------------

	/**
	 * Theme Loader
	 *
	 * Loads "theme" files.
	 *
	 * @param	string	$view	View name
	 * @param	array	$vars	An associative array of data
	 *				to be extracted for use in the view
	 * @param	bool	$return	Whether to return the view output
	 *				or leave it to the Output class
	 * @return	object|string
	 */
	public function view( $view, $vars = array(), $return = FALSE)
	{

		// If theme has been set
		if( isset( $theme ) )
		{
			$data['main']	= $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $vars, '_ci_return' => TRUE ));
			$data['footer']	= $this->load->view( 'common/footer', array(), TRUE );
			$data['header']	= $this->load->view( 'common/header', array(), TRUE );
			$data['navigation']	= $this->get_navigation();
			$this->load->view( 'template', $data, $return );
		}
		else
		{
			$data['main']	= $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $vars, '_ci_return' => TRUE ));			
			$this->load->view( $view );			
		}

    //    return $this->_ci_load( array( 'ci_view' => 'template', '_ci_vars' => array( 'main' => htmlspecialchars( '<h1>TestM/h1>' ) ), '_ci_return' => $return ) );
	}

	/**
	 *	Navigation generator
	 *
	 *	Navigation can be specific to each Theme, based on where the user is in the site, and what permission they have
	 *
	 *	@return object|string
	 */
	public function get_navigation()
	{
		return $this->load->view( 'navigation/home', array(), TRUE );
	}
}

