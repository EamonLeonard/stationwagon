<?php

class Controller_Users extends Controller_Common {

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $this->template->title = 'Welcome';
        $this->template->content = View::factory('users/index');
    }

    public function action_login()
	{
		if ( Auth::check())
        {
            Output::redirect('/');
        }
		
		$val = Validation::factory('users');
        $val->add_field('username', 'Your username', 'required|min_length[3]|max_length[20]');
        $val->add_field('password', 'Your password', 'required|min_length[3]|max_length[20]');
		
        if ( $val->run() )
        {
            $auth = Auth::instance();

            if ( $auth->login($val->validated('username'), $val->validated('password')) )
            {
                Session::set_flash('notice', 'FLASH: logged in');
                Output::redirect('users');
            }
            else
            {
                $data['username']    = $val->validated('username');
                $data['login_error'] = 'Wrong username/password combo. Try again';
            }
        }
        else
        {
            if ( $_POST )
            {
                $data['username'] = $val->validated('username');
                $data['login_error'] = 'Wrong username/password combo. Try again';
            }
            else
            {
                $data['login_error'] = false;
            }
        }

        $this->template->title = 'Login';
		$this->template->login_error = @$data['login_error'];
		$this->template->content = View::factory('users/login', $data);
	}

	public function action_logout()
	{
		Auth::instance()->logout();

        Output::redirect('users');
	}

	public function action_signup()
	{
        if ( Auth::check())
        {
            Output::redirect('/');
        }
		
        $val = Validation::factory('users2');
        $val->add_field('username', 'Your username', 'required|min_length[3]|max_length[20]');
        $val->add_field('password', 'Your password', 'required|min_length[3]|max_length[20]');
        $val->add_field('email', 'Email', 'required|valid_email');
		
        if ( $val->run() )
        {
            $create_user = Auth::instance()->create_user(
                    $val->validated('username'),
                    $val->validated('password'),
                    $val->validated('email'),
                    '100'
            );
            
            if( $create_user )
            {
                Session::set_flash('notice', 'FLASH: User created.');
                Output::redirect('users');
            }
            else
            {
                throw new Exception('An unexpected error occurred. Please try again.');
            }
        }
        else
        {
            if( $_POST )
            {
                $data['username'] = $val->validated('username');
                $data['login_error'] = 'All fields are required.';
            }
            else
            {
                $data['login_error'] = false;
            }
        }


		$this->template->title = 'Sign Up';
        $this->template->login_error = @$data['login_error'];
		$this->template->content = View::factory('users/signup');
	}
}