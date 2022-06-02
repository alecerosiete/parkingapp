import sys
import serial

if (len(sys.argv) < 2):
	print ("Usage: relaywrite.py <PORT> <RELAYNUM> <CMD>\nEg: relaywrite.py COM1 0 on")
	sys.exit(0)
else:
	portName = sys.argv[1];
	relayNum = sys.argv[2];
	relayCmd = sys.argv[3];

#Open port for communication
try:
	serPort = serial.Serial(portName, 19200, timeout=1)

	#Send the command
	command = "relay "+ str(relayCmd) +" "+ str(relayNum) + "\n\r"
	serPort.write(command.encode())

	#Close the port
	serPort.close()
	
	#return result
	print(1)
	
except OSError as err:
	print("ERROR: no se pudo ejecutar la orden.. ",err)
	sys.exit(0)
