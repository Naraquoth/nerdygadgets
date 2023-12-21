# Om te beginnen:

## 1. Instaleer de database.

## 2. Coppy .env.example naar .env en vul juiste gegevens in.

## 3. run: composer install

# Om payment tegebruiken lokaal run: 

ngrok http --host-header=localhost 80 

Vul url in de .env.



# database aanpassingen:

## 1. sensordata:

dit zijn de sql commando's die je moet uitvoeren voor de trigger's

```sql
select * from

```


# ___Instructies___

___Indien de database niet automatisch wordt geüpdatet, voer dan de volgende query uit in phpMyAdmin/MySQL workbench:

CREATE TABLE `sliderimage` (
  `ImagePath` varchar(255) NOT NULL,
  `SliderID` int(11) NOT NULL AUTO_INCREMENT,
  `StockItemID` int(11) NOT NULL,
  `SliderName` varchar(255) NOT NULL,
  PRIMARY KEY (`SliderID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

___Dit creëert de tabel die nodig is voor de slider
___Daarna kan je de slider gebruiken door naar addbanner.php te gaan en hier bestanden to te voegen. 
___Standaard zullen er 3 sliders meegeleverd worden, om deze toe te voegen aan de database, voer de volgende queries uit:

INSERT INTO `sliderimage` (`ImagePath`, `SliderID`, `StockItemID`, `SliderName`)
VALUES
	('Pub/Banner/Slider-1.png', 1, 16, 'slider1');

 INSERT INTO `sliderimage` (`ImagePath`, `SliderID`, `StockItemID`, `SliderName`)
VALUES
	('Pub/Banner/Slider-2.png', 2, 34, 'slider2');

INSERT INTO `sliderimage` (`ImagePath`, `SliderID`, `StockItemID`, `SliderName`)
VALUES
	('Pub/Banner/Slider-3.jpg', 3, 28, 'slider3');