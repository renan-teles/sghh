<?php

class GuestAccommodation {
    private int $id;
    private int $id_accommodation;
    private array $cpf_guests;

    public function __construct(int $id, int $id_accommodation, array $cpf_guests){
        $this->id = $id;
        $this->id_accommodation = $id_accommodation;
        $this->cpf_guests = $cpf_guests;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getIdAccommodation(): int {
        return $this->id_accommodation;
    }

    public function getCpfGuests(): array {
        return $this->cpf_guests;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setIdAccommodation(int $id_accommodation): void {
        $this->id_accommodation = $id_accommodation;
    }

    public function setCpfGuests(array $cpf_guests): void {
        $this->cpf_guests = $cpf_guests;
    }
}