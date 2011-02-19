<?php

class Controller_Articles extends Controller_Common {
	
	public function before()
    {
        parent::before();
    }
	
    public function action_index()
    {
        $total_articles = Model_Article::count();
        
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
        ));
        
        $this->template->title = 'Articles';
        $this->template->content = View::factory('articles/index', array(
            'total_articles' => $total_articles,
            'articles' => $articles,
        ));
    }
    
    public function action_add()
    {
        if ( Input::method() == 'POST' )
        {
            $val = Validation::factory('add_article');
            $val->add('category_id', 'Category')->add_rule('required');
            $val->add('title', 'Title')->add_rule('required');
            $val->add('body', 'Body')->add_rule('required');
            
            if ( $val->run() == TRUE )
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
            else
            {
                $data['errors'] = $val->show_errors();
            }
        }
        
        $data['categories'] = Model_Category::find('all');
        $this->template->title = 'Add Article';
        $this->template->content = View::factory('articles/add', $data);
    }
    
    public function action_edit($id)
    {
        $article = Model_Article::find($id);
        
        if ( Input::method() == 'POST' )
        {
            $val = Validation::factory('edit_article');
            $val->add('category_id')->add_rule('required');
            $val->add('title')->add_rule('required');
            $val->add('body')->add_rule('required');
            
            if ( $val->run() == TRUE )
            {
                $article->category_id = $val->validated('category_id');
                $article->title = $val->validated('title');
                $article->body = $val->validated('body');
                $article->save();

                Session::set_flash('success', 'Article successfully updated.');

                Output::redirect('articles/edit/'.$article->id);
            }
            else
            {
                $data['errors'] = $val->show_errors();
            }
        }
        
        $data['article'] = $article;
        $data['categories'] = Model_Category::find('all');
        $this->template->title = 'Edit Article - '.$article->title;
        $this->template->content = View::factory('articles/edit', $data);
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