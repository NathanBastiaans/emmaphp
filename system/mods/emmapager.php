<?php

/**
 * @author Thies Verhave
 * Instructions on http://bobdesaunois.github.io/emmaphp/
 */

class EmmaPager {
    
    function getPage ($table, $order = "id", $ascdesc, $start = 0, $limit) {
        
        $db = Loader::$database;
        
        $page = $start * $limit;
        
        $sql = "SELECT *
                FROM $table
                ORDER BY $order
                $ascdesc
                LIMIT $page, $limit";
        
        
        $stmt = $db->connection->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $dataObjects = array ();
            foreach ($result as $results)
                array_push ($dataObjects, DataObject::getInstance ($results));

            return $result ? $dataObjects : false;
        
    }
    
    function getNext ($page, $max, $limit){
        
        if($page * $limit + $limit >= $max){
            $result = $page;
        }else{
            $result = $page + 1;
        }
        
        return $result;
        
    }
    
    function getPrevious ($page){
        
        if($page <= 0){
            $result = $page;
        }else{
            $result = $page - 1;
        }
        
        return $result;
        
    }
    
}
