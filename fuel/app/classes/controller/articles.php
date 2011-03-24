<?php

class Controller_Articles extends Controller_Common {
	
	public function before()
    {
        parent::before();
    }
	
    public function action_index($show = 'published')
    {
		if ( $show === 'published' )
		{
			$published = 1;
		}
		else
		{
			$published = 0;
		}
		
        $total_articles = Model_Article::count_by_published($published);
        
        Pagination::set_config(array(
            'pagination_url' => 'articles/index',
            'per_page' => 5,
            'total_items' => $total_articles,
            'num_links' => 3,
        ));
        
        $articles = Model_Article::find('all', array(
            'offset' => Pagination::$offset,
            'limit' => Pagination::$per_page,
            'include' => 'category',
			'where' => array(array('published', '=', $published))
        ));
        
        $this->template->title = 'Articles';
        $this->template->content = View::factory('articles/index', array(
            'total_articles' => $total_articles,
            'articles' => $articles,
			'show' => $show,
        ));
    }
    
    public function action_add()
    {
        $val = Validation::factory('add_article');
        $val->add('category_id', 'Category')->add_rule('required');
        $val->add('title', 'Title')->add_rule('required');
        $val->add('body', 'Body')->add_rule('required');
        
        if ( $val->run() )
        {
            if ( Input::post('save_draft') )
            {
                $status = 0;
            }
            else
            {
                $status = 1;
            }
            
            $article = new Model_Article(array(
                'category_id' => $val->validated('category_id'),
                'title' => $val->validated('title'),
                'body' => $val->validated('body'),
                'created_time' => Date::time(),
                'published' => $status,
            ));

            $article->save();
            
            Session::set_flash('success', 'Article successfully added.');
            
            Output::redirect('articles/add');
        }
        
        $this->template->title = 'Add Article';
        $this->template->content = View::factory('articles/add', array(
        	'categories' => Model_Category::find('all'),
			'val' => Validation::instance('add_article'),
        ));
    }
    
    public function action_edit($id)
    {
        $article = Model_Article::find($id);
        
       	$val = Validation::factory('edit_article');
        $val->add('category_id')->add_rule('required');
        $val->add('title')->add_rule('required');
        $val->add('body')->add_rule('required');
        
        if ( $val->run() )
        {
            $article->category_id = $val->validated('category_id');
            $article->title = $val->validated('title');
            $article->body = $val->validated('body');
            $article->save();

            Session::set_flash('success', 'Article successfully updated.');

            Output::redirect('articles/edit/'.$article->id);
        }
        
        $this->template->title = 'Edit Article - '.$article->title;
        $this->template->content = View::factory('articles/edit', array(
			'categories' => Model_Category::find('all'),
			'article' => $article,
			'val' => Validation::instance('edit_article'),
        ));
    }
    
    public function action_publish($id)
    {
        $article = Model_Article::find($id);
        $article->published = 1;
        $article->save();

        Output::redirect('articles');
    }
    
    public function action_delete($id)
    {
        Model_Article::find($id)->delete();
        
        Output::redirect('articles');
    }
}