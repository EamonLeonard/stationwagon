<?php

class Controller_Common extends Controller_Template {

    public function before()
    {
        parent::before();

        $this->template->login_error = null;
        
        if (\Auth::check())
        {
            $user = Auth::instance()->get_user_id();

            $this->user_id = $user[1];

            $this->template->logged_in = true;
        }
        else
        {
            $this->template->logged_in = false;
        }
        
        $this->template->css = null;
        
        $uri_string = explode('/', Uri::string());
        
        if ( $uri_string[0] == 'articles' || $uri_string[0] == 'categories' )
        {
            if ( ! \Auth::check() )
            {
                \Output::redirect('/users/login');    
            }
        }
    }

    public function authenticate(Array $methods)
    {
        // Public Methods
        $public = $methods['public'];

        // Get current method
        $method = Uri::segment(2);
        isset($method) ? $method = Uri::segment(2) : $method = 'index';

        // Authenticate
        foreach ( array_keys($methods) as $key )
        {
            // Only these methods
            if ( $key == 'only' )
            {
                $methods = $methods['only'];

                if ( !Auth::check() && in_array($method, $methods) && !in_array($method, $public) )
                {
                    Output::redirect('/');
                }

                if ( Auth::check() && !in_array($method, $methods) && !in_array($method, $public) )
                {
                    Output::redirect('/');
                }
            }

            // All, except these methods
            elseif ( $key == 'except' )
            {
                $methods = $methods['except'];

                if ( !Auth::check() && !in_array($method, $methods) && !in_array($method, $public) )
                {
                    Output::redirect('/');
                }

                if ( Auth::check() && in_array($method, $methods) && !in_array($method, $public) )
                {
                    Output::redirect('/');
                }
            }
        }
    }

    public function action_404()
	{
		$messages = array('Aw, crap!', 'Bloody Hell!', 'Uh Oh!', 'Nope, not here.', 'Huh?');
		$data['title'] = $messages[array_rand($messages)];

		// Set a HTTP 404 output header
		Output::$status = 404;
		$this->render('welcome/404', $data);
	}
}