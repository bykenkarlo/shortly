<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

	public function getCsrfData() {
		$data = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        return $data;
	}
    public function addCategory(){
       if (isset($this->session->user_id)) {
            $data = array(
                'category'=> $this->input->post('category'),
                'created_at'=>date('Y-m-d H:i:s')
            );

            $query = $this->db->WHERE('category', $this->input->post('category'))
                ->INSERT('article_category_tbl', $data);
       }
       else{
            $data['status'] = 'error';
            $data['message'] = 'Action not allowed!';
            return $data;
       }
    }

    public function checkCategoryName(){
        if (isset($this->session->user_id)) {
           return $this->db->WHERE('category', $this->input->post('category'))
            ->GET('article_category_tbl')->num_rows();
       }
       else{
            $data['status'] = 'error';
            $data['message'] = 'Action not allowed!';
            return $data;             
       }   
    }
    public function getCategory($row_per_page, $row_no){
        $query = $this->db->SELECT('id, category, created_at')
            ->ORDER_BY('created_at', 'desc')
            ->LIMIT($row_per_page, $row_no)
            ->GET('article_category_tbl')->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'id'=>$q['id'],
                    'name'=>$q['category'],
                    'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function getCategorySelect(){
        $query = $this->db->SELECT('id, category, created_at')
            ->ORDER_BY('category', 'desc')
            ->GET('article_category_tbl')->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'id'=>$q['id'],
                    'name'=>$q['category'],
                    'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function getCategoryCount(){
        return $this->db->GET('article_category_tbl')->num_rows();
    }
    public function deleteCategory(){
        if (isset($this->session->user_id)) {
            $this->db->WHERE('id', $this->input->post('id'))
                ->DELETE('article_category_tbl');

            $data['status'] = 'success';
            $data['message'] = 'Category successfully deleted!';
            return $data;    
       }
       else{
            $data['status'] = 'error';
            $data['message'] = 'Action not allowed!';
            return $data;             
       }   
    }
    public function checkBlogURL($url) {
        return $this->db->WHERE('url',$url)->GET('article_tbl')->num_rows();
    }
    public function getArticleID($id) {
        return $this->db->SELECT('article_pub_id')->WHERE('article_id',$id)->GET('article_tbl')->row_array();
    }
    public function insertNewBlog($dataArr) {
       $this->db->INSERT('article_tbl', $dataArr);
       return $this->db->insert_id();
    }
    public function insertTags($id) {
        $tags = 0;
        $tags = $this->input->post('tags');
        if (!empty($tags)) {
            foreach($tags as $t){
                $dataArr = array(
                    'article_id'=>$id,
                    'tags'=> $t,
                    'created_at'=>date('Y-m-d H:i:s')
                );
                $this->db->INSERT('article_tags_tbl', $dataArr);
            }
        }
    }
    public function generateBlogPubID ($id, $length = 16) {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $temp_id = '';
        for ($i = 0; $i < $length; $i++) {
            $temp_id .= $characters[rand(0, $charactersLength - 1)];
        }
        $rand = rand(1, 100);
        $article_pub_id = '100'.$rand.$id.$temp_id;
        $dataArr = array('article_pub_id'=>$article_pub_id);
        $this->db->WHERE('article_id',$id)->UPDATE('article_tbl',$dataArr);
    }
    public function generateBlogURLExtension ($length = 7) {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $temp_id = '';
        for ($i = 0; $i < $length; $i++) {
            $temp_id .= $characters[rand(0, $charactersLength - 1)];
        }
        return $temp_id;
    }
    public function getBlogList($row_per_page, $row_no){
        if (isset($this->session->user_id)) {
            $search = $this->input->get('search');
            $query = $this->db->SELECT('article_pub_id, title, url, status, created_at')
                ->ORDER_BY('created_at', 'desc')
                ->WHERE("(title LIKE '%".$search."%')", NULL, FALSE)
                ->WHERE_NOT_IN('status','removed')
                ->LIMIT($row_per_page, $row_no)
                ->GET('article_tbl')->result_array();
                $result = array();

                foreach($query as $q){
                    if ($q['status'] == 'published') {
                        $url = 'article/';
                    }
                    else{
                        $url = 'draft/';
                    }
                    $array = array(
                        'article_pub_id'=>$q['article_pub_id'],
                        'title'=>$q['title'],
                        'url'=>base_url().$url.$q['url'],
                        'status'=>$q['status'],
                        'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                    );
                    array_push($result, $array);
                }
            return $result;
        }
    }
    public function getBlogListCount(){
        if (isset($this->session->user_id)) {
            return $this->db->WHERE_NOT_IN('status','removed')
                ->GET('article_tbl')->num_rows();
        }
    }
    public function updateArticleStatus() {
        if (isset($this->session->user_id)) {
        $status = $this->input->post('status');
          $dataArr = array('status'=>$status,'updated_at'=>date('Y-m-d H:i:s'));
          $this->db->WHERE('article_pub_id', $this->input->post('id'))->UPDATE('article_tbl', $dataArr);

          $response['status'] = 'success';
          $response['message'] = 'Article status change to '.$status.'.';
          return $response;
      }
   }
   public function getArticleData($url){
        $query = $this->db->SELECT('article_pub_id, title, url, status, content, at.created_at, description, lead, article_image, category')
            ->FROM('article_tbl as at')
            ->WHERE('url', $url)
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->GET()->row_array();
        $min_read = round(str_word_count($query['content']) / 190, 0);

        $dataArr = array(
            'min_read'=>$min_read,
            'category'=>$query['category'],
            'title'=>$query['title'],
            'description'=>$query['description'],
            'lead'=>$query['lead'],
            'content'=>$query['content'],
            'published_at'=>$query['created_at'],
            'article_image'=>base_url().$query['article_image'],
            'url'=>base_url('article/').$query['url'],
            'created_at'=>date('d M Y', strtotime($query['created_at'])),
        );
        return $dataArr;
    }
    public function getArticleDataURL($url){
        $query = $this->db->SELECT('title, description, article_image, url, category, status, at.created_at, at.updated_at')
            ->FROM('article_tbl as at')
            ->WHERE('url', $url)
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->GET()->row_array();

        $dataArr = array(
            'category'=>$query['category'],
            'title'=>$query['title'],
            'description'=>$query['description'],
            'status'=>$query['status'],
            'created_at'=>date('Y-m-d H:i:s', strtotime($query['created_at'])),
            'updated_at'=>date('Y-m-d H:i:s', strtotime($query['updated_at'])),
            'article_image'=>base_url().$query['article_image'],
            'url'=>base_url('article/').$query['url'],
        );
        return $dataArr;
    }
    public function getArticleDataJS(){
        $url_data = explode('article/', $this->input->get('url'));
        $url = $url_data[1];   

        $query = $this->db->SELECT('article_id, article_pub_id, title, url, status, content, at.created_at, description, lead, article_image, category, status')
            ->FROM('article_tbl as at')
            ->WHERE('url', $url)
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->GET()->row_array();
        $min_read = round(str_word_count($query['content']) / 190, 0);

        $dataArr = array(
            'article_id'=>$query['article_id'],
            'min_read'=>$min_read,
            'article_pub_id'=>$query['article_pub_id'],
            'category'=>$query['category'],
            'title'=>$query['title'],
            'description'=>$query['description'],
            'lead'=>$query['lead'],
            'content'=>$query['content'],
            'published_at'=> $this->getTimeAgo(strtotime($query['created_at'])),
            'status'=>$query['status'],
            'article_image'=>base_url().$query['article_image'],
            'url'=>base_url('article/').$query['url'],
            'created_at'=>date('d M Y', strtotime($query['created_at'])),
        );
        return $dataArr;
    }
    public function getArticleDataForPage(){
        $query = $this->db->SELECT('article_pub_id, title, url, status, at.created_at, content, category, description, article_image')
            ->FROM('article_tbl as at')
            ->WHERE('status','published')
            ->LIMIT(20, 1)
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $min_read = round(str_word_count($q['content']) / 190, 0);

                $array = array(
                    'min_read'=>$min_read,
                    'category'=>$q['category'],
                    'title'=>$q['title'],
                    'description'=>$q['description'],
                    'url'=>base_url('article/').$q['url'],
                    'article_image'=>base_url().$q['article_image'],
                    'created_at'=>date('d M Y', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function getArticleDataForSitemap(){
        $query = $this->db->SELECT('title, url, status')
            ->FROM('article_tbl as at')
            ->WHERE('status','published')
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'title'=>$q['title'],
                    'url'=>base_url('article/').$q['url'],
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function getRecentArticleDataForPage(){
        $query = $this->db->SELECT('article_pub_id, title, url, status, at.created_at, content, category, description, article_image')
            ->FROM('article_tbl as at')
            ->WHERE('status','published')
            ->LIMIT(1)
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $min_read = round(str_word_count($q['content']) / 190, 0);

                $array = array(
                    'min_read'=>$min_read,
                    'category'=>$q['category'],
                    'title'=>$q['title'],
                    'description'=>$q['description'],
                    'url'=>base_url('article/').$q['url'],
                    'article_image'=>base_url().$q['article_image'],
                    'created_at'=>date('d M Y', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function getTimeAgo( $time ) {
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
            30 * 24 * 60 * 60 =>  'month',
            24 * 60 * 60      =>  'day',
            60 * 60           =>  'hour',
            60                =>  'minute',
            1                 =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
    public function getArticleDataID($id){
        $query = $this->db->SELECT('article_id, article_pub_id, title, category, description, article_image, url, content, status, lead, act.id as category_id')
            ->FROM('article_tbl as at')
            ->WHERE('article_pub_id', $id)
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->GET()->row_array();

        $dataArr = array(
            'tags'=>$this->getArticleTags($query['article_id']),
            'article_id'=>$query['article_id'],
            'article_pub_id'=>$query['article_pub_id'],
            'category'=>$query['category'],
            'title'=>$query['title'],
            'content'=>$query['content'],
            'lead'=>$query['lead'],
            'category_id'=>$query['category_id'],
            'description'=>$query['description'],
            'status'=>$query['status'],
            'article_image'=>base_url().$query['article_image'],
            'url'=>$query['url'],
        );
        return $dataArr;
    }
    public function checkBlogURLID($url, $id) {
        return $this->db
            ->WHERE('url',$url)
            ->WHERE_NOT_IN('article_pub_id',$id)
            ->GET('article_tbl')->num_rows();
    }
    public function updateBlog($dataArr, $id) {
        $this->db->WHERE('article_pub_id', $id)
            ->UPDATE('article_tbl', $dataArr);
    }
    public function uploadImage($dataArr, $id) {
        $this->db ->INSERT('article_images_tbl', $dataArr);
    }
    public function getArticleTags($id){
        return $this->db->WHERE('article_id', $id)
            ->GET('article_tags_tbl')->result_array();
    }
    public function removeTag(){
        if (isset($this->session->user_id)) {
            $this->db->WHERE('id', $this->input->post('id'))
                ->DELETE('article_tags_tbl');
            
            $data['status'] = 'success';
            $data['message'] = 'Tag Removed!';
            return $data;
        }
    }
    public function addTag(){
        $checkTag = $this->checkTag();
        if(empty($this->input->post('tag'))) {
            $data['status'] = 'error';
            $data['message'] = 'Tag is required!';
        }
        else if ($checkTag > 0) {
           $data['status'] = 'error';
           $data['message'] = 'Tag already added!';
        }
        else{
            $dataArr = array(
                'tags'=>$this->input->post('tag'), 
                'article_id'=>$this->input->post('id'), 
                'created_at'=>date('Y-m-d H-i:s')
            );
            $this->db->INSERT('article_tags_tbl', $dataArr);
            $tag_id = $this->db->insert_id();
            $data['status'] = 'success';
            $data['message'] = 'Tag successfullyd added!';
            $data['id'] = $tag_id;
        }
        return $data;
    }
    public function checkTag(){
        return $this->db->WHERE('tags',$this->input->post('tag'))->WHERE('article_id',$this->input->post('id'))
        ->GET('article_tags_tbl')->num_rows();
    }
    public function deleteArticle(){
        if (isset($this->session->user_id)) {
            $dataArr = array('status'=>'removed');
            $this->db->WHERE('article_pub_id', $this->input->post('id'))
                ->UPDATE('article_tbl',$dataArr);

            $data['status'] = 'success';
            $data['message'] = 'Article successfully removed!';
            return $data;    
       }
       else{
            $data['status'] = 'error';
            $data['message'] = 'Action not allowed!';
            return $data;             
       }   
    }
    public function getSearchBlogArticle(){
        if (isset($this->session->user_id)) {
            $search = $this->input->get('search');
            $query = $this->db->SELECT('article_pub_id, title, url, status, created_at')
                ->WHERE("(title LIKE '%".$search."%')", NULL, FALSE)
                ->WHERE_NOT_IN('status','removed')
                ->ORDER_BY('created_at', 'desc')
                ->GET('article_tbl')->result_array();
            $result = array();

            foreach($query as $q){
                if ($q['status'] == 'published') {
                    $url = 'article/';
                }
                else{
                    $url = 'draft/';
                }
                $array = array(
                    'article_pub_id'=>$q['article_pub_id'],
                    'title'=>$q['title'],
                    'url'=>base_url().$url.$q['url'],
                    'status'=>$q['status'],
                    'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getSearchBlogArticleCount(){
        if (isset($this->session->user_id)) {
            $search = $this->input->get('search');
            $query = $this->db->WHERE("(title LIKE '%".$search."%' )", NULL, FALSE)
                ->WHERE_NOT_IN('status','removed')
                ->GET('article_tbl')->num_rows();
            return $query;
        }
    }
    public function getCategoryDataForPage($row_per_page, $row_no, $category){
        $category = str_replace('-',' ', strtolower($category));
        $query = $this->db->SELECT('at.title, at.url, at.description, at.article_image, at.created_at, at.content, act.category')
            ->FROM('article_tbl as at')
            ->LIMIT($row_per_page, $row_no)
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->WHERE('act.category', $category)
            ->WHERE('at.status','published')
            // ->OR_WHERE("(act.category LIKE '%".$category."%')", NULL, FALSE)
            ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $min_read = round(str_word_count($q['content']) / 190, 0);

                $array = array(
                    'min_read'=>$min_read,
                    'title'=>$q['title'],
                    'description'=>$q['description'],
                    'category'=>$q['category'],
                    'url'=>base_url('article/').$q['url'],
                    'article_image'=>base_url().$q['article_image'],
                    'created_at'=>date('d F Y', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function getCategoryDataForPageCount($category){
        $category = str_replace('-',' ', strtolower($category));
        return $this->db->FROM('article_tbl as at')
            ->WHERE('status','published')
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->WHERE('category', $category)
            ->GET()->num_rows();
    }
    public function blogRecentPosts($article_pub_id){
        $query = $this->db->SELECT('at.title, at.url, at.description, at.article_image, at.created_at, at.content')
            ->FROM('article_tbl as at')
            ->WHERE('at.status','published')
            ->WHERE_NOT_IN('article_pub_id', $article_pub_id)
            ->ORDER_BY('created_at','desc')
            ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'title'=>$q['title'],
                    'url'=>base_url('article/').$q['url'],
                    'article_image'=>base_url().$q['article_image'],
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function blogRelatedPostsData($category, $article_pub_id){
        $category = str_replace('-',' ', strtolower($category));

        $query = $this->db->SELECT('at.title, at.url, at.description, at.article_image, at.created_at, at.content, act.category')
            ->FROM('article_tbl as at')
            ->JOIN('article_category_tbl as act','act.id=at.category_id')
            ->WHERE('act.category', $category)
            ->WHERE('at.status','published')
            ->WHERE_NOT_IN('article_pub_id', $article_pub_id)
            ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'title'=>$q['title'],
                    'url'=>base_url('article/').$q['url'],
                    'article_image'=>base_url().$q['article_image'],
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function checkArticle(){
        $query = $this->db->SELECT('url, status')
            ->WHERE('article_pub_id',$this->input->get('article_pub_id'))
            ->GET('article_tbl')->row_array();
        if ($query['status'] == 'published') {
            $response['url'] = base_url().'article/'.$query['url'];
        }
        else{
            $response['url'] = base_url().'draft/'.$query['url'];
        }
        return $response;
    }
    public function getArticleTagDataForPage($row_per_page, $row_no, $tag){
        $tag = str_replace('-',' ', strtolower($tag));
        $query = $this->db->SELECT('at.title, at.url, at.description, at.article_image, at.created_at, at.content')
            ->FROM('article_tbl as at')
            ->LIMIT($row_per_page, $row_no)
            ->JOIN('article_tags_tbl as att','att.article_id=at.article_id')
            ->WHERE('att.tags', $tag)
            ->WHERE('at.status','published')
            ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $min_read = round(str_word_count($q['content']) / 190, 0);

                $array = array(
                    'min_read'=>$min_read,
                    'title'=>$q['title'],
                    'description'=>$q['description'],
                    'url'=>base_url('article/').$q['url'],
                    'article_image'=>base_url().$q['article_image'],
                    'created_at'=>date('d F Y', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
        return $result;
    }
    public function getArticleTagDataForPageCount($tag){
        $tag = str_replace('-',' ', strtolower($tag));
        return $this->db->WHERE('tags', $tag)
            ->FROM('article_tbl as at')
            ->JOIN('article_tags_tbl as att','att.article_id=at.article_id')
            ->WHERE('att.tags', $tag)
            ->WHERE('at.status','published')
            ->GET()->num_rows();
    }
    public function getImageList($row_per_page, $row_no){
        if (isset($this->session->user_id)) {
            $query = $this->db->SELECT('image, created_at')
                ->WHERE('user_id', $this->session->user_id)
                ->ORDER_BY('created_at', 'desc')
                ->LIMIT($row_per_page, $row_no)
                ->GET('article_images_tbl')->result_array();
                $result = array();
                foreach($query as $q){
                    
                    $array = array(
                        'image'=>base_url().$q['image'],
                        'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                    );
                    array_push($result, $array);
                }
            return $result;
        }
    }
    public function getImageListCount(){
        if (isset($this->session->user_id)) {
            return $this->db->WHERE('user_id', $this->session->user_id)
            ->GET('article_images_tbl')->num_rows();
        }
    }
}