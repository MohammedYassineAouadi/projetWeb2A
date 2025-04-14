<?php
class Video {
    private ?int $id_video;
    private string $titre;
    private string $description;
    private string $url;
    private string $duree;
    private string $date_ajout;
    private int $id_pdf; // clé étrangère

    // Constructeur sans l'ID car il est généré par la base de données
    public function __construct(string $titre, string $description, string $url, string $duree, string $date_ajout, int $id_pdf, ?int $id_video = null) {
        $this->id_video = $id_video;
        $this->titre = $titre;
        $this->description = $description;
        $this->url = $url;
        $this->duree = $duree;
        $this->date_ajout = $date_ajout;
        $this->id_pdf = $id_pdf;
    }

    // Getters
    public function getIdVideo(): ?int {
        return $this->id_video;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getDuree(): string {
        return $this->duree;
    }

    public function getDateAjout(): string {
        return $this->date_ajout;
    }

    public function getIdPdf(): int {
        return $this->id_pdf;
    }

    // Setters
    public function setIdVideo(int $id_video): void {
        $this->id_video = $id_video;
    }

    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setUrl(string $url): void {
        $this->url = $url;
    }

    public function setDuree(string $duree): void {
        $this->duree = $duree;
    }

    public function setDateAjout(string $date_ajout): void {
        $this->date_ajout = $date_ajout;
    }

    public function setIdPdf(int $id_pdf): void {
        $this->id_pdf = $id_pdf;
    }
}
?>
