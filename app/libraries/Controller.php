<?php
//Load the model and the view
class Controller
{
    public function model($model)
    {
        //Require model file
        require_once 'app/models/' . $model . '.php';
        //Instantiate model
        return new $model();
    }

    //Load the view (checks for the file)
    public function view($view, $data = [])
    {
        if (file_exists('app/views/' . $view)) {
            require_once 'app/views/' . $view;
        } else {
            die("View does not exists.");
        }
    }

    public function redirect($url = null)
    {
        header("location: " . URLROOT . $url);
        // echo '<script>alert("in");window.location.href = URLROOT.$url  ';
    }
}
