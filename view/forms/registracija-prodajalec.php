<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';

class RegistracijaFormProdajalec extends HTML_QuickForm2 {
    
    public $ime;
    public $priimek;
    public $email;
    public $geslo;
    public $geslo2;
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
        $this->geslo->setLabel('Izberite geslo:');
        $this->geslo->setAttribute('size', 20);
        $this->geslo->addRule('required', 'Vnesite geslo.');
        $this->geslo->addRule('minlength', 'Geslo naj vsebuje vsaj 6 znakov.', 6);
        $this->geslo->addRule('regex', 'Geslo naj vsebuje vsaj 1 številko.', '/[0-9]+/');
        $this->geslo->addRule('regex', 'Geslo naj vsebuje vsaj 1 veliko črko.', '/[A-Z]+/');
        $this->geslo->addRule('regex', 'Geslo naj vsebuje vsaj 1 malo črko.', '/[a-z]+/');

        $this->geslo2 = new HTML_QuickForm2_Element_InputPassword('geslo2');
        $this->geslo2->setLabel('Ponovite geslo:');
        $this->geslo2->setAttribute('size', 20);
        $this->geslo2->addRule('required', 'Ponovno vpišite izbrano geslo.');
        $this->geslo2->addRule('eq', 'Gesli nista enaki.', $this->geslo);        

        $this->gumb = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->gumb->setAttribute('value', 'Registracija');

        $this->fs = new HTML_QuickForm2_Container_Fieldset();
        $this->fs->setLabel('Registracija novega prodajalca');
        $this->addElement($this->fs);
        $this->fs->addElement($this->ime);
        $this->fs->addElement($this->priimek);
        $this->fs->addElement($this->email);
        $this->fs->addElement($this->geslo);
        $this->fs->addElement($this->geslo2);
        $this->fs->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}