<?php
class Database {
    private $dtb_host, $dtb_user, $dtb_pass, $dtb_name, $mysql;

    public function __construct() {
        $this->dtb_host = DTB_HOST;
        $this->dtb_user = DTB_USER;
        $this->dtb_pass = DTB_PASS;
        $this->dtb_name = DTB_NAME;

        $this->mysql = new mysqli($this->dtb_host, $this->dtb_user, $this->dtb_pass, $this->dtb_name) or die($this->mysql->error);
    }

    public function __destruct() {
        $this->mysql->close();
    }

    public function stmt_query($query, $binds = [], $binds_type = [], $output = null, $header = null) {
        $param_type = '';
        $n = count($binds_type);
        
        for($i = 0; $i < $n; $i++) {
            $param_type .= $binds_type[$i];
        }
        
        $a_params = array();
        $a_params[] = & $param_type;
        
        for($i = 0; $i < $n; $i++) {
            $a_params[] = & $binds[$i];
        }

        $stmt = $this->mysql->prepare($query);

        if($n > 0) {
            call_user_func_array(array($stmt, 'bind_param'), $a_params);
        }

        if($stmt->execute()) {
            if($output !== null) {
                echo $output;
            }
            
            if($header !== null) {
                header("Location: /".$header);
                exit();
            }
        } else {
            echo $stmt->error;
        }
    }
}
?>