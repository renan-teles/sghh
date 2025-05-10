<?php

interface Action {
    public function execute(ClassDAO $objectDAO): void;
}