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

Trigger voor coldroomtempratures

```sql
DELIMITER //

CREATE TRIGGER Archief
    AFTER INSERT ON coldroomtemperatures
    FOR EACH ROW
BEGIN
    IF NEW.ColdRoomSensorNumber = 5 THEN
    INSERT INTO coldroomtemperatures_archive (ColdRoomTemperatureID, ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo)
    VALUES (NEW.ColdRoomTemperatureID, NEW.ColdRoomSensorNumber, NEW.RecordedWhen, NEW.Temperature, NEW.ValidFrom, NEW.ValidTo);
END IF;
END//

DELIMITER ;
```