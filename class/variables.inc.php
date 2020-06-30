<?php

Class SQL extends Dbh {

    protected $sql;

    public function __construct($sql) {

        $this->sql = $sql;
    }

    public function getResultRowArray() {
        $resultset = array();
        $sql = $this->sql;
        //echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultset = $row;
            //echo "line 122 \$resultset from Line 118 \$smt->execute() of \$sql<br>";
            //echo "the array of sql reuslt : <br>";
            //  print_r($resultset);
            //echo "=========================<br>";
        } else {
            // do nothing;
            //echo "no result on SQL <br>";
        }

        return $resultset;
    }

    public function getResultOneRowArray() {
        $row = array();
        $sql = $this->sql;
        //echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        //echo "array \$row :<br>";
        //print_r($row);
        //echo "<br>";
        return $row;
    }

    public function getRowCount() {

        $sql = $this->sql;
        //echo "function getRowCount(), \$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);
        //echo "list down the content of \$stmt <br>";
        //print_r($stmt);
        echo "<br>";
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        // echo "\$number_of_rows =  $number_of_rows <br>";
        return $number_of_rows;
    }

    public function getUpdate() {

        $sql = $this->sql;
        //echo "Line 165 , in getUpdate function of Class SQL,  \$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) {
            $result = 'updated';
        } else {
            $result = 'update fail';
        }
        return $result;
    }

    public function InsertData() {

        $sql = $this->sql;
        //echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) {
            $result = 'insert ok!';
        } else {
            $result = 'insert fail';
        }
        echo "\$result = $result <br>";
        return $result;
    }

    public function getDelete() {

        $sql = $this->sql;
        //echo "Line 192 , in getDelete function of Class SQL,  \$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) {
            $result = 'deleted';
        } else {
            $result = 'delete fail';
        }
        return $result;
    }

    public function __destruct() {
        //echo "The object instance for SQL Class was destructed<br>";
    }

}

Class SQLBINDPARAM extends SQL {

    protected $sql;
    protected $bindparamArray;

    public function __construct($sql, $bindparamArray) {

        parent::__construct($sql);
        $this->bindparamArray = $bindparamArray;
    }

    public function InsertData2() {
        //echo "in the function of InsertData2() of the Class SQLBINDPARAM <br>";
        $sql = $this->sql;
        //echo $sql . "<bR>";
        $stmt = $this->connect()->prepare($sql);
        $bindparamArray = $this->bindparamArray;
//        unset($bindparamArray['submit']);
        print_r($bindparamArray);
        echo "<br>";
//        $para = "";
        $count = 0;
        foreach ($bindparamArray as $key => $value) {
            # code...
            ${$key} = $value;
            $bindValue = $key;
            //$bindParamdata = "bindParam(:{$bindValue}, $$bindValue) == ".$$bindValue; //this is for debugging purposes
            #echo "\$bindParamdata = $bindParamdata <br>";
            #########################################################
            # this line not successful, how to check in the future
            //  $stmt->bindParam(":$key", $value);
            ##########################################################
            # this line is working,                                  #
            # {$bindValue} = calls the $key value                    #
            # $$bindValue = calls the value contained by $key array  #
            ##########################################################
            $count++;
            $stmt->bindParam(":{$bindValue}", $$bindValue);
//            echo "$count ".":{$key}".",".$value."<br>";
//            $stmt->bindParam(":{$key}",$value);
//            print_r($stmt);
            //echo "<br>";
        }

//        echo "=====var_dump \$stmt==================<br>";
//        var_dump($stmt);
//        echo "=====end of var_dump \$stmt==================<br>";
        if ($stmt->execute()) {
            echo "dump \$stmt :";
            print_r($stmt);
            echo "<br>";
            $result = 'insert ok!';
        } else {
            $result = 'insert fail';
        }
        return $result;
    }

    public function UpdateData2() {

        $sql = $this->sql;
        #echo $sql."<bR>";
        $stmt = $this->connect()->prepare($sql);
        $bindparamArray = $this->bindparamArray;
//        unset($bindparamArray['submit']);
//        print_r($bindparamArray);
//        echo "<br>";
//        $para = "";

        foreach ($bindparamArray as $key => $value) {
            # code...
            ${$key} = $value;
            $bindValue = $key;
            $bindParamdata = "bindParam(:{$bindValue}, $$bindValue) == " . $$bindValue; //this is for debugging purposes
            debug_to_console($bindParamdata);
            #echo "\$bindParamdata = $bindParamdata <br>";
            #########################################################
            # this line not successful, how to check in the future
            //  $stmt->bindParam(":$key", $value);
            ##########################################################
//          # this line is working,                                  #
            # {$bindValue} = calls the $key value                    #
            # $$bindValue = calls the value contained by $key array  #
            ##########################################################

            $stmt->bindParam(":{$bindValue}", $$bindValue);
        }

//        echo "=====var_dump \$stmt==================<br>";
//        var_dump($stmt);
//        echo "=====end of var_dump \$stmt==================<br>";


        if ($stmt->execute()) {
            $result = 'Update ok!';
        } else {
            $result = 'Update fail';
        }
        return $result;
    }

}

Class Screen extends SQL {

    protected $sql;
    protected $pagelimit;

    public function __construct($sql, $pagelimit) {

        $this->sql = $sql;
        $this->pagelimit = $pagelimit;
        // echo "\$pagelimit = $pagelimit<br>";
    }

    public function splitOnePageToMultiplePage() {
        $returnArray = array();
        $sql = $this->sql;
        $pagelimit = $this->pagelimit;
        //echo "\$pagelimit = $pagelimit   in function splitOnePageToMultiplePage() <br>";
        $objSQLlive = new SQL($sql);
        $total = $objSQLlive->getRowCount();
        // echo "\$total = $total <br>";
//            array_push($returnArray, $total);
        $returnArray['total'] = $total;
        // How many items to list per page
        ## $pagelimit;
        // How many pages will there be
        $pages = ceil($total / $pagelimit);
        //echo "\$pages = $pages   in function splitOnePageToMultiplePage() <br>";
//        array_push($returnArray, $pages);
        $returnArray['pages'] = $pages;

        // What page are we currently on?
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default' => 1,
                'min_range' => 1,
            ),
        )));
        //echo "\$page = $page   in function splitOnePageToMultiplePage() <br>";
        // Calculate the offset for the query
        $offset = ($page - 1) * $pagelimit;
        //echo "\$offset = $offset   in function splitOnePageToMultiplePage() <br>";
//    array_push($returnArray, $offset);
        $returnArray['offset'] = $offset;

        // Some information to display to the user
        $start = $offset + 1;
        $end = min(($offset + $pagelimit), $total);
//    array_push($returnArray, $start, $end);
        $returnArray['start'] = $start;
        $returnArray['end'] = $end;
        $resultArray['$pagelimit'] = $pagelimit;

        // The "back" link
        $link = "http://localhost/php7-phhsystem/invoicedo/getlandingpage.php";
        $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> '
                . '<a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;'
                . '</a>' : '<span class="disabled">&laquo;</span> '
                . '<span class="disabled">&lsaquo;</span>';

        // The "forward" link
        $nextlink = $nextlink = ($page < $pages) ? '<a href="' . $link . '?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
        $Displayresult = '';
        // Display the paging information
        //echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
        $Displayresult .= '<div id="paging"><p>';
        $Displayresult .= $prevlink;
        $Displayresult .= ' Page ';
        $Displayresult .= $page;
        $Displayresult .= ' of ';
        $Displayresult .= $pages . ' pages, displaying ';
        $Displayresult .= $start . '-' . $end . ' of ' . $total . ' results ' . $nextlink . ' </p></div>';
//    array_push($returnArray, $Displayresult);
        $returnArray['Displayresult'] = $Displayresult;
        return $returnArray;
    }

    public function splitOnePageToMultiplePage2() {
        $returnArray = array();
        $sql = $this->sql;
        $pagelimit = $this->pagelimit;
        //echo "\$pagelimit = $pagelimit   in function splitOnePageToMultiplePage() <br>";
        $objSQLlive = new SQL($sql);
        $total = $objSQLlive->getRowCount();
        // echo "\$total = $total <br>";
//            array_push($returnArray, $total);
        $returnArray['total'] = $total;
        // How many items to list per page
        ## $pagelimit;
        // How many pages will there be
        $pages = ceil($total / $pagelimit);
        //echo "\$pages = $pages   in function splitOnePageToMultiplePage() <br>";
//        array_push($returnArray, $pages);
        $returnArray['pages'] = $pages;

        // What page are we currently on?
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default' => 1,
                'min_range' => 1,
            ),
        )));
        //echo "\$page = $page   in function splitOnePageToMultiplePage() <br>";
        // Calculate the offset for the query
        $offset = ($page - 1) * $pagelimit;
        //echo "\$offset = $offset   in function splitOnePageToMultiplePage() <br>";
//    array_push($returnArray, $offset);
        $returnArray['offset'] = $offset;

        // Some information to display to the user
        $start = $offset + 1;
        $end = min(($offset + $pagelimit), $total);
//    array_push($returnArray, $start, $end);
        $returnArray['start'] = $start;
        $returnArray['end'] = $end;
        $resultArray['$pagelimit'] = $pagelimit;

        // The "back" link
        $link = "http://localhost/php7-phhsystem/adminlogs/adminlivelogs.php";
        $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> '
                . '<a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;'
                . '</a>' : '<span class="disabled">&laquo;</span> '
                . '<span class="disabled">&lsaquo;</span>';

        // The "forward" link
        $nextlink = ($page < $pages) ? '<a href="' . $link . '?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> '
                . '<a href="?page=' . ($page + 1) . '" title="Last page">&raquo;'
                . '</a>' : '<span class="disabled">&rsaquo;</span> '
                . '<span class="disabled">&raquo;</span>';
        // $nextlink =  ($page < $pages) ? '<a href="'.$link.'?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
        $Displayresult = '';
        // Display the paging information
        //echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
        $Displayresult .= '<div id="paging"><p>';
        $Displayresult .= $prevlink;
        $Displayresult .= ' Page ';
        $Displayresult .= $page;
        $Displayresult .= ' of ';
        $Displayresult .= $pages . ' pages, displaying ';
        $Displayresult .= $start . '-' . $end . ' of ' . $total . ' results ' . $nextlink . ' </p></div>';
//    array_push($returnArray, $Displayresult);
        $returnArray['Displayresult'] = $Displayresult;
        return $returnArray;
    }

    //<div id="paging"><p><span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span> Page 1 of 57042 pages, displaying 1-15 of 855623 results <a href="?page=2" title="Next page">&rsaquo;</a> <a href="?page=57042" title="Last page">&raquo;</a> </p></div>
    public function splitOnePageToMultiplePage3() {
        $returnArray = array();
        $sql = $this->sql;
        $pagelimit = $this->pagelimit;
        //echo "\$pagelimit = $pagelimit   in function splitOnePageToMultiplePage() <br>";
        $objSQLlive = new SQL($sql);
        $total = $objSQLlive->getRowCount();
        // echo "\$total = $total <br>";
//            array_push($returnArray, $total);
        $returnArray['total'] = $total;
        // How many items to list per page
        ## $pagelimit;
        // How many pages will there be
        $pages = ceil($total / $pagelimit);
        //echo "\$pages = $pages   in function splitOnePageToMultiplePage() <br>";
//        array_push($returnArray, $pages);
        $returnArray['pages'] = $pages;

        // What page are we currently on?
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default' => 1,
                'min_range' => 1,
            ),
        )));
        //echo "\$page = $page   in function splitOnePageToMultiplePage() <br>";
        // Calculate the offset for the query
        $offset = ($page - 1) * $pagelimit;
        //echo "\$offset = $offset   in function splitOnePageToMultiplePage() <br>";
//    array_push($returnArray, $offset);
        $returnArray['offset'] = $offset;

        // Some information to display to the user
        $start = $offset + 1;
        $end = min(($offset + $pagelimit), $total);
//    array_push($returnArray, $start, $end);
        $returnArray['start'] = $start;
        $returnArray['end'] = $end;
        $resultArray['$pagelimit'] = $pagelimit;

        // The "back" link
        $link = "http://localhost/php7-phhsystem/invoicedo/sdo-getlandingpage.php";
        $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> '
                . '<a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;'
                . '</a>' : '<span class="disabled">&laquo;</span> '
                . '<span class="disabled">&lsaquo;</span>';

        // The "forward" link
        $nextlink = $nextlink = ($page < $pages) ? '<a href="' . $link . '?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
        $Displayresult = '';
        // Display the paging information
        //echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
        $Displayresult .= '<div id="paging"><p>';
        $Displayresult .= $prevlink;
        $Displayresult .= ' Page ';
        $Displayresult .= $page;
        $Displayresult .= ' of ';
        $Displayresult .= $pages . ' pages, displaying ';
        $Displayresult .= $start . '-' . $end . ' of ' . $total . ' results ' . $nextlink . ' </p></div>';
//    array_push($returnArray, $Displayresult);
        $returnArray['Displayresult'] = $Displayresult;
        return $returnArray;
    }

}
