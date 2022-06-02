import sys
import serial

if (len(sys.argv) < 2):
	print ("Usage: relayread.py <PORT> <RELAYNUM>\nEg: relayread.py COM1 0")
	sys.exit(0)
else:
	portName = sys.argv[1];
	relayNum = sys.argv[2];

#Open port for communication
try:
	serPort = serial.Serial(portName, 19200, timeout=1)

	#Send "relay read" command
	command = "relay read "+ str(relayNum) + "\n\r"
	serPort.write(command.encode())

	response = serPort.read(25).decode()

	if(response.find("on") > 0):
		#aqui se programa cuando se tiene el relay prendido
		print ("Relay " + str(relayNum) +" is ON")
		
	elif(response.find("off") > 0):
		#aqui se programa cuando se tiene el relay apagado
		print ("Relay " + str(relayNum) +" is OFF")

	#Close the port
	serPort.close()
	print(1)
except OSError as err:
	print("ERROR: no se pudo ejecutar la orden.. ",err)
	sys.exit(0)
