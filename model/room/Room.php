<?php

class Room {
    private int $id;
    private int $number;
    private TypeRoom $type;
    private float $daily_price;
    private AvailabilityRoom $availability;
    private int $capacity;
    private int $floor;

    public function __construct(int $id, int $number, TypeRoom $type, float $daily_price, AvailabilityRoom $availability, int $capacity, int $floor) {
        $this->id = $id;
        $this->number = $number;
        $this->type = $type;
        $this->daily_price = $daily_price;
        $this->availability = $availability;
        $this->capacity = $capacity;
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

    public function getType(): TypeRoom {
        return $this->type;
    }

    public function setType(TypeRoom $type): void {
        $this->type = $type;
    }

    public function getDailyPrice(): float {
        return $this->daily_price;
    }

    public function setDailyPrice(float $daily_price): void {
        $this->daily_price = $daily_price;
    }

    public function getAvailability(): AvailabilityRoom {
        return $this->availability;
    }

    public function setAvailability(AvailabilityRoom $availability): void {
        $this->availability = $availability;
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
