<?php

class AvailabilityRoom {
    private int $id;
    private string $availability;

    public function __construct(int $id, string $availability) {
        $this->id = $id;
        $this->availability = $availability;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getAvailability(): string {
        return $this->availability;
    }

    public function setAvailability(string $availability): void{
        $this->availability = $availability;
    }
}