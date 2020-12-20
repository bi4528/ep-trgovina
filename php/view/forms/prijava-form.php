<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';

class PrijavaForm extends HTML_QuickForm2 {
    
    public $email;
    public $geslo;
    
    public function __construct($id) {
        parent::__construct($id);
        
        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setAttribute('size', 20);
        $this->email->setLabel('Elektronski naslov:');
        $this->email->addRule('required', 'Vnesite email.');

        $this->geslo = new HTML_QuickForm2_Element_InputPassword('geslo');
        $this->geslo->setLabel('Izberite geslo:');
        $this->geslo->setAttribute('size', 20);
        $this->geslo->addRule('required', 'Vnesite geslo.');
        

        $this->gumb = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->gumb->setAttribute('value', 'Prijava');

        $this->fs = new HTML_QuickForm2_Container_Fieldset();
        $this->fs->setLabel('Prijava');
        $this->addElement($this->fs);
        $this->fs->addElement($this->email);
        $this->fs->addElement($this->geslo);
        $this->fs->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}