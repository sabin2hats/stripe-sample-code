<?php
$this->view('template/header.php');
$this->view($data['body'], $data);
$this->view('template/footer.php');
