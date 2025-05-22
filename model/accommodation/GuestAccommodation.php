<?php

class GuestAccommodation {
    private int $id;
    private array $cpf_guests;

    public function __construct(int $id, array $cpf_guests){
        $this->id = $id;
        $this->cpf_guests = $cpf_guests;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getCpfGuests(): array {
        return $this->cpf_guests;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setCpfGuests(array $cpf_guests): void {
        $this->cpf_guests = $cpf_guests;
    }
}