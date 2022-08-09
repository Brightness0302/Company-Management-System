<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends CI_Model {

    public function getSubMenu()
    {
        $query =    "SELECT *
                    FROM `projects`";

        return $this->db->query($query)->result_array();
    }
    
    public function allprojects()
    {
        $where=$this->session->userdata("where");
        if ($where!=''||$where!=null)
            $where=" WHERE ".$where;

        $query =    "SELECT `projects`.*, `projects_gallery`.`id` as `gid`, `projects_gallery`.`name` as `gname`, `projects_gallery`.`type` as `gtype`
                    FROM `projects` JOIN `projects_gallery` ON `projects`.`id`=`projects_gallery`.`project_id`
                    ".$where;

        return $this->db->query($query)->result_array();
    }
    
    public function allprojectsfromType($type)
    {
        $query =    "SELECT `projects`.*, `projects_gallery`.`id` as `gid`, `projects_gallery`.`name` as `gname`, `projects_gallery`.`type` as `gtype`
                    FROM `projects` JOIN `projects_gallery` ON `projects`.`id`=`projects_gallery`.`project_id`
                    WHERE ".$this->session->userdata("where");

        return $this->db->query($query)->result_array();
    }
    
    public function allprojectsfromCategory($category)
    {
        $query =    "SELECT `projects`.*, `projects_gallery`.`id` as `gid`, `projects_gallery`.`name` as `gname`, `projects_gallery`.`type` as `gtype`
                    FROM `projects` JOIN `projects_gallery` ON `projects`.`id`=`projects_gallery`.`project_id`
                    WHERE ".$this->session->userdata("where");

        return $this->db->query($query)->result_array();
    }
    
    public function countprojects()
    {
        $query =    "SELECT count(*) as `count`
                    FROM `projects` JOIN `projects_gallery` ON `projects`.`id`=`projects_gallery`.`project_id`";

        return $this->db->query($query)->result_array();
    }

    public function projectsfromcategory($id)
    {
        $query =    "SELECT `projects`.*, `projects_gallery`.`id` as `gid`, `projects_gallery`.`name` as `gname`, `projects_gallery`.`type` as `gtype`
                    FROM `projects` JOIN `projects_gallery` ON `projects`.`id`=`projects_gallery`.`project_id`
                    WHERE `projects`.`id`=$id";

        return $this->db->query($query)->result_array();
    }

    public function prevprojectsNamefromcategory($id)
    {
        $where=$this->session->userdata("where");
        if ($where!=''||$where!=null)
            $where=" AND ".$where;
        $query = $this->db->query("SELECT `id`,`name`,`ename` FROM `projects` WHERE `id`<'$id' ".$where." ORDER BY `id` DESC LIMIT 1");
        return $query->result_array();
    }

    public function nextprojectsNamefromcategory($id)
    {
        $where=$this->session->userdata("where");
        if ($where!=''||$where!=null)
            $where=" AND ".$where;
        $query = $this->db->query("SELECT `id`,`name`,`ename` FROM `projects` WHERE `id`>'$id' ".$where." ORDER BY `id` ASC LIMIT 1");
        return $query->result_array();
    }

    public function lastprojectsNamefromcategory()
    {
        $where=$this->session->userdata("where");
        if ($where!=''||$where!=null)
            $where=" WHERE ".$where;
        $query = $this->db->query("SELECT `id`,`name`,`ename` FROM `projects` ".$where." ORDER BY `id` DESC LIMIT 1");
        return $query->result_array();
    }

    public function firstprojectsNamefromcategory()
    {
        $where=$this->session->userdata("where");
        if ($where!=''||$where!=null)
            $where=" WHERE ".$where;
        $query = $this->db->query("SELECT `id`,`name`,`ename` FROM `projects` ".$where." ORDER BY `id` ASC LIMIT 1");
        return $query->result_array();
    }

    public function allstudio()
    {
        $query =    "SELECT * FROM `studio_timeline` ORDER BY `year` DESC";

        return $this->db->query($query)->result_array();
    }

    public function studiofromid($id)
    {
        $query =    "SELECT * FROM `studio_timeline`
                    WHERE `id`=$id";

        return $this->db->query($query)->result_array();
    }

    public function allemployee()
    {
        $query =    "SELECT * FROM `studio_employee`";

        return $this->db->query($query)->result_array();
    }

    public function employeefromid($id)
    {
        $query =    "SELECT * FROM `studio_employee`
                    WHERE `id`=$id";

        return $this->db->query($query)->result_array();
    }

    public function allbackground()
    {
        $query =    "SELECT * FROM `studio_background`";

        return $this->db->query($query)->result_array();
    }

    public function backgroundfromid($id)
    {
        $query =    "SELECT * FROM `studio_background`
                    WHERE `id`=$id";

        return $this->db->query($query)->result_array();
    }
}