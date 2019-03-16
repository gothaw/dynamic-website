<?php

class Classes extends Database {

    private $_data;

    private function loadData($numberOfClasses) {

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
        $mysqli = $this->connectToDatabase();
        $result = $mysqli->query($sql);
        $numRows = $result->num_rows;
        if($numRows > 0){
            $classes = [];
            while($row = $result->fetch_assoc()){
                array_push($classes,$row);
            }
            $this->_data = $classes;
        }
    }

    public function getClassesDetails($numberOfClasses = NULL){
        $this->loadData($numberOfClasses);
        return $this->_data;
    }
}