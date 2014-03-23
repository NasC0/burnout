<?php
include 'dbConfig.php';

function renderHTML($content, $layout)
{
    include $layout;
}

function fetchPoll($table, $conn)
{
    $returnResult = false;
    $content = array();

    $query = 'SELECT * FROM `' . $table . '`';
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_array()) {
            $content[$row[0]] = $row[1];
        }
        $returnResult = $content;
    }
    return $returnResult;
}

function delayXLSXSave($writer)
{
    try {
        $writer->save('../generated.xlsx');

    }
    catch (Exception $e) {
        echo $e->getMessage();
        sleep(2);
        delayXLSXSave($writer);
    }
}