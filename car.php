<?php

class Car {
    private $id;
    private $model;
    private $make;
    private $type;
    private $regYear;
    private $bDesc;
    private $pricePerDay;
    private $peopleCapacity;
    private $suitcasesCapacity;
    private $color;
    private $fuel;
    private $avgPetroleum;
    private $horsepower;
    private $length;
    private $width;
    private $photo1;
    private $photo2;
    private $photo3;
    private $plateNumber;
    private $status;

    // Constructor
    public function __construct($record) {
        $this->model = $record['model'];
        $this->make = $record['carmake'];
        $this->type = $record['cartype'];
        $this->regYear = $record['year'];
        $this->bDesc = $record['description'];
        $this->pricePerDay = $record['price'];
        $this->peopleCapacity = $record['peoplecapacity'];
        $this->suitcasesCapacity = $record['suitcasescapacity'];
        $this->color = $record['color'];
        $this->fuel = $record['fuel'];
        $this->avgPetroleum = $record['avgpet'];
        $this->horsepower = $record['horsepower'];
        $this->length = $record['length'];
        $this->width = $record['width'];
        $this->photo1 = $record['photo1'];
        $this->photo2 = $record['photo2'];
        $this->photo3 = $record['photo3'];
        $this->plateNumber = $record['plateNumber'];
        $this->status = $record['status'];
    }

    public function displayCarPage() {
        // Split description into sentences
        $descSentences = explode('.', $this->bDesc);
        $description = '';
        foreach ($descSentences as $sentence) {
            $sentence = trim($sentence);
            if (!empty($sentence)) {
                $description .= "<li>{$sentence}.</li>";
            }
        }
    
        // Generate HTML for product details and rent button
       // Generate HTML for product details and rent button
$row = <<<HTML
<div class="car-container">
    <div class="car-image">
        <img src="carsImages/{$this->photo1}" alt="{$this->photo1}" width="220">
        <img src="carsImages/{$this->photo2}" alt="{$this->photo2}" width="220">
        <img src="carsImages/{$this->photo3}" alt="{$this->photo3}" width="220">

    </div>
    <div class="car-details">
        <h1><strong>Car Model: {$this->model}</strong></h1>
        <ul>
            <li>Make: {$this->make}</li>
            <li>Type: {$this->type}</li>
            <li>Registration year: {$this->regYear}</li>
            <li>Color: {$this->color}</li>
            <li>Price Per Day: {$this->pricePerDay}</li>
            <li>People Capacity: {$this->peopleCapacity}</li>
            <li>Suitcases Capacity: {$this->suitcasesCapacity}</li>
            <li>Fuel type: {$this->fuel}</li>
            <li>Average Petroleum: {$this->avgPetroleum}</li>
            <li>Horsepower: {$this->horsepower}</li>
            <li>Length: {$this->length}</li>
            <li>Width: {$this->width}</li>
            <li>Status: {$this->status}</li>
        </ul>
        <section>
            <h1><strong>Description:</strong></h1>
            <ul>
                {$description}
            </ul>
        </section>
        <form method="post" action="RentCar.php">
            <input type="hidden" name="model" value="{$this->model}">
            <input type="hidden" name="carmake" value="{$this->make}">
            <input type="hidden" name="cartype" value="{$this->type}">
            <input type="hidden" name="year" value="{$this->regYear}">
            <input type="hidden" name="desc" value="{$this->bDesc}">
            <input type="hidden" name="fuel" value="{$this->fuel}">
            <input type="hidden" name="price" value="{$this->pricePerDay}">
            <input type="hidden" name="peoplecapacity" value="{$this->peopleCapacity}">
            <input type="hidden" name="suitcapacity" value="{$this->suitcasesCapacity}">
            <input type="hidden" name="color" value="{$this->color}">
            <input type="hidden" name="avgP" value="{$this->avgPetroleum}">
            <input type="hidden" name="horsepower" value="{$this->horsepower}">
            <input type="hidden" name="length" value="{$this->length}">
            <input type="hidden" name="width" value="{$this->width}">
            <input type="hidden" name="photo1" value="{$this->photo1}">
            <input type="hidden" name="photo2" value="{$this->photo2}">
            <input type="hidden" name="photo3" value="{$this->photo3}">
            <input type="hidden" name="plateNumber" value="{$this->plateNumber}">
            <input type="hidden" name="status" value="{$this->status}">
            <div class="rentButton">
                <button type="submit" name="rentcar">Rent</button>
            </div>
        </form>
    </div>
</div>
HTML;

return $row;
    }
}
?>