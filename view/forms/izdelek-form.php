<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';

class IzdelekForm extends HTML_QuickForm2 {
    
    public $ime;
    public $opis;
    public $cena;
    public $gumb;
    
    public function __construct($id) {
        parent::__construct($id);

        $this->ime = new HTML_QuickForm2_Element_InputText('ime');
        $this->ime->setAttribute('size', 20);
        $this->ime->setLabel('Ime:');
        $this->ime->addRule('required', 'Vnesite ime.');
        $this->ime->addRule('regex', 'Pri imenu uporabite le črke.', '/^[a-zA-ZšŠčČćĆžŽđĐ ]+$/');
        $this->ime->addRule('maxlength', 'Ime je predolgo.', 50);

        $this->opis = new HTML_QuickForm2_Element_TextArea('opis');
        $this->opis->setAttribute('size', 50);
        $this->opis->setLabel('Opis:');
        $this->opis->addRule('required', 'Vnesite opis.');
        $this->opis->addRule('regex', 'Pri opisu uporabite le črke.', '/^[a-zA-ZšŠčČćĆžŽđĐ\- ]+$/');
        $this->opis->addRule('maxlength', 'Opis je predolg.', 500);

        $this->cena = new HTML_QuickForm2_Element_InputText('cena');
        $this->cena->setLabel('Izberite ceno:');
        $this->cena->setAttribute('size', 20);
        $this->cena->addRule('required', 'Vnesite ceno.');
        $this->cena->addRule('regex', 'Vnos ni pravilen.', '/^[0-9]+(\.[0-9]{1,2})?$/');    

        $this->gumb = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->gumb->setAttribute('value', 'Dodaj');

        $this->fs = new HTML_QuickForm2_Container_Fieldset();
        $this->fs->setLabel('Izdelek');
        $this->addElement($this->fs);
        $this->fs->addElement($this->ime);
        $this->fs->addElement($this->opis);
        $this->fs->addElement($this->cena);
        $this->fs->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}