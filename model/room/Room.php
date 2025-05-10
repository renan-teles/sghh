<?php

class Room {
    private int $id;
    private int $number;
    private int $type;
    private float $daily_price;
    private int $is_available;
    private int $capacity;
    private int $floor;

    public function __construct(int $number, int $type, int $capacity, float $daily_price, int $floor) {
        $this->number = $number;
        $this->type = $type;
        $this->capacity = $capacity;
        $this->daily_price = $daily_price;
        $this->floor = $floor;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNumber(): int {
        return $this->number;
    }

    public function setNumber(int $number): void {
        $this->number = $number;
    }

    public function getType(): int {
        return $this->type;
    }

    public function setType(int $type): void {
        $this->type = $type;
    }

    public function getDailyPrice(): float {
        return $this->daily_price;
    }

    public function setDailyPrice(float $daily_price): void {
        $this->daily_price = $daily_price;
    }

    public function isAvailable(): int {
        return $this->is_available;
    }

    public function setIsAvailable(int $is_available): void {
        $this->is_available = $is_available;
    }

    public function getCapacity(): int {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void {
        $this->capacity = $capacity;
    }

    public function getFloor(): int {
        return $this->floor;
    }

    public function setFloor(int $floor): void {
        $this->floor = $floor;
    }
}
