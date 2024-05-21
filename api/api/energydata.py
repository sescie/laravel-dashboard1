import time
import mysql.connector
import asyncio
import asyncpg
import RPi.GPIO as GPIO
from fastapi import FastAPI

GPIO.setmode(GPIO.BCM)

VOLTAGE_PIN = 26
CURRENT_PIN = 27

VOLTAGE_SENSOR_SCALE = 3.3 / 65535.0
CURRENT_SENSOR_SCALE = 3.3 / 65535.0
ACS712_OFFSET = 1.65
ACS712_SENSITIVITY = 66
RESISTOR_1 = 30002
RESISTOR_2 = 7501

db_config = {
    'user': 'your_username',
    'password': 'your_password',
    'host': 'localhost',
    'database': 'your_database_name',
}

app = FastAPI()

@app.on_event("startup")
async def startup_event():
    app.db_connection = await asyncpg.connect(**db_config)
    app.db_cursor = app.db_connection.cursor()
    await app.db_cursor.execute("""
        CREATE TABLE IF NOT EXISTS sensor_data (
            id SERIAL PRIMARY KEY,
            voltage FLOAT,
            current FLOAT,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    """)
    await app.db_connection.commit()

@app.on_event("shutdown")
async def shutdown_event():
    await app.db_cursor.close()
    await app.db_connection.close()

@app.get("/measure")
async def measure():
    while True:
        voltage = read_voltage()
        current = read_current()
        power = voltage * current
        print("Voltage: {:.2f} V, Current: {:.2f} A, Power: {:.2f} W".format(voltage, current, power))

        insert_query = "INSERT INTO sensor_data (voltage, current) VALUES ($1, $2)"
        data = (voltage, current)
        await app.db_cursor.execute(insert_query, *data)
        await app.db_connection.commit()

        await asyncio.sleep(1)

def read_voltage():
    raw_value = ADC_read(VOLTAGE_PIN)
    voltage_out = raw_value * VOLTAGE_SENSOR_SCALE
    voltage_in = voltage_out / (RESISTOR_2 / (RESISTOR_1 + RESISTOR_2))
    return voltage_in

def read_current():
    raw_value = ADC_read(CURRENT_PIN)
    voltage = raw_value * CURRENT_SENSOR_SCALE
    current = (voltage - ACS712_OFFSET) / ACS712_SENSITIVITY
    return current

def ADC_read(pin):
    GPIO.setup(pin, GPIO.IN)
    adc_value = 0
    for _ in range(10):
        adc_value += GPIO.input(pin)
    adc_value /= 10
    return adc_value

if __name__ == "__main__":
    app.run()