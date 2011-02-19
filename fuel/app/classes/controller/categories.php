<?php

class Controller_Categories extends Controller_Common {
	
	public function before()
    {
        parent::before();
    }
    
    public function action_index()
    {
        $total_categories = Model_Article::count();
        
        Pagination::set_config(array(
            'pagination_url' => 'categories/index',
            'per_page' => 5,
            'total_items' => $total_categories,
            'num_links' => 3,
        ));
        
        $categories = Model_Category::find('all', array(
            'offset' => Pagination::$offset,
            'limit' => Pagination::$per_page,
        ));
        
        $this->template->title = 'Categories';
        $this->template->content = View::factory('categories/index', array(
            'total_categories' => $total_categories,
            'categories' => $categories,
        ));
    }
    
    public function action_add()
    {
        $data = array();
        
        if ( Input::method() == 'POST' )
        {
            $val = Validation::factory('add_category');
            $val->add('name', 'Name')->add_rule('required');
            $val->add('description', 'Description');
            
            if ( $val->run() == TRUE )
            {
                $category = new Model_Category(array(
                    'name' => $val->validated('name'),
                    'description' => $val->validated('description'),
                    'created_time' => Date::time(),
                ));

                $category->save();
                
                Session::set_flash('success', 'Category successfully added.');
                
                Output::redirect('categories/add');
            }
            else
            {
                $data['errors'] = $val->show_errors();
            }
        }
        
        $this->template->title = 'Add Category';
        $this->template->content = View::factory('categories/add', $data);
    }
    
    public function action_edit($id)
    {
        $category = Model_Category::find($id);
        
        if ( Input::method() == 'POST' )
        {
            $val = Validation::factory('edit_category');
            $val->add('name', 'Name')->add_rule('required');
            $val->add('description', 'Description');
            
            if ( $val->run() == TRUE )
            {
                $category->name = $val->validated('name');
                $category->description = $val->validated('description');
                $category->save();
            
                Session::set_flash('success', 'Category successfully updated.');
            
                Output::redirect('categories/edit/'.$category->id);
            }
            else
            {
                $data['errors'] = $val->show_errors();
            }
        }
        
        $data['category'] = $category;
        $this->template->title = 'Edit Category - '.$category->name;
        $this->template->content = View::factory('categories/edit', $data);
    }
    
    public function action_delete($id)
    {
        Model_Category::find($id)->delete();
                
        Output::redirect('categories');
    }
}