<?php

class Accommodation {
    private GuestAccommodation $guestAccommodation;
    private Room $room;
    private StatusAccommodation $statusAccommodation;
    private StatusPayment $statusPayment;
    private string $date_checkin;
    private string $date_checkout;
    private string $total_value;

    public function __construct(GuestAccommodation $guestAccommodation, Room $room, StatusAccommodation $statusAccommodation, StatusPayment $statusPayment, string $date_checkin, string $date_checkout, int $total_value){
        $this->guestAccommodation = $guestAccommodation;
        $this->room = $room;
        $this->statusAccommodation = $statusAccommodation;
        $this->statusPayment = $statusPayment;
        $this->date_checkin = $date_checkin;
        $this->date_checkout = $date_checkout;
        $this->total_value = $total_value;
    }

    public function getGuestAccommodation(): GuestAccommodation {
        return $this->guestAccommodation;
    }

    public function getRoom(): Room {
        return $this->room;
    }

    public function getStatusAccommodation(): StatusAccommodation {
        return $this->statusAccommodation;
    }

    public function getStatusPayment(): StatusPayment {
        return $this->statusPayment;
    }

    public function getDateCheckin(): string {
        return $this->date_checkin;
    }

    public function getDateCheckout(): string {
        return $this->date_checkout;
    }

    public function getTotalValue(): int {
        return $this->total_value;
    }

    public function setGuestAccommodation(GuestAccommodation $guestAccommodation): void {
        $this->guestAccommodation = $guestAccommodation;
    }
    
    public function setRoom(Room $room): void {
        $this->room = $room;
    }

    public function setStatusAccommodation(StatusAccommodation $statusAccommodation): void {
        $this->statusAccommodation = $statusAccommodation;
    }

    public function setStatusPayment(StatusPayment $statusPayment): void {
        $this->statusPayment = $statusPayment;
    }

    public function setDateCheckin(string $date_checkin): void {
        $this->date_checkin = $date_checkin;
    }

    public function setDateCheckout(string $date_checkout): void {
        $this->date_checkout = $date_checkout;
    }

    private function setTotalValue(int $total_value): void {
        $this->total_value = $total_value;
    }

    public function calculateTotalValue(int $numberOfDays): void {
        $this->setTotalValue($numberOfDays * $this->room->getDailyPrice());
    }    
}
