<?php
class Pdf {
    private ?int $id_pdf;
    private string $titre;
    private string $url;
    private string $Type; 
    private string $description_P; 
    private int $id_category; // clé étrangère



    // Constructeur sans l'ID car il sera généré par la base de données
    public function __construct(string $titre,string $Type, string $url, string $description_P, int $id_category, ?int $id_pdf = null) {
        $this->id_pdf = $id_pdf;
        $this->titre = $titre;
        $this->url = $url;
        $this->Type = $Type;
        $this->description_P = $description_P;
        $this->id_category = $id_category;


    }

    // Getters
    public function getIdPdf(): ?int {
        return $this->id_pdf;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getType(): string {
        return $this->Type;
    }

    public function getdescription_P(): string {
        return $this->description_P;
    }

    public function getIdCategory(): int {
        return $this->id_category;
    }
    // Setters
    public function setIdPdf(int $id_pdf): void {
        $this->id_pdf = $id_pdf;
    }

    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setUrl(string $url): void {
        $this->url = $url;
    }
    public function setType(string $Type): void {
        $this->Type = $Type;
    }
    public function setdescription_P(string $description_P): void {
        $this->description_P = $description_P;
    }

    public function setIdCategory(int $id_category): void {
        $this->id_category = $id_category;
    }
}

?>
