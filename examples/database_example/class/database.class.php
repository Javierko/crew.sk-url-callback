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
        
        $bindsCount = count($binds_type);
        
        for($i = 0; $i < $bindsCount; $i++) {
            $param_type .= $binds_type[$i];
        }
        
        $binds_a = [];
        $binds_a[] = & $param_type;
        
        for($i = 0; $i < $bindsCount; $i++) {
            $binds_a[] = & $binds[$i];
        }

        $stmt = $this->mysql->prepare($query);

        if($bindsCount > 0) {
            call_user_func_array(array($stmt, 'bind_param'), $binds_a);
        }

        if($stmt->execute()) {
            if($output != null) {
                echo $output;
            }
            
            if($header != null) {
                header("Location: /".$header);
                exit();
            }
        } else {
            echo $stmt->error;
        }
    }
}
?>