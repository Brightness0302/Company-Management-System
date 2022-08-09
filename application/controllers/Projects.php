<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

    // index view web
    public function index()
    {
        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('session');

        $this->checklanguage();
        $data['title'] = 'Protoarch';

        $this->load->view('templates/home_header', $data);
        $this->load->view('projects/head');
        $this->load->view('custom/sidebar');
        $this->load->view('projects/index');
        $this->load->view('details/foot', $data);
    }

    public function checklanguage() 
    {
        $val=$this->session->userdata('language');
        $this->session->set_userdata('page','projects');
        if (!$val)
            $this->language_HR();
    }

    public function show($text)
    {
        $this->load->model('projects_model', 'projects');
        $this->session->set_userdata("where","`projects`.`$text`=1");

        $projects=$this->projects->allprojectsfromType($text);
        $this->displayallprojects($projects);
    }

    public function category($text)
    {
        $this->load->model('projects_model', 'projects');
        $this->session->set_userdata("where","`projects`.`category`='$text'");

        $projects=$this->projects->allprojectsfromCategory($text);
    
        $this->displayallprojects($projects);
    }

    public function listprojects()
    {
        $this->load->model('projects_model', 'projects');
        $this->session->set_userdata("where","");

        $projects=$this->projects->allprojects();
        $this->displayallprojects($projects);
    }

    public function displayallprojects($projects)
    {
        $this->checklanguage();

        $data['title'] = 'Protoarch';
        $data['language']['english']=$this->lang->load('proj','english',true);
        $data['language']['croatian']=$this->lang->load('proj','croatian',true);

        $files=[];

        for ($i=0;$i<count($projects);$i++) {
            $path = 'assets/projects/'.$projects[$i]['id'].'/';
            foreach (glob($path."*.*") as $file) {
                array_push($files,$file);
                break;
            }
        }
        $projects['projects'] = $projects;
        $projects['files']=$files;

        $this->load->view('templates/home_header');
        $this->load->view('projects/head');
        $this->load->view('custom/sidebar' ,$data);
        $this->load->view('projects/index' ,$projects);
        $this->load->view('details/foot');
    }

    public function details($id)
    {
        $this->checklanguage();
        
        if ($id==''||$id==null)
            return;
        $this->load->model('projects_model', 'projects');
        $projects = $this->projects->projectsfromcategory($id);
        if(is_null($projects)||$projects==NULL) {
            redirect(base_url()."details/0");
        }
        $prev = $this->projects->prevprojectsNamefromcategory($id);
        $next = $this->projects->nextprojectsNamefromcategory($id);

        if(is_null($prev)||$prev==NULL) {
            $prev = $this->projects->lastprojectsNamefromcategory();
        }

        if(is_null($next)||$next==NULL) {
            $next = $this->projects->firstprojectsNamefromcategory();
        }

        $path = 'assets/projects/'.$projects[0]['id'].'/';

        $testimages=[];
        foreach (glob($path."*.*") as $file) {
            array_push($testimages,$file);
        }

        $files=[];
        $imgorder=$projects[0]['imgorder'];
        $imgorder=explode(",", $imgorder);
        $imgorder = array_filter($imgorder, function($v){ 
            return !is_null($v) && $v !== ''; 
        });
        for ($i=0;$i<count($imgorder);$i++) {
            $c = ($imgorder[$i]-1);
            array_push($files ,$testimages[$c]);
        }

        //$this->session->set_userdata('language','croatian');
        // $language=$this->session->userdata('language');

        $data['title'] = 'Protoarch';
        $data['projects'] = $projects[0];
        $data['prev'] = $prev[0];
        $data['next'] = $next[0];
        $data['files'] = $files;
        $data['language']['english']=$this->lang->load('proj','english',true);
        $data['language']['croatian']=$this->lang->load('proj','croatian',true);

        $this->load->view('templates/home_header', $data);
        $this->load->view('details/head');
        $this->load->view('custom/sidebar', $data);
        $this->load->view('details/index');
        $this->load->view('details/foot', $data);
    }

    public function clickstudio()
    {
        $this->checklanguage();
        $this->load->model('projects_model', 'projects');
        $studio['studio'] = $this->projects->allstudio();
        $studio['employees'] = $this->projects->allemployee();
        $studio['backgrounds'] = $this->projects->allbackground();

        $data['title'] = 'Protoarch';
        $data['language']['english']=$this->lang->load('proj','english',true);
        $data['language']['croatian']=$this->lang->load('proj','croatian',true);

        $data['teaminfo']['croatian'] = json_decode(file_get_contents('assets/json/croatian.json'), true);
        $data['teaminfo']['english'] = json_decode(file_get_contents('assets/json/english.json'), true);

        $this->load->view('templates/home_header', $data);
        $this->load->view('projects/head');
        $this->load->view('custom/sidebar', $data);
        $this->load->view('studio/index', $studio);
        $this->load->view('details/foot', $data);
    }

    public function getlanguage() {
        $lang=$this->session->userdata('language');
        if ($lang=="croatian")
            return "hr";
        else if ($lang=="english")
            return "en";
        return "en";
    }

    public function language_HR() {
        $this->session->set_userdata('language','croatian');
        // echo $this->session->userdata('language');
    }

    public function language_EN() {
        $this->session->set_userdata('language','english');
        // echo $this->session->userdata('language');
    }
}