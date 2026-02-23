<?php
class Crud_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function search_front($search_word,$per_page,$offset)
    {
        $conditions = array();

        if (!empty($search_word)) {

            $conditions[] = '	vw_front_search.title  LIKE "%' . $search_word . '%"';
            $conditions[] = '	vw_front_search.description  LIKE "%' . $search_word . '%"'; 
            $sqlStatement = "SELECT * FROM 	vw_front_search WHERE ".implode(' OR ', $conditions)." ORDER BY vw_front_search.module_name ASC LIMIT $per_page";
            $result = $this->db->query($sqlStatement)->result();
        }else{
            $result = [];
        }

        return $result;
    }
    
    function count_search($search_word)
    {
        // $search_word = $this->session->userdata('search_word');

        $conditions = array();

        if (!empty($search_word)) {

            $conditions[] = '	vw_front_search.title  LIKE "%' . $search_word . '%"';
            $conditions[] = '	vw_front_search.description  LIKE "%' . $search_word . '%"'; 
            $sqlStatement = "SELECT count(title) as total FROM 	vw_front_search WHERE ".implode(' OR ', $conditions);
            $result = $this->db->query($sqlStatement)->row();
            
            $total = isset($result->total)?$result->total:0;
        }else{
            $total = 0;
        }

        return $total;
    }
    
    public function get_module_function($module_name, $function_name)
    {
        $where = array(
            'a.module_name' => $module_name,
            'a.status' => '1',
            'b.function_name' => $function_name,
        );
        $this->db->select("a.module_name, b.function_name, b.id as module_function_id", False);
        $this->db->from('module a');
        $this->db->join('module_function b', "b.module_id = a.id");
        $this->db->where($where);
        return $this->db->get('')->row();
    }

    public function get_module_function_for_role($module_name, $function_name)
    {
        $check_module_dissable = $this->db->get_where('module', array('module_name' => $module_name))->row();
        if (isset($check_module_dissable->status) && $check_module_dissable->status == '1') {
            $current_user = $this->auth->current_user();
            // var_dump($current_user->role_id);
            // exit;
            $sql = "SELECT a.* FROM module_function_role a LEFT JOIN module_function b ON a.module_function_id = b.id LEFT JOIN module c on c.id=b.module_id WHERE c.module_name = '$module_name' AND b.function_name = '$function_name' AND role_id = $current_user->role_id ";
            $query = $this->db->query($sql);
            $data = $query->row();
            if ($data) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function get_module_for_role($module_name)
    {
        $check_module_dissable = $this->db->get_where('module', array('module_name' => $module_name))->row();
        if (isset($check_module_dissable->status) && $check_module_dissable->status == '1') {
            $current_user = $this->auth->current_user();
            
            $sql = "SELECT a.* FROM module_function_role a LEFT JOIN module_function b ON a.module_function_id = b.id LEFT JOIN module c on c.id=b.module_id WHERE c.module_name = '$module_name' AND role_id = $current_user->role_id ";
            $query = $this->db->query($sql);
            $data = $query->row();
            
            if ($data) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function count_all_data($table, $data)
    {
        $this->db->select('count(id) as total')->from($table);
        foreach ($data as $key => $val) {
            if ($key == 'approved_by') {
                if ($val == "1") {
                    $this->db->where('approved_by !=', '');
                } else if ($val == "0") {
                    $this->db->where('approved_by', '');
                } else {
                }
            } else {
                if ($val != '') {
                    $this->db->where($key, $val);
                }
            }
        }
        $this->db->order_by("id", "desc");

        $query = $this->db->get();

        $q = $query->row();
        // echo $this->db->last_query();
        // exit;
        return $q;
    }

    public function get_all_data($table, $data, $limit, $offset)
    {
        $this->db->select('*')->from($table);
        foreach ($data as $key => $val) {
            if ($key == 'approved_by') {
                if ($val == "1") {
                    $this->db->where('approved_by !=', '');
                } else if ($val == "0") {
                    $this->db->where('approved_by', '');
                } else {
                }
            }else if ($key == 'PageTitle' || $key == 'PageTitleNepali' || $key == 'department_name' || $key == 'department_code'|| $key == 'designation_code' || $key == 'designation_name'|| $key == 'name'|| $key == 'email' || $key == 'sh_name'  || $key == 'user_name' || $key == 'title') {
                if ($val != '') {
                    $this->db->like($key, $val);
                }
            }else {
                if ($val != '') {
                    $this->db->where($key, $val);
                }
            }
        }
        $this->db->order_by("id", "desc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        $q = $query->result(); //echo $this->db->last_query();exit;
        return $q;
    }

    
    public function getAll($table, $where, $limit, $offset)
    {
        $blogs = $this->db->select('*')->from($table)->where($where)->limit($limit, $offset)->get('')->result_array();
        return $blogs;
    }
    public function get_single($table, $where)
    {
        $blog = $this->db->select('*')->from($table)->where($where)->get('')->row();
        return $blog;
    }

    public function insert($table, $data)
    {
        $result = $this->db->insert($table, $data);
        if ($result) {
            return true;
        } else { 
            return false;
        }
        
    }

    public function update($table, $data, $array)
    {
        $result = $this->db->update($table, $data, $array);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_where($table, $where)
    {
        $result = $this->db->order_by('id', 'DESC')->get_where($table, $where)->result();
        return $result;
    }

    public function get_where_order_by($table, $where, $order_by, $order_value)
    {
        $result = $this->db->order_by($order_by, $order_value)->get_where($table, $where)->result();
        return $result;
    }

    public function get_where_single($table, $where)
    { 
        return $this->db->get_where($table, $where)->row();
       
    }

    public function get_where_single_order_by($table, $where, $order_by, $order_value)
    {
        $result = $this->db->order_by($order_by, $order_value)->get_where($table, $where)->row();
        return $result;
    }

    public function get_where_single_order_by_with_offset($table, $where, $order_by, $order_value, $offset)
    {
        $result = $this->db->order_by($order_by, $order_value)->get_where($table, $where, 1, $offset)->row();
        return $result;
    }

    public function count_all($table, $where, $field)
    {
        $total = $this->db->select('count(' . $field . ') as total')->from($table)->where($where)->get()->row();
        return $total->total;
    }
    
    public function count_allIN($table, $where, $field)
    {
        $this->db->select('count(' . $field . ') as total')->from($table);
    
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
    
        $total = $this->db->get()->row();
        return $total->total;
    }

    public function get_home_product_pkh(){
        $tables = [
            'deposit_category' => ['slug'=>'slug','title' => 'PageTitle', 'title_np' => 'PageTitleNepali','description'=>'Description','description_np'=>'DescriptionNepali', 'file' => 'CoverImage','rank'=>'rank'],
            'loan_category' => ['slug'=>'slug','title' => 'PageTitle', 'title_np' => 'PageTitleNepali','description'=>'Description','description_np'=>'DescriptionNepali', 'file' => 'CoverImage','rank'=>'rank']
        ];
            
            $modules = [
                'deposit_category' => 'deposit',
                'loan_category' => 'loan'
            ];
            $conditions = ['status' => ['1','3'],'show_on_menu'=>'Yes'];
            // $result = $this->crud_model->union_tables($tables, $conditions);
            //  $result = $this->crud_model->union_tables_module($tables, $conditions, $modules);
             $result = $this->crud_model->union_tables_module_limit($tables, $conditions, $modules, 3, 'rank', 'DESC');
             return $result;
    }
    
    public function get_home_product(){
        $tables = [
            'deposit' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali','description'=>'Description','description_np'=>'DescriptionNepali', 'file' => 'DocPath','serial'=>'serial'],
            'loan' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali','description'=>'Description','description_np'=>'DescriptionNepali', 'file' => 'DocPath','serial'=>'serial']
        ];
            
            $modules = [
                'deposit' => 'deposit',
                'loan' => 'loan'
            ];
           
             $conditions = ['status' => ['1','3']];
             $result = $this->crud_model->union_tables_module_limit($tables, $conditions, $modules, 3, 'serial', 'ASC'); 
             
             return $result;
    }
    
    public function count_all_services($table, $where, $field, $subcategories)
    {
                $this->db->select('count(' . $field . ') as total');
                $this->db->from($table);
                $this->db->where($where);
                
                $this->db->group_start();
                foreach($subcategories as $key=>$val){
                    if($key = 0){
                        $this->db->where('service_cat_id',$val);
                    }else{
                        $this->db->or_where('service_cat_id',$val);
                    } 
                }
                $this->db->group_end();
                
                 $total = $this->db->get()->row();
        return $total->total;
    }

    public function get_where_pagination($table, $where, $limit, $offset)
    {
        $result = $this->db->order_by('id', 'DESC')->get_where($table, $where, $limit, $offset)->result();
        return $result;
    }
    
    public function get_where_pagination_service($table, $where, $limit, $offset, $subcategories)
    {
        // $result = $this->db->order_by('id', 'DESC')->get_where($table, $where, $limit, $offset)->result();
        // return $result;
        
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        
        $this->db->group_start();
        foreach($subcategories as $key=>$val){
            if($key = 0){
                $this->db->where('service_cat_id',$val);
            }else{
                $this->db->or_where('service_cat_id',$val);
            } 
        }
        $this->db->group_end();
        
        $this->db->order_by("id", "DESC");
        $this->db->limit($limit, $offset);
        
         $result = $this->db->get()->result();
        return $result;
    }

    public function get_where_pagination_order_by($table, $where, $limit, $offset, $order_by, $type)
    {
        $result = $this->db->order_by($order_by, $type)->get_where($table, $where, $limit, $offset)->result();
        return $result;
    }

    function createUrlSlug($urlString)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $urlString);
        return $slug;
    }
    function detectTextLanguage($text)
    {
        // Check if the text contains Nepali (Devanagari script)
        if (preg_match('/[\x{0900}-\x{097F}]/u', $text)) {
             return false;
            // return 'Nepali';
        }
        
        // Check if the text contains English (Latin script)
        if (preg_match('/[a-zA-Z]/', $text)) {
            return true;
            // return 'English';
        }
    }
    
    function newcreateUrlSlug($urlString)
    {
        // Remove special characters, keep Nepali and English letters, numbers, and hyphens
        $slug = preg_replace('/[^\p{L}\p{N}\s-]+/u', '', $urlString);  // Allow Unicode letters and numbers
        $slug = preg_replace('/[\s-]+/', '-', trim($slug));             // Replace spaces and multiple dashes with a single dash
        $slug = strtolower($slug);                                      // Convert to lowercase for consistency
    
        return $slug;
    }

    public function menuTree($parent_id = 0, $html = '')
    {
        $menus = $this->crud_model->get_where_order_by('contents', array('status' => '1', 'show_on_menu' => 'Yes', 'parent_id' => $parent_id), 'order_no', 'ASC');
        if (count($menus) > 0) {
            $html = '';
            foreach ($menus as $row) {
                $subMenus = $this->crud_model->get_where_order_by('contents', array('status' => '1', 'show_on_menu' => 'Yes', 'parent_id' => $row->id), 'order_no', 'ASC');
                if (count($subMenus) > 0) {
                    $html  .= '<li class="dropdown"><a href="#"><span>' . $row->title . '</span> <i class="bi bi-chevron-right"></i></a>
            
                                    <ul>  
                                    ';
                    $html .= $this->menuTree($row->id);
                    $html .=   '    </ul>
                              </li>';
                } else {
                    $html .= '<li><a href="#">' . $row->title . '</a></li>';
                }
            }
        }
        return  $html;
    }

    public function joinDataSingle($table, $join_table, $where, $key_table, $referencekey, $joinField)
    {
        $this->db->select("$table.*,$join_table.$joinField", False);
        $this->db->from($table);
        $this->db->join($join_table, "$join_table.$referencekey=$table.$key_table");
        $this->db->where($where);
        return $this->db->get('')->row();
    }

    public function joinDataMultiple($table, $join_table, $where, $key_table, $referencekey, $joinField)
    {
        $this->db->select("$table.*,$join_table.$joinField", False);
        $this->db->from($table);
        $this->db->join($join_table, "$join_table.$referencekey=$table.$key_table");
        $this->db->where($where);
        return $this->db->get('')->result();
    } 
    
    public function get_district_detail_with_province($district_id)
    {
        $this->db->select("districts.title as district, provinces.title as province", False);
        $this->db->from('districts');
        $this->db->join('provinces', "provinces.id=districts.province_id");
        $this->db->where('districts.id', $district_id);
        return $this->db->get('')->row();
    }
    
    public function get_banners()
    { 
        $this->db->select("DocPath as file, file_type, Title, Description", False);
        $this->db->from('banners'); 
        $this->db->where('status','1');
        $this->db->where('file_type !=','video');
        $this->db->order_by('BOrder','DESC');
        $this->db->limit(10,0);
        return $this->db->get('')->result();
    }
    
    public function get_digital_slider()
    { 
        $this->db->select("DocPath as file, file_type", False);
        $this->db->from('banners'); 
        $this->db->where('status','1');
        $this->db->where('file_type','digital_slider');
        $this->db->order_by('BOrder','DESC');
        $this->db->limit(3,0);
        return $this->db->get('')->result();
    }
    
    public function get_news_slider_en()
    { 
        $this->db->select("CoverImage as file, Description, slug", False);
        $this->db->from('news'); 
        $this->db->where('status','1');
        $this->db->where('is_slider','Yes');
        $this->db->order_by('id','DESC');
        $this->db->limit(4,0);
        return $this->db->get('')->result();
    }
    
    public function get_news_slider_np()
    { 
        $this->db->select("CoverImage as file, DescriptionNepali, slug", False);
        $this->db->from('news'); 
        $this->db->where('status','1');
        $this->db->where('is_slider','Yes');
        $this->db->order_by('id','DESC');
        $this->db->limit(4,0);
        return $this->db->get('')->result();
    }
    
    public function get_news_en()
    { 
        $this->db->select("CoverImage as file, Title, created_on, slug", False);
        $this->db->from('news'); 
        $this->db->where('status','1');
        $this->db->where('is_slider','No');
        $this->db->order_by('id','DESC');
        $this->db->limit(4,0);
        return $this->db->get('')->result();
    }
    
     public function get_all_news_en( $where, $limit, $offset, $order_by, $type)
    { 
        $this->db->select("CoverImage as file, Title, created_on, slug", False);
        $this->db->from('news'); 
        $this->db->where($where);
        $this->db->order_by($order_by,' $type');
        $this->db->limit($limit, $offset);
        return $this->db->get('')->result();
    }
    
    
    public function get_news_np()
    { 
        $this->db->select("CoverImage as file, TitleNepali as Title, created_on, slug", False);
        $this->db->from('news'); 
        $this->db->where('status','1');
        $this->db->where('is_slider','No');
        $this->db->order_by('id','DESC');
        $this->db->limit(4,0);
        return $this->db->get('')->result();
    }
    
    public function get_videos_en()
    { 
        $this->db->select("title, youtube_link, featured_image", False);
        $this->db->from('videos'); 
        $this->db->where('status','1'); 
        $this->db->order_by('id','DESC');
        $this->db->limit(3,0);
        return $this->db->get('')->result();
    }
    
    public function get_videos_np()
    { 
        $this->db->select("title_nepali as title, youtube_link, featured_image", False);
        $this->db->from('videos'); 
        $this->db->where('status','1'); 
        $this->db->order_by('id','DESC');
        $this->db->limit(3,0);
        return $this->db->get('')->result();
    }
    
    public function union_tables($tables, $conditions)
    {
        $queries = [];
    
        foreach ($tables as $table => $columns) {
            $select_columns = ["'$table' AS table_name"];
    
            foreach ($columns as $alias => $column) {
                $select_columns[] = "$column AS $alias";
            }
    
            $this->db->select(implode(', ', $select_columns))->from($table);
    
            foreach ($conditions as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
    
            $queries[] = $this->db->get_compiled_select();
        }
    
        $union_query = implode(' UNION ALL ', $queries);
    
        return $this->db->query($union_query)->result();
    }
    
    public function union_tables_module($tables, $conditions, $modules)
    {
        $queries = [];
    
        foreach ($tables as $table => $columns) {
            $select_columns = ["'$table' AS table_name", "'{$modules[$table]}' AS module_name"];
    
            foreach ($columns as $alias => $column) {
                $select_columns[] = "$column AS $alias";
            }
    
            $this->db->select(implode(', ', $select_columns))->from($table);
    
            foreach ($conditions as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        
            $queries[] = $this->db->get_compiled_select();
        }
    
        $union_query = implode(' UNION ALL ', $queries);
    
        return $this->db->query($union_query)->result();
    }
    
    
   public function union_tables_module_limit($tables, $conditions, $modules, $limit = null, $order_by = null, $order_type = 'ASC')
    {  
        $queries = [];
    
        foreach ($tables as $table => $columns) {
            $select_columns = ["'$table' AS table_name", "'{$modules[$table]}' AS module_name"];
    
            foreach ($columns as $alias => $column) {
                $select_columns[] = "$column AS $alias";
            }
    
            $this->db->select(implode(', ', $select_columns))->from($table);
    
            foreach ($conditions as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
    
            // Compile the individual select query
            $queries[] = $this->db->get_compiled_select();
        }
    
        // Combine all queries with UNION ALL
        $union_query = implode(' UNION ALL ', $queries);
    
        // Add ORDER BY to the final union query if specified
        if ($order_by) {
            $union_query .= " ORDER BY " . $this->db->escape_str($order_by) . " " . $this->db->escape_str($order_type);
        }
    
        // Add LIMIT to the final union query if specified
        if ($limit) {
            $union_query .= " LIMIT " . intval($limit);
        }
    $this->db->query($union_query)->result();
        // Execute the final query
        return $this->db->query($union_query)->result(); var_dump($this->db->last_query()); die;
    }



    
    public function get_notification(){
        $tables = [
                'csr' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali', 'file' => 'DocPath','publish_date'=>'datevalue'],
                'career' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali', 'file' => 'DocPath','publish_date'=>'datevalue'],
                // 'rates' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali', 'file' => 'DocPath','publish_date'=>'datevalue']
            ];
            
            $modules = [
                'csr' => 'csr',
                'career' => 'news-notices',
                // 'rates' => 'rates'
            ];
            $conditions = ['status' => ['4','3']];
            // $result = $this->crud_model->union_tables($tables, $conditions);
            $result = $this->crud_model->union_tables_module_limit($tables, $conditions, $modules, 5, 'publish_date', 'DESC');

             return $result;
    }
    
    public function get_bell_notification(){
        $tables = [
                'csr' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali', 'file' => 'DocPath','publish_date'=>'datevalue'],
                'career' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali', 'file' => 'DocPath','publish_date'=>'datevalue'],
                // 'rates' => ['slug'=>'slug','title' => 'Title', 'title_np' => 'TitleNepali', 'file' => 'DocPath','publish_date'=>'datevalue']
            ];
            
            $modules = [
                'csr' => 'csr',
                'career' => 'news-notices',
                // 'rates' => 'rates'
            ];
            $conditions = ['show_pop' => 'Y','status!='=>'2'];
            // $result = $this->crud_model->union_tables($tables, $conditions);
            //  $result = $this->crud_model->union_tables_module($tables, $conditions, $modules);
            $result = $this->crud_model->union_tables_module_limit($tables, $conditions, $modules, 5, 'publish_date', 'DESC');
             return $result;
    }
    
    
    // public function get_popups()
    // { 
    //     $this->db->select("DocPath as file", False);
    //     $this->db->from('popup'); 
    //     $this->db->where('status','1');
    //     $this->db->where('Type','PC');
    //     $this->db->order_by('id','DESC');
    //      $this->db->order_by('Serial','ASC');
    //     // $this->db->limit(4,0);
    //     return $this->db->get('')->result();
    // }
    public function get_sql_all($table, $where, $order_by, $type, $limit, $offset,$sql)
    {  
        $this->db->select($sql, False);
        $this->db->from($table); 
        $this->db->where($where); 
        $this->db->order_by($order_by,$type);
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }
    
   public function get_sql_allIN($table, $where, $order_by, $type, $limit, $offset, $sql)
    {
        $this->db->select($sql, false);
        $this->db->from($table);
    
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
    
        $this->db->order_by($order_by, $type);
        $this->db->limit($limit, $offset);
    
        return $this->db->get()->result();
    }
    
     public function get_sql_all_no_pagination($table, $where, $order_by, $type, $sql)
    {  
        $this->db->select($sql, False);
        $this->db->from($table); 
        // $this->db->where($where); 
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        $this->db->order_by($order_by,$type); 
        return $this->db->get('')->result();
    }
    
    public function get_sql_single($table, $where, $order_by, $type,$sql)
    {  
        $this->db->select($sql, False);
        $this->db->from($table); 
        $this->db->where($where); 
        $this->db->order_by($order_by,$type); 
        return $this->db->get('')->row();
    }
    
    public function get_forex($date){
        $this->db->select("forex_date.date_forex, forex_data.iso3, forex_data.name, forex_data.unit, forex_data.buy, forex_data.sell",FALSE);
        $this->db->from('forex_date');
        $this->db->join('forex_data', "forex_date.id = forex_data.forex_date_id");
        $this->db->where('forex_date.date_forex',$date);
        
        return $this->db->get('')->result();
    }

    //bikash
    function getField($table, $param, $field)  {
        $detail = $this->getDetail($table, $param, $field);
        return $detail->$field;
    }

    function getDetail($table, $param, $field = '*') {
        $sql = $this->db;
        $sql->select($field);
        // if($param){
        //     $sql->where($param);
        // }
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }
        $sql->order_by('id DESC');
        return $sql->get($table)->row();
    }
    
    function getDetailIn($table, $param, $field = '*') {
        $sql = $this->db;
        $sql->select($field);
    
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }
    
        $sql->order_by('id', 'DESC');
        return $sql->get($table)->result();
    }

    public function total($table, $param, $like, $field = 'id')
    {
        $sql = $this->db;
        $sql->select('count(' . $field . ') as total');
        // if($param){
        //     $sql->where($param);
        // }
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }
        if($like){
            $sql->group_start();  //group start
            $sql->or_like($like);
            $sql->group_end();  //group ed
        }
        $total = $sql->get($table)->row();
        if($total){
            return $total->total;
        }
        return 0;
    }

    public function getData($table, $param, $like=[], $limit, $offset, $field = '*', $order_by = 'id DESC')
    {
        $sql = $this->db;
        $sql->select($field);
        // if($param){
        //     $sql->where($param);
        // }
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }
        
        if($like){
           $sql->group_start();  //group start
            $sql->or_like($like);
            $sql->group_end();  //group ed
        }

        if($limit){
            $sql->limit($limit, $offset);
        }
        
        $sql->order_by($order_by);
        

        return $sql->get($table)->result();
    }
    
     public function getDataIN($table, $param, $like, $limit, $offset, $field = '*', $order_by = 'id DESC')
    {
        $sql = $this->db;
        $sql->select($field);
        // if($param){
        //     $sql->where($param);
        // }
         if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }
        if($like){
           $sql->group_start();  //group start
            $sql->or_like($like);
            $sql->group_end();  //group ed
        }

        if($limit){
            $sql->limit($limit, $offset);
        }
        
        $sql->order_by($order_by);
        

        return $sql->get($table)->result();
    }
    
    public function getDataArrays($table, $param, $like, $limit, $offset, $field = '*', $order_by = 'id DESC')
    {
        $sql = $this->db;
        $sql->select($field);
        // if($param){
        //     $sql->where($param);
        // }
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }

        if($like){
           $sql->group_start();  //group start
            $sql->or_like($like);
            $sql->group_end();  //group ed
        }

        if($limit){
            $sql->limit($limit, $offset);
        }
        
        $sql->order_by($order_by);
 
        return $sql->get($table)->result_array();
    }

    public function getTotal($table, $param, $inparam, $inField, $field = 'id')
    {
        $sql = $this->db;
        $sql->select('count(' . $field . ') as total');
        // if($param){
        //     $sql->where($param);
        // }
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }
        
        if($inparam){
            $sql->where_in($inField, $inparam);
        }
        $total = $sql->get($table)->row();
        if($total){
            return $total->total;
        }
        return 0;
    }

    public function getAllData($table, $param, $inparam, $inField, $limit, $offset, $field = '*', $order_by = 'id DESC')
    {
        $sql = $this->db;
        $sql->select($field);
        // if($param){
        //     $sql->where($param);
        // }
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }

        if($inparam){
            $sql->where_in($inField, $inparam);
        }

        if($limit){
            $sql->limit($limit, $offset);
        }
        
        if($order_by){
            $sql->order_by($order_by);
        }

        return $sql->get($table)->result();
    }
    
    public function getDataArray($table, $param, $field = '*', $order_by = 'id DESC')
    {
        $sql = $this->db;
        $sql->select($field);
        // if($param){
        //     $sql->where($param);
        // }
        if ($param) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    $sql->where_in($key, $value);
                } else {
                    $sql->where($key, $value);
                }
            }
        }
        if($like){
            $sql->like($like);
        }

        if($limit){
            $sql->limit($limit, $offset);
        }
        
        if($order_by){
            $sql->order_by($order_by);
        }

        return $sql->get($table)->result_array();
    }
    
    //inserted return id
    public function inserted($table, $data)
    {
        $result = $this->db->insert($table, $data);
      
        if ($result) {
            return $this->db->insert_id();
        } else { 
            return 0;
            
        }
    }
    
    public function insertarr($table,$data = array()){ 
        $insert = $this->db->insert_batch($table, $data); 
        return $insert?true:false; 
    } 
    
}