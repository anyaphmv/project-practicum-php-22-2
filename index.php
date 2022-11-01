<?php
class FormFeedback {
    public $firstname;
    public $lastname;
    private $phone;
    private $email;
    public $text;

    public function __construct($firstname, $lastname, $phone, $email, $text)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->email = $email;
        $this->text = $text;
    }
    public function EnterData()
    {
        return;
    }
}

class SendData extends FormFeedback{

    public function getData()
    {
        return;
    }
}