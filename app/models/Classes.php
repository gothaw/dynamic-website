<?php

class Classes {

    private $_data;

    private function loadData($numberOfClasses) {
        $database = Database::getInstance();
        if(isset($numberOfClasses)){
            $sql = "
                SELECT 
                    `cl_name`,
                    `cl_desc`,
                    `cl_img_url`,
                    `cl_img_alt`
                FROM 
                    `class` INNER JOIN `class_image`
                ON
                    `class`.`cl_img_id` = `class_image`.`cl_img_id`
                ORDER BY 
                    `cl_id`
                ASC 
                LIMIT $numberOfClasses;
                ";
        }
        else{
            $sql = "
                SELECT 
                    `cl_name`,
                    `cl_desc`,
                    `cl_img_url`,
                    `cl_img_alt`
                FROM 
                    `class` INNER JOIN `class_image`
                ON
                    `class`.`cl_img_id` = `class_image`.`cl_img_id`
                ORDER BY 
                    `cl_id`
                ASC;
                ";
        }
        $this->_data = $database->query($sql)->getResult();
    }

    public function getClassesDetails($numberOfClasses = NULL){
        $this->loadData($numberOfClasses);
        return $this->_data;
    }
}