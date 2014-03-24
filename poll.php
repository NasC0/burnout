<?php
require 'includes/functions.php';
include 'Classes/PHPExcel.php';

if(isset($_POST) && !empty($_POST)) {

    header("Location: index.php");

    $referer = $conn->real_escape_string($_POST['D12']);
    // First, insert the participant information into the database
    $insertParticipant = 'INSERT INTO participants (gender, age, housekeep, housekeep_count, education, location,
    income, occupation_type, income_scale, occupation, duration, reference)
                          VALUES ('. $_POST['D1'] .', '. $_POST['D2'] .', '. $_POST['D3'] .', '. $_POST['D4'] .',
                          '. $_POST['D5'] .', '. $_POST['D6'] .', '. $_POST['D7'] .', '. $_POST['D8'] .',
                          '. $_POST['D9'] .', '. $_POST['D10'] .', '. $_POST['D11']. ',
                          '. '"'. $referer . '"'. ')';

    $insertParticipantResult = $conn->query($insertParticipant);

    if($insertParticipantResult) {
        // If it's successful, retrieve the participant id, remove the already inserted demographic questions and insert the rest of the survey in the database
        $participantID = $conn->insert_id;
        $questionsArray = $_POST;

        for($i = 1; $i < 13; $i++) {
            $checkKey = 'D'.$i;
            if(array_key_exists($checkKey, $questionsArray)) {
                unset($questionsArray[$checkKey]);
            }
        }

        $stmt = $conn->prepare('INSERT INTO participants_answers_questions (participant_ID, question_ID, answer_ID) VALUES(?,?,?)');

        foreach ($questionsArray as $key => $val) {
            $key = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
//            $insertAnswers = 'INSERT INTO participants_answers_questions (participant_ID, question_ID, answer_ID) VALUES('. $participantID .', '. $key .', '. $val .')';
            $stmt->bind_param('iii', $participantID, $key, $val);
//            $result = $conn->query($insertAnswers);
            $stmt->execute();
        }

        // open up the excel file and start appending to it the participant's answers
        $worksheet = PHPExcel_IOFactory::load('../generated.xlsx');

        // Start from row one, and get the last inserted column in the worksheet
        $rowCount = 1;
        $column = $worksheet->getActiveSheet()->getHighestColumn();
        $column = PHPExcel_Cell::columnIndexFromString($column);
        $getParticipant = 'SELECT * FROM participants
                           WHERE participant_id = ' . $participantID .'';
        $result = $conn->query($getParticipant);
        $row = $result->fetch_array(MYSQLI_NUM);

        foreach ($row as $val) {
            $worksheet->getActiveSheet()->setCellValueByColumnAndRow($column, $rowCount, $val);
            $rowCount++;
        }

        $getQuestions = 'SELECT question_ID, answer_ID FROM participants_answers_questions
                         WHERE participant_id = '. $participantID .'
                         ORDER BY question_id ASC';

        $result = $conn->query($getQuestions);

        while($row = $result->fetch_assoc()) {
            $worksheet->getActiveSheet()->setCellValueByColumnAndRow($column, $rowCount, $row['answer_ID']);
            $rowCount++;
        }

        // lastly, append the new information to the existing excel file
        $worksheetWriter = new PHPExcel_Writer_Excel2007($worksheet);
        try {
            $worksheetWriter->save('../generated.xlsx');
        }
        catch (Exception $e) {
            delayXLSXSave($worksheetWriter);
        }
    }
}

$content = array();
$content['title'] = 'Подложени ли сте на burnout?';

$content['questions'] = fetchPoll('questions', $conn);

$content['answers'] = fetchPoll('answers', $conn);

$content['demographic'] = fetchPoll('demographic', $conn);

$content['demographicKeys'] = array_keys($content['demographic']);

$content['body'] = 'templates/poll_default.php';

renderHTML($content, 'templates/layout/default_layout.php');