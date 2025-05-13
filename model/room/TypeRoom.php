<?php

class TypeRoom {
    private int $id;
    private string $type;

    public function __construct(int $id, string $type) {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getType(){
        return $this->type;
    }

    public function setType(string $type){
        $this->type = $type;
    }
}