<?php

/*  Automatically was generated from a template fw/templates/model.php */

class Article extends \Extend\Model{

    public $sets;

    public function __construct(){
        $this -> sets = new \Sets\ArticleSet;
    }

    public function get_article_list($count_on_page, $page_num, $order_field_name = 'id', $order_desc = true){
    	$order = $order_desc ? 'DESC' : 'ASC';
    	$articles = atarr($this -> get(['where' => ['published', '=', '1'],'order' => [$order_field_name, $order], 'limit' => [$count_on_page * $page_num, $count_on_page]]));
    	foreach ($articles as $inx => $article) {
    		$articles[$inx] = $this -> fields_transform($articles[$inx], ['meta', 'thumbnail', 'link']);
    	}

    	return $articles;
    }

    public function fields_transform($article, $fields){
    	foreach($fields as $inx => $field){
    		if(isset($article[$field])){
    			continue;
    		}
    		switch($field){
    			case 'meta': $article['meta'] = model('Route_meta') -> get_by_article_id($article['id']); break;
    			case 'thumbnail': $article['thumbnail'] = model('Media') -> get_src(model('Media') -> get_media($article['thumbnail_media_id'], 'sm')); break;
    			case 'comments': $article['comments'] = model('Comment') -> get_by_article_id($article['id']); break;
    			case 'link': 
    				if(!isset($article['meta'])){
    					$article = $this -> fields_transform($article, ['meta']);
    				}
    				$slug = explode('/', $article['meta']['route']);
    				$slug = $slug[count($slug) - 1];
    				$article['link'] = linkTo('ArticleController@single_article', ['slug' => $slug]); 
    			break;
    			case 'tags': $article['tags'] = model('Tag') -> get_by_article_id($article['id']); break;
    		}
    	}

    	return $article;
    }

    public function get_all(){
    	$rows = ['id', 'timestamp'];
    	$articles = atarr($this -> get(['rows' => $rows, 'order' => ['id', 'DESC']]));
    	foreach($articles as $inx => $item){
    		$articles[$inx] = $this -> fields_transform($articles[$inx], ['meta']);
    	}

    	return $articles;
    }

    public function get_article_by_slug($slug){
    	$meta = model('Route_meta') -> get(['route', '=', $slug]);
    	if(isset($meta[0])){
    		$meta = $meta[0];
    	}
    	return $this -> get_article_by_id($meta['article_id']);
    }

    public function get_article_by_id($article_id){
    	$article = $this -> get(['id', '=', $article_id]);
    	$fields = ['meta', 'thumbnail', 'link', 'tags'];
    	if($article['with_comments'] == 1){
    		$fields[] = 'comments';
    	}
    	$article = $this -> fields_transform($article, $fields);
    	return $article;
    }

    public function create($data, $file = false){
    	$article = [
    		'content' => $data['content'],
    		'with_comments' => $data['with_comments'] == 'on' ? '1' : '0',
    		'published' => $data['published'] == 'on' ? '1' : '0',
    		'timestamp' => 'NOW()'
    	];

    	$this -> set($article);
    	$article = $this -> last();

    	$meta = [
    		'title' => $data['title'],
    		'keywords' => $data['keywords'],
    		'description' => $data['description'],
    		'route' => '/article/' . $data['route'],
    		'article_id' => $article['id']
    	];

    	model('Route_meta') -> set($meta);

    	if($file){
    		$thumbnail_id = model('Media') -> set_new_media($file['tmp_name'], $file['name']);
    		$this -> update(['thumbnail_media_id' => $thumbnail_id], ['id', '=', $article['id']]);
    	}

    	return true;
    }

    public function update_article($data, $article_id, $file = false){
    	$data['published'] = $data['published'] == 'on' ? '1' : '0';
    	$data['with_comments'] = $data['with_comments'] == 'on' ? '1' : '0';
    	if($file){
    		$thumbnail_media_id = model('Media') -> set_new_media($file['tmp_name'], $file['name']);
    		$data['thumbnail_media_id'] = $thumbnail_media_id;
    	}
    	$this -> update($data, ['id', '=', $article_id]);
    	model('Route_meta') -> update($data, ['article_id', '=', $article_id]);
    	return true;
    }

    public function remove_article($article_id){
    	$this -> remove(['id', '=', $article_id]);
    	return model('Route_meta') -> remove(['article_id', '=', $article_id]);
    }

    public function count_published_articles(){
    	return model('Article') -> length(['published', '=', '1']);
    }

    public function count_articles(){
    	return model('Article') -> length();
    }

}