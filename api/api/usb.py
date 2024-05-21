import serial

# Open the USB connection
ser = serial.Serial('COM14', 9600)

while True:
	# Read data from the USB connection
	data = ser.readline().decode('utf-8')
	
	# Split the data into individual values
	values = data.split(',')
	
	# Print the received data
	print(f"Count: {values[0]}, Voltage: {values[1]}, Current: {values[2]}, Power: {values[3]}, Energy: {values[4]}")
