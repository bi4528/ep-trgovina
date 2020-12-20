<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';

class EditFormStranka extends HTML_QuickForm2 {
    
    public $ime;
    public $priimek;
    public $email;
    public $geslo;
    public $naslov;
    public $gumb;
    
    public function __construct($id) {
        parent::__construct($id);

        $this->ime = new HTML_QuickForm2_Element_InputText('ime');
        $this->ime->setAttribute('size', 20);
        $this->ime->setLabel('Ime:');
        $this->ime->addRule('required', 'Vnesite ime.');
        $this->ime->addRule('regex', 'Pri imenu uporabite le črke.', '/^[a-zA-ZšŠčČćĆžŽđĐ ]+$/');
        $this->ime->addRule('maxlength', 'Ime je predolgo.', 50);

        $this->priimek = new HTML_QuickForm2_Element_InputText('priimek');
        $this->priimek->setAttribute('size', 20);
        $this->priimek->setLabel('Priimek:');
        $this->priimek->addRule('required', 'Vnesite priimek.');
        $this->priimek->addRule('regex', 'Pri priimku uporabite le črke.', '/^[a-zA-ZšŠčČćĆžŽđĐ\- ]+$/');
        $this->priimek->addRule('maxlength', 'Priimek je predolg.', 50);

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setAttribute('size', 20);
        $this->email->setLabel('Elektronski naslov:');
        $this->email->addRule('required', 'Vnesite email.');
        $this->email->addRule('callback', 'Email ni veljaven.', array(
            'callback' => 'filter_var',
            'arguments' => [FILTER_VALIDATE_EMAIL])
        );

        $this->geslo = new HTML_QuickForm2_Element_InputPassword('geslo');
        $this->geslo->setLabel('Geslo:');
        $this->geslo->setAttribute('size', 20);
        $this->geslo->addRule('required', 'Vnesite geslo.');
        $this->geslo->addRule('minlength', 'Geslo naj vsebuje vsaj 6 znakov.', 6);  
        
        $this->naslov = new HTML_QuickForm2_Element_InputText('naslov');
        $this->naslov->setAttribute('size', 50);
        $this->naslov->setLabel('Naslov:');
        $this->naslov->addRule('required', 'Vnesite naslov.');
        $this->naslov->addRule('maxlength', 'Naslov je predolg.', 255);

        $this->gumb = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->gumb->setAttribute('value', 'Potrdi');

        $this->fs = new HTML_QuickForm2_Container_Fieldset();
        $this->fs->setLabel('Uredi profil');
        $this->addElement($this->fs);
        $this->fs->addElement($this->ime);
        $this->fs->addElement($this->priimek);
        $this->fs->addElement($this->naslov);
        $this->fs->addElement($this->email);
        
        $this->fs2 = new HTML_QuickForm2_Container_Fieldset();
        $this->fs2->setLabel('Za potrditev sprememb vnesite vaše geslo');
        $this->addElement($this->fs2);
        $this->fs2->addElement($this->geslo);
        $this->fs2->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}