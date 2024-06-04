<?php

use Carbon\Carbon;
class Warehouse
{
    private string $owner;
    private int $productID;
    private string $productName;
    private Carbon $dateOfCreation;
    private int $quantity;

    public function __construct(string $owner,
                                int $productID,
                                string $productName,
                                Carbon $dateOfCreation,
                                int $quantity)
    {
        $this->owner = $owner;
        $this->productID = $productID;
        $this->productName = $productName;
        $this->dateOfCreation = $dateOfCreation->Carbon::now();
        $this->quantity = $quantity;
    }
    public function addNewProduct(){

    }

}