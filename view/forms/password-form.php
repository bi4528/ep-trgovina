<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';

class PasswordForm extends HTML_QuickForm2 {
    
    public $geslozdaj;
    public $geslo;
    public $geslo2;
    
    public function __construct($id) {
        parent::__construct($id);
        
        $this->geslozdaj = new HTML_QuickForm2_Element_InputPassword('geslozdaj');
        $this->geslozdaj->setLabel('Vnesite trenutno geslo:');
        $this->geslozdaj->setAttribute('size', 20);
        $this->geslozdaj->addRule('required', 'Vnesite geslo.');
        
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
        $this->gumb->setAttribute('value', 'Spremeni');

        $this->fs = new HTML_QuickForm2_Container_Fieldset();
        $this->fs->setLabel('Sremeni');
        $this->addElement($this->fs);
        $this->fs->addElement($this->geslozdaj);
        $this->fs->addElement($this->geslo);
        $this->fs->addElement($this->geslo2);
        $this->fs->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}