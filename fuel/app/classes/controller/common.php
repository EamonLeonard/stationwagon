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

    public function action_404()
    {
        $this->template->title = 'Not Found';
        $this->template->content = View::factory('404');
    }
}