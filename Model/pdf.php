<?php
class Pdf {
    private ?int $id_pdf;
    private string $titre;
    private string $url;
    private string $Type; 

    // Constructeur sans l'ID car il sera généré par la base de données
    public function __construct(string $titre,string $Type, string $url, ?int $id_pdf = null) {
        $this->id_pdf = $id_pdf;
        $this->titre = $titre;
        $this->url = $url;
        $this->Type = $Type;
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
}

?>
