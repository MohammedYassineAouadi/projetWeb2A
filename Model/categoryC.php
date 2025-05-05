<?php

class Category {
    private $id_category;
    private $nomC;

    // Constructeur
    public function __construct($nomC = null, $id_category = null) {
        $this->nomC = $nomC;
        $this->id_category = $id_category;
    }

    // Getters
    public function getIdCategory() {
        return $this->id_category;
    }

    public function getNomC() {
        return $this->nomC;
    }

    // Setters
    public function setIdCategory($id_category) {
        $this->id_category = $id_category;
    }

    public function setNomC($nomC) {
        $this->nomC = $nomC;
    }
}
