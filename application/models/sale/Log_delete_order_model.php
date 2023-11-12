<?php

class Log_delete_order_model extends CI_Model {



        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
                $this->load->library('session');


        }


 public function Get($data)
        {


$dayfrom = strtotime($data['dayfrom']);
$dayto = strtotime($data['dayto'])+86400;



 $perpage = $data['perpage'];

            if($data['page'] && $data['page'] != ''){
$page = $data['page'];
            }else{
          $page = '1';
            }


            $start = ($page - 1) * $perpage;


$querynum = $this->db->query('SELECT *
    FROM log_delete_order
    WHERE deltime BETWEEN "'.$dayfrom.'" AND "'.$dayto.'" AND product_name LIKE "%'.$data['searchtext'].'%"
	OR deltime BETWEEN "'.$dayfrom.'" AND "'.$dayto.'" AND product_code LIKE "%'.$data['searchtext'].'%"
	OR deltime BETWEEN "'.$dayfrom.'" AND "'.$dayto.'" AND delname LIKE "%'.$data['searchtext'].'%"');


$query = $this->db->query('SELECT *,
from_unixtime(deltime,"%d-%m-%Y %H:%i:%s") as deltime
    FROM log_delete_order
    WHERE  deltime BETWEEN "'.$dayfrom.'" AND "'.$dayto.'" AND product_name LIKE "%'.$data['searchtext'].'%"
	 OR deltime BETWEEN "'.$dayfrom.'" AND "'.$dayto.'" AND delname LIKE "%'.$data['searchtext'].'%"
	 OR deltime BETWEEN "'.$dayfrom.'" AND "'.$dayto.'" AND product_code LIKE "%'.$data['searchtext'].'%"
    ORDER BY deltime DESC LIMIT '.$start.' , '.$perpage.' ');
$encode_data = json_encode($query->result(),JSON_UNESCAPED_UNICODE );


$num_rows = $querynum->num_rows();

$pageall = ceil($num_rows/$perpage);




$json = '{"list": '.$encode_data.',
"numall": '.$num_rows.',"perpage": '.$perpage.', "pageall": '.$pageall.'}';

return $json;


        }












  }
