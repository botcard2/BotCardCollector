<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();   // parameters for view components
    protected $id;      // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();

        $this->data = array();
        $this->data['title'] = 'Bot'; // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    function render() {


        $this->data['teamname'] = '';
        $this->data['token'] = '';
        if ($this->session->userdata('teamname')) {
            if ($this->session->userdata('token')) {
                $this->data['teamname'] = $this->session->userdata('teamname');
                $this->data['token'] = $this->session->userdata('token');
            }
        }
        if (strcmp($this->input->post('connAgent'), 'connAgent') == 0) {

            $team = 'b08';
            $name = $this->session->userdata('username');
            $password = 'tuesday';
            $this->connAuth($team, $name, $password);
        }

        if (strcmp($this->input->post('toBuy'), 'toBuy') == 0) {
            $this->data['teamname'] = $this->session->userdata('teamname');
            $this->data['token'] = $this->session->userdata('token');
            $this->connBuy($this->data['teamname'], $this->data['token'], $this->session->userdata('username'));
        }


        if ($this->session->userdata('username')) {
            $this->data['loginname'] = $this->session->userdata('username');
            $logoutinfo = (string) $this->input->post('logout');
            $this->session->set_userdata(array('logout' => $logoutinfo));
            if (isset($_SESSION['logout'])) {
                if (strcmp($this->session->userdata['logout'], 'tologout') == 0) {
                    $this->session->unset_userdata('username');
                    $this->session->unset_userdata('logout');
                }
            }
        } else {
            $this->data['loginname'] = $this->input->post('username');
            $this->data['password'] = $this->input->post('password');
            $this->data['logout'] = $this->input->post('logout');
            $this->load->model('players');
            $validate = $this->players->verifyUser($this->data['loginname'], $this->data['password']);

            if (strcmp($this->data['logout'], 'tologout') == 0) {
                $this->session->unset_userdata('username');
                $this->session->unset_userdata('logout');
            } else {
                if ($validate) {
                    $this->session->set_userdata(array('username' => $this->data['loginname']));
                }
            }
        }
        if ($this->session->userdata('username')) {
            $this->data['login_part'] = $this->parser->parse('_logout', $this->data, true);
        } else {
            $this->data['login_part'] = $this->parser->parse('_login', $this->data, true);
        }

        //*************************************
        //export online csv to /data/series1.csv
        $this->connSeries();
        //export online csv to /data/certificate1.csv
        $this->connCertificates();
        //export online csv to /data/transaction1.csv
        $this->connTransactions();
        //****************************************
        $this->readSerieCsv();
        $this->readCertificateCsv();
        $this->readTransactionCsv();

        $this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'), true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    function endsession() {
        $this->session->sess_destroy();
    }

    //--------------------------- assignment 02--------------------------
    //connect to bcc/register
    function connAuth($team, $playername, $password) {
        // 'http://botcards.jlparry.com/register?team='
        $filename = BCCURL . 'register?team=' . $team . '&name=' . $playername . '&password=' . $password;
        $response = file_get_contents($filename);
        $this->getAuthentication($response);
        $this->agentInfo = $response;
    }

    //process input from bcc/register
    function getAuthentication($filename) {
        $this->load->model('agent');
        $table = new Agent($filename);
        $this->data['teamname'] = $table->getTeamname();
        $this->session->set_userdata(array('teamname' => $this->data['teamname']));
        $this->data['token'] = $table->getToken();
        $this->session->set_userdata(array('token' => $this->data['token']));
    }

    function connBuy($team, $token, $playername) {
        $this->load->model('players');
        //$peanuts = $this->players->getPeanuts($playername);
//        foreach ($peanuts as $row) {
//            print_r('current peanuts is ' . $row->peanuts);
//        }
        //'http://botcards.jlparry.com/buy?team='
        $filename = BCCURL . 'buy?team=' . $team . '&token=' . $token . '&player=' . $playername;
        $response = file_get_contents($filename);
        //print_r($response);
        $this->getPack($response);
        //$this->packInfo = $response;
    }

    //connect to bcc/status
    function connState() {
        $filename = BCCURL . 'status'; // 'http://botcards.jlparry.com/status';
        $response = file_get_contents($filename);
        $this->getState($response);
    }

    //http://botcards.jlparry.com/data/series
    //conn bcc/data/series
    function connSeries() {
        $filename = BCCURL . 'data/series'; // 'http://botcards.jlparry.com/data/series';
        $response = file_get_contents($filename);
        $this->outputSerieCSV($response);
    }

    //http://botcards.jlparry.com/data/certificates
    //conn bcc/data/certificates
    function connCertificates() {
        $filename = BCCURL . 'data/certificates'; // 'http://botcards.jlparry.com/data/certificates';
        $response = file_get_contents($filename);
        $this->outputCertificateCsv($response);
    }

    //http://botcards.jlparry.com/data/transactions
    //
    function connTransactions() {
        $filename = BCCURL . 'data/transactions'; // 'http://botcards.jlparry.com/data/transactions';
        $response = file_get_contents($filename);
        $this->outputTransactionCav($response);
    }

    function getPack($filename) {
        $this->load->model('cardpack');
        // print_r($filename);
        $table = new Cardpack($filename);
        $this->data['cardpack'] = $table->getCardpack();
        $this->data['balance'] = $table->getBalance();
        //update the balance in db
        $this->load->model('players');
        $this->players->updateBalance($this->session->userdata('username'), $this->data['balance']);
    }

    //process input from bcc/status
    function getState($filename) {
        $this->load->model('gamestate');
        $table = new GameState($filename);
        $this->data['bccRound'] = $table->getRound();
        $this->data['bccState'] = $table->getState(); // $this->CodeStateTrans($table->getState());
        $this->data['bccCountdown'] = $table->getCountdown();
        $this->data['bccDesc'] = $table->g();
    }

    //trans code to state description
    function CodeStateTrans($code) {
        if (strcmp($code, '0') == 0) {
            return 'closed';
        } else
        if (strcmp($code, '1') == 0) {
            return 'setup';
        }
    }

    /**
     *  outputCSV creates a line of CSV and outputs it to browser    
     */
    function outputSerieCSV($array) {
        file_put_contents(DATAPATH . 'series1.csv', $array);
        //$fp = fopen(DATAPATH.'series1.csv', 'w'); // this file actual writes to php outpu
        //fputcsv($fp, $array);
        //fclose($fp);
    }

    function outputCertificateCsv($array) {
        file_put_contents(DATAPATH . 'certificate1.csv', $array);
    }

    function outputTransactionCav($array) {
        file_put_contents(DATAPATH . 'transaction1.csv', $array);
    }

    function readCSV($csvFile) {
        $file_handle = fopen($csvFile, 'r') or die("Can't open the file");
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 1024, ",");
        }
        fclose($file_handle) or die("Can't close the file");
        return $line_of_text;
    }

    function readSerieCsv() {
        $csvFile = DATAPATH . 'series1.csv';
        $input = $this->readCSV($csvFile);
        $output = array();
        $output = $this->csvReader($input);
        $this->data['serie'] = $output;
    }

    function readCertificateCsv() {
        $csvFile = DATAPATH . 'certificate1.csv';
        $input = $this->readCSV($csvFile);
        // print_r($input);
        $output = array();
        $sortOutput = array();
        $output = $this->csvReader($input);


        $this->load->model('collections');
        $this->collections->truncate();
        foreach ($output as $row) {
            $this->collections->insertCertificate($row['token'], $row['piece'], $row['player'], $row['datetime']);
        }
        if ($this->session->userdata('username')) {
            foreach ($output as $row) {
                if (strcmp(strtolower($this->session->userdata('username')), $row['player']) == 0) {

                    $sortOutput[] = $row;
                }
            }
            $this->data['certificate'] = $sortOutput;
        } else {
            $this->data['certificate'] = $output;
        }
        //print_r($this->data['certificate']);
    }

    function readTransactionCsv() {
        $csvFile = DATAPATH . 'transaction1.csv';
        $input = $this->readCSV($csvFile);
        //print_r($input);
        $output = array();
        $sortOutput = array();
        $output = (array) $this->csvReader($input);
        //print_r($output);
        $this->load->model('transactions');
        $this->transactions->truncate();
        foreach ($output as $row) {
            $this->transactions->insertTransactions($row['datetime'], $row['player'], $row['series'], $row['trans']);
        }

        if ($this->session->userdata('username')) {
            foreach ($output as $row) {
                if (strcmp(strtolower($this->session->userdata('username')), $row['player']) == 0) {

                    $sortOutput[] = $row;
                }
            }
            $this->data['transaction'] = $sortOutput;
        } else {
            $this->data['transaction'] = $output;
        }
    }

    //input the data of array
    // first line suppose to be column name
    function csvReader($data) {
        if (empty($data)) {
            return 'no data';
        }

        $header = 1;
        $columnCount = 0;
        $columnname = array();
        $content = array();
        $output = array();
        //find out the column number and store in $columnCount
        //store rest data into $content
        foreach ($data as $elements) {
            $temp = array();
            if ($header == 1) {
                foreach ($elements as $element) {
                    $columnname[] = $element;
                    $columnCount++;
                }
                $header = 0;
            } else if (!empty($elements) && $header == 0) {
                foreach ($elements as $element) {
                    $temp[] = $element;
                }

                $content[] = $temp;
            }
        }
        // print_r($content);
        // process with one column
        if ($columnCount == 1) {
            foreach ($content as $elements) {
                $temp = array(
                    '' . $columnname[0] => $elements[0]
                );
            }
        }

        if ($columnCount == 4) {
            foreach ($content as $elements) {
                $line = array(
                    '' . $columnname[0] => $elements[0],
                    '' . $columnname[1] => $elements[1],
                    '' . $columnname[2] => $elements[2],
                    '' . $columnname[3] => $elements[3]
                );
                $output[] = $line;
                //print_r($output);
            }
        }
        //"token","piece","broker","player","datetime"
        if ($columnCount == 5) {
            foreach ($content as $elements) {
                $line = array(
                    '' . $columnname[0] => $elements[0],
                    '' . $columnname[1] => $elements[1],
                    '' . $columnname[2] => $elements[2],
                    '' . $columnname[3] => $elements[3],
                    '' . $columnname[4] => $elements[4]
                );
                $output[] = $line;
                //print_r($output);
            }
        }
//        if ($columnCount == 5) {
//            foreach ($content as $elements) {
//                $line = array(
//                    'token' => $elements[0],
//                    'piece' => $elements[1],
//                    'broker' => $elements[2],
//                    'player' => $elements[3],
//                    'datetime' => $this->toReadableDate($elements[4])
//                );
//                $output[] = $line;
//            }
//        }
        //"seq","datetime","broker","player","series","trans"
                if ($columnCount == 6) {
            foreach ($content as $elements) {
                $line = array(
                    '' . $columnname[0] => $elements[0],
                    '' . $columnname[1] => $elements[1],
                    '' . $columnname[2] => $elements[2],
                    '' . $columnname[3] => $elements[3],
                    '' . $columnname[4] => $elements[4],
                    '' . $columnname[5] => $elements[5]
                );
                $output[] = $line;
                //print_r($output);
            }
        }
//        if ($columnCount == 6) {
//            foreach ($content as $elements) {
//                $line = array(
//                    'seq' => $elements[0],
//                    'datetime' => $this->toReadableDate($elements[1]),
//                    'broker' => $elements[2],
//                    'player' => $elements[3],
//                    'series' => $elements[4],
//                    'trans' => $elements[5]
//                );
//                $output[] = $line;
//                //print_r($output);
//            }
//        }
        return $output;
    }

    function toReadableDate($inputDate) {
        return date('m/d/Y', $inputDate);
    }

}
